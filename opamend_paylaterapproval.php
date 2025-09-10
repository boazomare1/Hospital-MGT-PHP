<?php
session_start();
error_reporting(0);
set_time_limit(0);
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
$balancelimit=0;
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
	
	
	for($i=1;$i<30;$i++)
	{		

		$labapprovalstatus = isset($_POST['labcheck'][$i])?'1':'0';
		
		
		if($_REQUEST["labcashinput".$i]!='' && $_REQUEST["labcashinput".$i]!=0 ){ $labapprovalstatus = $_REQUEST['myHiddencash'.$i]; }
		
		if($_REQUEST["myapprovalstatus".$i]==1 &&  $labapprovalstatus!=0){ $labapprovalstatus = 1; }
		
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
	
	for($i=1;$i<30;$i++)
	{	
		
		$radapprovalstatus = isset($_POST['radcheck'][$i])?'1':'0';
		
		if($_REQUEST["radcashinput".$i]!='' && $_REQUEST["radcashinput".$i]!=0 ){ $radapprovalstatus = $_REQUEST['myHiddencash_rad'.$i]; }
		
		if($_REQUEST["myapprovalstatus_rad".$i]==1 &&  $radapprovalstatus!=0){ $radapprovalstatus = 1; }
		
		$radapprovalstatus = isset($_POST['radlatertonow'][$i])?'2':$radapprovalstatus;
		
		if (isset($_REQUEST["radcashinput".$i])) { $radcashcopay = $_REQUEST["radcashinput".$i]; } else { $radcashcopay = "0"; }
		
		$radcheck=$_POST['radanum'][$i];
		
		
		if($radcheck!='' && $radapprovalstatus=='0')
		{ 
			mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set approvalstatus='$radapprovalstatus',cash_copay='$radcashcopay',paymentstatus='pending' where auto_number='$radcheck' and patientvisitcode='$visitcode'");
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
				mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set approvalstatus='$radapprovalstatus',cash_copay='$radcashcopay',paymentstatus='$status'".$rateup."  where auto_number='$radcheck' and patientvisitcode='$visitcode'");
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
				mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set approvalstatus='$radapprovalstatus',cash_copay='$radcashcopay',paymentstatus='pending'".$rateup." where auto_number='$radcheck' and patientvisitcode='$visitcode'");
				$counter=$counter + 1;
		}
	
	
	} 
	
	
	for($i=0;$i<30;$i++)
	{
		
	$serapprovalstatus = isset($_POST['sercheck'][$i])?'1':'0';
	
	if($_REQUEST["sercashinput".$i]!='' && $_REQUEST["sercashinput".$i]!=0 ){ $serapprovalstatus = $_REQUEST['myHiddencash_ser'.$i]; }
	
	if($_REQUEST["myapprovalstatus_ser".$i]==1 &&  $serapprovalstatus!=0){ $serapprovalstatus = 1; }
	
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


		header("location:approvallist.php");
	
		exit;
}


if(isset($_REQUEST['delete']))
{
$auto_number=$_REQUEST['delete'];
$viscode=$_REQUEST['visitcode'];
$remove=$_REQUEST['remove'];

if($remove=='lab'){
$data=mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number,patientcode,patientvisitcode,patientname,refno,labitemcode,labitemname,labitemrate from consultation_lab where auto_number='$auto_number'");
$data1=mysqli_fetch_array($data);
$patientname=$data1['patientname'];
$patientcode=$data1['patientcode'];
$visitcode=$data1['patientvisitcode'];
$refno=$data1['refno'];
$medicinecode=$data1['labitemcode'];
$medicinename=$data1['labitemname'];
$rate=$data1['labitemrate'];
$autonum=$data1['auto_number'];
$remarks=stripslashes(urldecode($_REQUEST['remarks-'.$autonum]));
 $date=date('Y-m-d'); 
$time=date('H:i:s');
if($medicinecode<>'')
{
 $query="insert into amendment_details (patientcode,visitcode,patientname,refno,itemcode,itemname,rate,amenddate,amendtime,amendfrom,amendby,ipaddress,remarks) values ('$patientcode','$visitcode','$patientname','$refno','$medicinecode','$medicinename','$rate','$date','$time','lab','$username','$ipaddress','$remarks')";
mysqli_query($GLOBALS["___mysqli_ston"], $query)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
}
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_lab where auto_number='$auto_number' and patientvisitcode='$viscode'");
}

if($remove=='radiology'){
$data=mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number,patientcode,patientvisitcode,patientname,refno,radiologyitemcode,radiologyitemname,radiologyitemrate from consultation_radiology where auto_number='$auto_number'");
$data1=mysqli_fetch_array($data);
$patientname=$data1['patientname'];
$patientcode=$data1['patientcode'];
$visitcode=$data1['patientvisitcode'];
$refno=$data1['refno'];
$medicinecode=$data1['radiologyitemcode'];
$medicinename=$data1['radiologyitemname'];
$rate=$data1['radiologyitemrate'];
$autonum=$data1['auto_number'];
$remarks=stripslashes(urldecode($_REQUEST['remarks-'.$autonum]));
 $date=date('Y-m-d'); 
$time=date('H:i:s');
if($medicinecode<>'')
{
 $query="insert into amendment_details (patientcode,visitcode,patientname,refno,itemcode,itemname,rate,amenddate,amendtime,amendfrom,amendby,ipaddress,remarks) values ('$patientcode','$visitcode','$patientname','$refno','$medicinecode','$medicinename','$rate','$date','$time','radiology','$username','$ipaddress','$remarks')";
mysqli_query($GLOBALS["___mysqli_ston"], $query)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
}
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where auto_number='$auto_number' and patientvisitcode='$viscode'");
}

if($remove=='service'){
$data=mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number,patientcode,patientvisitcode,patientname,refno,servicesitemcode,servicesitemname,servicesitemrate,serviceqty,amount from consultation_services where auto_number='$auto_number'") or die("Error in data".mysqli_error($GLOBALS["___mysqli_ston"]));
$data1=mysqli_fetch_array($data);
$patientname=$data1['patientname'];
$patientcode=$data1['patientcode'];
$visitcode=$data1['patientvisitcode'];
$refno=$data1['refno'];
$medicinecode=$data1['servicesitemcode'];
$medicinename=$data1['servicesitemname'];
$rate=$data1['servicesitemrate'];
$serviceqty=$data1['serviceqty'];
$amount=$data1['amount'];
$autonum=$data1['auto_number'];
$remarks=stripslashes(urldecode($_REQUEST['remarks-'.$autonum]));
 $date=date('Y-m-d'); 
$time=date('H:i:s');
if($medicinecode<>'')
{
 $query="insert into amendment_details (patientcode,visitcode,patientname,refno,itemcode,itemname,rate,qty,amount,amenddate,amendtime,amendfrom,amendby,ipaddress,remarks) values ('$patientcode','$visitcode','$patientname','$refno','$medicinecode','$medicinename','$rate','$serviceqty','$amount','$date','$time','services','$username','$ipaddress','$remarks')";
mysqli_query($GLOBALS["___mysqli_ston"], $query)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
}
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_services where auto_number='$auto_number' and patientvisitcode='$viscode'");
}

}





if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}

$thismonth = date('Y-m-');

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
$planpercentage = $resplanname['planpercentage'];
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
$viscode = $_REQUEST["visitcode"];
?>
<link href="css/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="jquery/jquery-ui.js"></script>
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
<script src="js/datetimepicker_css.js"></script>
 <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
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
</head>
<script type="text/javascript">

 document.addEventListener('keydown', function(event) {
            var key = event.key || event.keyCode;
            if (key === 'Delete' || key === 46) {
                event.preventDefault();
              
            }
 });
	
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

function myLabCalculateFunction(sno, evt)
{
	if (document.getElementById('labcashinput'+sno).readOnly) {
                event.preventDefault();
                return false;
    }		
			
	var balance=0;
	var cashamount=0;
	var labcopayamount=0;
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 8 ){
		
		if(parseFloat(document.getElementById("pharmitemrate"+sno).value.replace(/,/g,''))<parseFloat(document.getElementById("labcashinput"+sno).value.replace(/,/g,'')))
		{
			alert("Cash Copay Amount Should Not Be More Than The Lab Amount");
			document.getElementById("labcashinput"+sno).value='';
			document.getElementById("labcopayamount"+sno).value='';
			
			document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),'')));
			document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),'')));
			
			var labasno=document.getElementById("labsno").value;
			var avatot=0;
			var nettot=0;
			for(i=1;i<=labasno;i++)
			{
			var s=i;
			if((document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true) && document.getElementById('myapprovalstatus'+s).value!='2' && document.getElementById('mypaymentstatus'+s).value!='pending')
			{
				var cashamount = document.getElementById('labcashinput'+s).value;
				var pharmamt = document.getElementById('pharmitemrate'+s).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus'+s).value=='0' || document.getElementById('myapprovalstatus'+s).value=='' || document.getElementById('myapprovalstatus'+s).value=='1') && document.getElementById('mypaymentstatus'+s).value=='pending' && (document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true))
			{
		
				var cashamount = document.getElementById('labcashinput'+s).value;
				var pharmamt = document.getElementById('pharmitemrate'+s).value;
				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			}
			}
			
			
			var radsno=document.getElementById("radsno").value;
			var avatot_rad=0;
			var nettot_rad=0;
			for(j=1;j<=radsno;j++)
			{
			var a=j;

			if((document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true) && document.getElementById('myapprovalstatus_rad'+a).value!='2' && document.getElementById('mypaymentstatus_rad'+a).value!='pending')
			{
				var cashamount = document.getElementById('radcashinput'+a).value;
				var pharmamt = document.getElementById('raditemrate'+a).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus_rad'+a).value=='0' || document.getElementById('myapprovalstatus_rad'+a).value==''|| document.getElementById('myapprovalstatus_rad'+a).value=='1') && document.getElementById('mypaymentstatus_rad'+a).value=='pending' && (document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true))
			{

				var cashamount = document.getElementById('radcashinput'+a).value;
				var pharmamt = document.getElementById('raditemrate'+a).value;

				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));

			}
			}
		
			var sersno=document.getElementById("sersno").value;
			var avatot_ser=0;
			var nettot_ser=0;
			for(j=1;j<=sersno;j++)
			{
			var a=j;

			if((document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true) && document.getElementById('myapprovalstatus_ser'+a).value!='2' && document.getElementById('mypaymentstatus_ser'+a).value!='pending')
			{
				var cashamount = document.getElementById('sercashinput'+a).value;
				var pharmamt = document.getElementById('seritemrate'+a).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus_ser'+a).value=='0' || document.getElementById('myapprovalstatus_ser'+a).value==''|| document.getElementById('myapprovalstatus_ser'+a).value=='1') && document.getElementById('mypaymentstatus_ser'+a).value=='pending' && (document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true))
			{

				var cashamount = document.getElementById('sercashinput'+a).value;
				var pharmamt = document.getElementById('seritemrate'+a).value;

				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));

			}
			}
		
			document.getElementById("approvallimit").value=formatMoney(parseFloat(avatot)+parseFloat(avatot_rad)+parseFloat(avatot_ser));
			document.getElementById("total1").value=formatMoney(parseFloat(nettot)+parseFloat(nettot_rad)+parseFloat(nettot_ser));
			balanceamt();
			
			return false;
		} 
		else 
		{
		var cashamount = document.getElementById('labcashinput'+sno).value;
		var labcopayamount = document.getElementById('labcashfixed'+sno).value;
		var balance = labcopayamount - cashamount;
		document.getElementById('labcopayamount'+sno).value = balance.toFixed(2);
		
		var labasno=document.getElementById("labsno").value;
		var avatot=0;
		var nettot=0;
		for(i=1;i<=labasno;i++)
		{
		var s=i;

		if((document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true) && document.getElementById('myapprovalstatus'+s).value!='2' && document.getElementById('mypaymentstatus'+s).value!='pending')
		{
			var cashamount = document.getElementById('labcashinput'+s).value;
			var pharmamt = document.getElementById('pharmitemrate'+s).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus'+s).value=='0' || document.getElementById('myapprovalstatus'+s).value==''|| document.getElementById('myapprovalstatus'+s).value=='1') && document.getElementById('mypaymentstatus'+s).value=='pending' && (document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true))
		{

			var cashamount = document.getElementById('labcashinput'+s).value;
			var pharmamt = document.getElementById('pharmitemrate'+s).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
		
		
		var radsno=document.getElementById("radsno").value;
		var avatot_rad=0;
		var nettot_rad=0;
		for(j=1;j<=radsno;j++)
		{
		var a=j;

		if((document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true) && document.getElementById('myapprovalstatus_rad'+a).value!='2' && document.getElementById('mypaymentstatus_rad'+a).value!='pending')
		{
			var cashamount = document.getElementById('radcashinput'+a).value;
			var pharmamt = document.getElementById('raditemrate'+a).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus_rad'+a).value=='0' || document.getElementById('myapprovalstatus_rad'+a).value==''|| document.getElementById('myapprovalstatus_rad'+a).value=='1') && document.getElementById('mypaymentstatus_rad'+a).value=='pending' && (document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true))
		{

			var cashamount = document.getElementById('radcashinput'+a).value;
			var pharmamt = document.getElementById('raditemrate'+a).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
		
		var sersno=document.getElementById("sersno").value;
		var avatot_ser=0;
		var nettot_ser=0;
		for(j=1;j<=sersno;j++)
		{
		var a=j;

		if((document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true) && document.getElementById('myapprovalstatus_ser'+a).value!='2' && document.getElementById('mypaymentstatus_ser'+a).value!='pending')
		{
			var cashamount = document.getElementById('sercashinput'+a).value;
			var pharmamt = document.getElementById('seritemrate'+a).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus_ser'+a).value=='0' || document.getElementById('myapprovalstatus_ser'+a).value==''|| document.getElementById('myapprovalstatus_ser'+a).value=='1') && document.getElementById('mypaymentstatus_ser'+a).value=='pending' && (document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true))
		{

			var cashamount = document.getElementById('sercashinput'+a).value;
			var pharmamt = document.getElementById('seritemrate'+a).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
	
		document.getElementById("approvallimit").value=formatMoney(parseFloat(avatot)+parseFloat(avatot_rad)+parseFloat(avatot_ser));
		document.getElementById("total1").value=formatMoney(parseFloat(nettot)+parseFloat(nettot_rad)+parseFloat(nettot_ser));
		balanceamt();
		}
	
	}
	
}


function myRadCalculateFunction(sno, evt)
{
	if (document.getElementById('radcashinput'+sno).readOnly) {
                event.preventDefault();
                return false;
    }		
			
	var balance=0;
	var cashamount=0;
	var labcopayamount=0;
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 8 ){
		
		if(parseFloat(document.getElementById("raditemrate"+sno).value.replace(/,/g,''))<parseFloat(document.getElementById("radcashinput"+sno).value.replace(/,/g,'')))
		{
			alert("Cash Copay Amount Should Not Be More Than The Radiology Amount");
			document.getElementById("radcashinput"+sno).value='';
			document.getElementById("radcopayamount"+sno).value='';
			
			document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),'')));
			document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),'')));
			
			
			var radsno=document.getElementById("radsno").value;
			var avatot_rad=0;
			var nettot_rad=0;
			for(j=1;j<=radsno;j++)
			{
			var a=j;

			if((document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true) && document.getElementById('myapprovalstatus_rad'+a).value!='2' && document.getElementById('mypaymentstatus_rad'+a).value!='pending')
			{
				var cashamount = document.getElementById('radcashinput'+a).value;
				var pharmamt = document.getElementById('raditemrate'+a).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus_rad'+a).value=='0' || document.getElementById('myapprovalstatus_rad'+a).value==''|| document.getElementById('myapprovalstatus_rad'+a).value=='1') && document.getElementById('mypaymentstatus_rad'+a).value=='pending' && (document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true))
			{

				var cashamount = document.getElementById('radcashinput'+a).value;
				var pharmamt = document.getElementById('raditemrate'+a).value;

				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));

			}
			}
		
			var labasno=document.getElementById("labsno").value;
			var avatot=0;
			var nettot=0;
			for(i=1;i<=labasno;i++)
			{
			var s=i;
			if((document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true) && document.getElementById('myapprovalstatus'+s).value!='2' && document.getElementById('mypaymentstatus'+s).value!='pending')
			{
				var cashamount = document.getElementById('labcashinput'+s).value;
				var pharmamt = document.getElementById('pharmitemrate'+s).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus'+s).value=='0' || document.getElementById('myapprovalstatus'+s).value=='' || document.getElementById('myapprovalstatus'+s).value=='1') && document.getElementById('mypaymentstatus'+s).value=='pending' && (document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true))
			{
		
				var cashamount = document.getElementById('labcashinput'+s).value;
				var pharmamt = document.getElementById('pharmitemrate'+s).value;
				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			}
			}
			
			
			var sersno=document.getElementById("sersno").value;
			var avatot_ser=0;
			var nettot_ser=0;
			for(j=1;j<=sersno;j++)
			{
			var a=j;

			if((document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true) && document.getElementById('myapprovalstatus_ser'+a).value!='2' && document.getElementById('mypaymentstatus_ser'+a).value!='pending')
			{
				var cashamount = document.getElementById('sercashinput'+a).value;
				var pharmamt = document.getElementById('seritemrate'+a).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus_ser'+a).value=='0' || document.getElementById('myapprovalstatus_ser'+a).value==''|| document.getElementById('myapprovalstatus_ser'+a).value=='1') && document.getElementById('mypaymentstatus_ser'+a).value=='pending' && (document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true))
			{

				var cashamount = document.getElementById('sercashinput'+a).value;
				var pharmamt = document.getElementById('seritemrate'+a).value;

				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));

			}
			}
		
			
			document.getElementById("approvallimit").value=formatMoney(parseFloat(avatot)+parseFloat(avatot_rad)+parseFloat(avatot_ser));
			document.getElementById("total1").value=formatMoney(parseFloat(nettot)+parseFloat(nettot_rad)+parseFloat(nettot_ser));
			balanceamt();
			
			return false;
		} 
		else 
		{
		var cashamount = document.getElementById('radcashinput'+sno).value;
		var labcopayamount = document.getElementById('radcashfixed'+sno).value;
		var balance = labcopayamount - cashamount;
		document.getElementById('radcopayamount'+sno).value = balance.toFixed(2);
		
		
		
		var radsno=document.getElementById("radsno").value;

		var avatot_rad=0;
		var nettot_rad=0;
		for(j=1;j<=radsno;j++)
		{
		var a=j;

		if((document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true) && document.getElementById('myapprovalstatus_rad'+a).value!='2' && document.getElementById('mypaymentstatus_rad'+a).value!='pending')
		{
			var cashamount = document.getElementById('radcashinput'+a).value;
			var pharmamt = document.getElementById('raditemrate'+a).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus_rad'+a).value=='0' || document.getElementById('myapprovalstatus_rad'+a).value==''|| document.getElementById('myapprovalstatus_rad'+a).value=='1') && document.getElementById('mypaymentstatus_rad'+a).value=='pending' && (document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true))
		{

			var cashamount = document.getElementById('radcashinput'+a).value;
			var pharmamt = document.getElementById('raditemrate'+a).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
		
		
		var labasno=document.getElementById("labsno").value;
		var avatot=0;
		var nettot=0;
		for(i=1;i<=labasno;i++)
		{
		var s=i;

		if((document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true) && document.getElementById('myapprovalstatus'+s).value!='2' && document.getElementById('mypaymentstatus'+s).value!='pending')
		{
			var cashamount = document.getElementById('labcashinput'+s).value;
			var pharmamt = document.getElementById('pharmitemrate'+s).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus'+s).value=='0' || document.getElementById('myapprovalstatus'+s).value==''|| document.getElementById('myapprovalstatus'+s).value=='1') && document.getElementById('mypaymentstatus'+s).value=='pending' && (document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true))
		{

			var cashamount = document.getElementById('labcashinput'+s).value;
			var pharmamt = document.getElementById('pharmitemrate'+s).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
		
		
		var sersno=document.getElementById("sersno").value;
		var avatot_ser=0;
		var nettot_ser=0;
		for(j=1;j<=sersno;j++)
		{
		var a=j;

		if((document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true) && document.getElementById('myapprovalstatus_ser'+a).value!='2' && document.getElementById('mypaymentstatus_ser'+a).value!='pending')
		{
			var cashamount = document.getElementById('sercashinput'+a).value;
			var pharmamt = document.getElementById('seritemrate'+a).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus_ser'+a).value=='0' || document.getElementById('myapprovalstatus_ser'+a).value==''|| document.getElementById('myapprovalstatus_ser'+a).value=='1') && document.getElementById('mypaymentstatus_ser'+a).value=='pending' && (document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true))	
		{

			var cashamount = document.getElementById('sercashinput'+a).value;
			var pharmamt = document.getElementById('seritemrate'+a).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
	
		document.getElementById("approvallimit").value=formatMoney(parseFloat(avatot)+parseFloat(avatot_rad)+parseFloat(avatot_ser));
		document.getElementById("total1").value=formatMoney(parseFloat(nettot)+parseFloat(nettot_rad)+parseFloat(nettot_ser));
		balanceamt();
		}
	
	}
	
}


function mySerCalculateFunction(sno, evt)
{
	if (document.getElementById('sercashinput'+sno).readOnly) {
                event.preventDefault();
                return false;
    }		
			
	var balance=0;
	var cashamount=0;
	var labcopayamount=0;
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 8 ){
		
		if(parseFloat(document.getElementById("seritemrate"+sno).value.replace(/,/g,''))<parseFloat(document.getElementById("sercashinput"+sno).value.replace(/,/g,'')))
		{
			alert("Cash Copay Amount Should Not Be More Than The Service Amount");
			document.getElementById("sercashinput"+sno).value='';
			document.getElementById("sercopayamount"+sno).value='';
			
			document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),'')));
			document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),'')));
			
			
			var radsno=document.getElementById("radsno").value;
			var avatot_rad=0;
			var nettot_rad=0;
			for(j=1;j<=radsno;j++)
			{
			var a=j;

			if((document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true) && document.getElementById('myapprovalstatus_rad'+a).value!='2' && document.getElementById('mypaymentstatus_rad'+a).value!='pending')
			{
				var cashamount = document.getElementById('radcashinput'+a).value;
				var pharmamt = document.getElementById('raditemrate'+a).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus_rad'+a).value=='0' || document.getElementById('myapprovalstatus_rad'+a).value==''|| document.getElementById('myapprovalstatus_rad'+a).value=='1') && document.getElementById('mypaymentstatus_rad'+a).value=='pending' && (document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true))
			{

				var cashamount = document.getElementById('radcashinput'+a).value;
				var pharmamt = document.getElementById('raditemrate'+a).value;

				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));

			}
			}
		
			var labasno=document.getElementById("labsno").value;
			var avatot=0;
			var nettot=0;
			for(i=1;i<=labasno;i++)
			{
			var s=i;
			if((document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true) && document.getElementById('myapprovalstatus'+s).value!='2' && document.getElementById('mypaymentstatus'+s).value!='pending')
			{
				var cashamount = document.getElementById('labcashinput'+s).value;
				var pharmamt = document.getElementById('pharmitemrate'+s).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus'+s).value=='0' || document.getElementById('myapprovalstatus'+s).value=='' || document.getElementById('myapprovalstatus'+s).value=='1') && document.getElementById('mypaymentstatus'+s).value=='pending' && (document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true))
			{
		
				var cashamount = document.getElementById('labcashinput'+s).value;
				var pharmamt = document.getElementById('pharmitemrate'+s).value;
				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			}
			}
			
			
			var sersno=document.getElementById("sersno").value;
			var avatot_ser=0;
			var nettot_ser=0;
			for(j=1;j<=sersno;j++)
			{
			var a=j;

			if((document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true) && document.getElementById('myapprovalstatus_ser'+a).value!='2' && document.getElementById('mypaymentstatus_ser'+a).value!='pending')
			{
				var cashamount = document.getElementById('sercashinput'+a).value;
				var pharmamt = document.getElementById('seritemrate'+a).value;
				if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
				
				avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
		
			} else if((document.getElementById('myapprovalstatus_ser'+a).value=='0' || document.getElementById('myapprovalstatus_ser'+a).value==''|| document.getElementById('myapprovalstatus_ser'+a).value=='1') && document.getElementById('mypaymentstatus_ser'+a).value=='pending' && (document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true))
			{

				var cashamount = document.getElementById('sercashinput'+a).value;
				var pharmamt = document.getElementById('seritemrate'+a).value;

				if(cashamount==''){ cashamount=0; pharmamt=0;}
				
				avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
				nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));

			}
			}
		
			
			document.getElementById("approvallimit").value=formatMoney(parseFloat(avatot)+parseFloat(avatot_rad)+parseFloat(avatot_ser));
			document.getElementById("total1").value=formatMoney(parseFloat(nettot)+parseFloat(nettot_rad)+parseFloat(nettot_ser));
			balanceamt();
			
			return false;
		} 
		else 
		{
		var cashamount = document.getElementById('sercashinput'+sno).value;
		var labcopayamount = document.getElementById('sercashfixed'+sno).value;
		var balance = labcopayamount - cashamount;
		document.getElementById('sercopayamount'+sno).value = balance.toFixed(2);
		
		
		
		var radsno=document.getElementById("radsno").value;
		var avatot_rad=0;
		var nettot_rad=0;
		for(j=1;j<=radsno;j++)
		{
		var a=j;

		if((document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true) && document.getElementById('myapprovalstatus_rad'+a).value!='2' && document.getElementById('mypaymentstatus_rad'+a).value!='pending')
		{
			var cashamount = document.getElementById('radcashinput'+a).value;
			var pharmamt = document.getElementById('raditemrate'+a).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus_rad'+a).value=='0' || document.getElementById('myapprovalstatus_rad'+a).value==''|| document.getElementById('myapprovalstatus_rad'+a).value=='1') && document.getElementById('mypaymentstatus_rad'+a).value=='pending' && (document.getElementById('radlatertonow'+a).checked == true || document.getElementById('radcheck'+a).checked == true))
		{

			var cashamount = document.getElementById('radcashinput'+a).value;
			var pharmamt = document.getElementById('raditemrate'+a).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot_rad=parseFloat(avatot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_rad=parseFloat(nettot_rad)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
		
		
		var labasno=document.getElementById("labsno").value;
		var avatot=0;
		var nettot=0;
		for(i=1;i<=labasno;i++)
		{
		var s=i;

		if((document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true) && document.getElementById('myapprovalstatus'+s).value!='2' && document.getElementById('mypaymentstatus'+s).value!='pending')
		{
			var cashamount = document.getElementById('labcashinput'+s).value;
			var pharmamt = document.getElementById('pharmitemrate'+s).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus'+s).value=='0' || document.getElementById('myapprovalstatus'+s).value==''|| document.getElementById('myapprovalstatus'+s).value=='1') && document.getElementById('mypaymentstatus'+s).value=='pending' && (document.getElementById('lablatertonow'+s).checked == true || document.getElementById('labcheck'+s).checked == true))
		{

			var cashamount = document.getElementById('labcashinput'+s).value;
			var pharmamt = document.getElementById('pharmitemrate'+s).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot=parseFloat(avatot)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot=parseFloat(nettot)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
		
		
		var sersno=document.getElementById("sersno").value;
		var avatot_ser=0;
		var nettot_ser=0;
		for(j=1;j<=sersno;j++)
		{
		var a=j;

		if((document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true) && document.getElementById('myapprovalstatus_ser'+a).value!='2' && document.getElementById('mypaymentstatus_ser'+a).value!='pending')
		{
			var cashamount = document.getElementById('sercashinput'+a).value;
			var pharmamt = document.getElementById('seritemrate'+a).value;
			if(cashamount=='' || cashamount==0){ cashamount=0; pharmamt=0;}
			
			avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
	
		} else if((document.getElementById('myapprovalstatus_ser'+a).value=='0' || document.getElementById('myapprovalstatus_ser'+a).value==''|| document.getElementById('myapprovalstatus_ser'+a).value=='1') && document.getElementById('mypaymentstatus_ser'+a).value=='pending' && (document.getElementById('serlatertonow'+a).checked == true || document.getElementById('sercheck'+a).checked == true))	
		{

			var cashamount = document.getElementById('sercashinput'+a).value;
			var pharmamt = document.getElementById('seritemrate'+a).value;

			if(cashamount==''){ cashamount=0; pharmamt=0;}
			
			avatot_ser=parseFloat(avatot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));
			nettot_ser=parseFloat(nettot_ser)+(parseFloat(pharmamt)-parseFloat(cashamount));

		}
		}
		
		
		
		document.getElementById("approvallimit").value=formatMoney(parseFloat(avatot)+parseFloat(avatot_rad)+parseFloat(avatot_ser));
		document.getElementById("total1").value=formatMoney(parseFloat(nettot)+parseFloat(nettot_rad)+parseFloat(nettot_ser));
		balanceamt();
		}
	
	}
	
}



function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function selectcash(checkname,sno)
{
	var sno = sno;
	var cashamount=0;
	if(checkname=='lab')
	{
		if(document.getElementById('lablatertonow'+sno).checked == true)
		{
			
			if(document.getElementById('labcheck'+sno).checked == true)
			{
				
				document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))-(document.getElementById("pharmitemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))-(document.getElementById("pharmitemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),''))-(document.getElementById("pharmitemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				balanceamt();
			}
			
			
			document.getElementById('labcheck'+sno).checked =false;
			document.getElementById('labcheck'+sno).disabled =true;
			
			
		}
		else
		{
			document.getElementById('labcheck'+sno).disabled=false;		
			cashamount = document.getElementById('labcashinput'+sno).value;
			
			if(document.getElementById('labcashinput'+sno).value !='' && document.getElementById('labcashinput'+sno).value !=0)
			{	
			document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))-(document.getElementById("pharmitemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
			document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))-(document.getElementById("pharmitemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
			} 
			
			balanceamt();
			document.getElementById('labcashinput'+sno).value = '';
			
		}
	}
	
	if(checkname=='rad')
	{
		if(document.getElementById('radlatertonow'+sno).checked == true)
		{
			
			if(document.getElementById('radcheck'+sno).checked == true)
			{
				
				document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))-(document.getElementById("raditemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))-(document.getElementById("raditemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),''))-(document.getElementById("raditemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				balanceamt();
			}
			
			
			document.getElementById('radcheck'+sno).checked =false;
			document.getElementById('radcheck'+sno).disabled =true;
			
			
		}
		else
		{
			document.getElementById('radcheck'+sno).disabled=false;		
			cashamount = document.getElementById('radcashinput'+sno).value;
			
			if(document.getElementById('radcashinput'+sno).value !='' && document.getElementById('radcashinput'+sno).value !=0)
			{	
			document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))-(document.getElementById("raditemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
			document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))-(document.getElementById("raditemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
			} 
			
			balanceamt();
			document.getElementById('radcashinput'+sno).value = '';
			
		}
	}
	
	if(checkname=='ser')
	{
		if(document.getElementById('serlatertonow'+sno).checked == true)
		{
			
			if(document.getElementById('sercheck'+sno).checked == true)
			{
				
				document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))-(document.getElementById("seritemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))-(document.getElementById("seritemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),''))-(document.getElementById("seritemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
				balanceamt();
			}
			
			
			document.getElementById('radcheck'+sno).checked =false;
			document.getElementById('radcheck'+sno).disabled =true;
			
			
		}
		else
		{
			document.getElementById('sercheck'+sno).disabled=false;		
			cashamount = document.getElementById('sercashinput'+sno).value;
			
			if(document.getElementById('sercashinput'+sno).value !='' && document.getElementById('sercashinput'+sno).value !=0)
			{	
			document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))-(document.getElementById("seritemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
			document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))-(document.getElementById("seritemrate"+sno).value.replace(RegExp(',', 'g'),'')-parseFloat(cashamount)));
			} 
			
			balanceamt();
			document.getElementById('sercashinput'+sno).value = '';
			
		}
	}
}

function selectselect(checkname,sno)
{	
	var sno = sno;
	if(checkname=='lab')
	{
		if(document.getElementById('labcheck'+sno).checked == true)
		{

			document.getElementById('lablatertonow'+sno).checked = false;
			document.getElementById('lablatertonow'+sno).disabled=true;
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
}

function approvalfunction(nam,amount)
{
	if(document.getElementById(nam).checked==true)
	{
		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
		document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
		

		if(document.getElementById("approve").checked==false){			
		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))<(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),'')) + parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))))
		{	
				alert("Approval Amount is greater than Available Limit");
				document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));
				document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(/,/g,''))-parseFloat(amount));
				document.getElementById(nam).checked = false;
				if(document.getElementById("selectalll").checked == true){
				document.getElementById("selectalll").checked =false;
				}
				return false;
		}
		}
		document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
	}
	else
	{	
		if(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount)>0)
		{
		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));
		document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(/,/g,''))-parseFloat(amount));
		document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(/,/g,''))-parseFloat(amount));
		}
		else
		{
		document.getElementById("approvallimit").value='0.00';
		document.getElementById("total1").value='0.00';
		document.getElementById("total_check").value='0.00';
		}
		
	}
	balanceamt();
}

function selectunapprove(nam,sno)
{
	
	
	if(nam=='labunapproves'){
		
		if (confirm("Do You Want to Revoke Approval?")==false){
		document.getElementById('labunapprove'+sno).checked =false;
		return false;
		}
		
		if(document.getElementById("labunapprove"+sno).checked==true)
		{
			
			document.getElementById("grandtotal").value=formatMoney(parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))-(parseFloat(document.getElementById("pharmitemrate"+sno).value.replace(RegExp(',', 'g'),''))-parseFloat(document.getElementById("labcashinput"+sno).value.replace(RegExp(',', 'g'),''))));	
			document.getElementById("balancelimit").value=formatMoney(parseFloat(document.getElementById("availablelimit").value.replace(RegExp(',', 'g'),''))-parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),'')));	
			
			document.getElementById('labunapprove'+sno).disabled=true;
			document.getElementById('labcheck'+sno).checked =false;
			document.getElementById('labcheck'+sno).disabled =false;
			document.getElementById('lablatertonow'+sno).disabled =false;
			document.getElementById('labcashinput'+sno).value='0.00';
			document.getElementById("lablatertonow"+sno).checked=false;
			document.getElementById('myapprovalstatus'+sno).value='';
			document.getElementById('mypaymentstatus'+sno).value='';		
		}
	}
	
	if(nam=='radunapproves'){
		
		if (confirm("Do You Want to Revoke Approval?")==false){
		document.getElementById('radunapprove'+sno).checked =false;
		return false;
		}
		
		
		if(document.getElementById("radunapprove"+sno).checked==true)
		{
			
			document.getElementById("grandtotal").value=formatMoney(parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))-(parseFloat(document.getElementById("raditemrate"+sno).value.replace(RegExp(',', 'g'),''))-parseFloat(document.getElementById("radcashinput"+sno).value.replace(RegExp(',', 'g'),''))));	
			document.getElementById("balancelimit").value=formatMoney(parseFloat(document.getElementById("availablelimit").value.replace(RegExp(',', 'g'),''))-parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),'')));	
			
			document.getElementById('radunapprove'+sno).disabled=true;
			document.getElementById('radcheck'+sno).checked =false;
			document.getElementById('radcheck'+sno).disabled =false;
			document.getElementById('radlatertonow'+sno).disabled =false;
			document.getElementById('radcashinput'+sno).value='0.00';
			document.getElementById("radlatertonow"+sno).checked=false;
			document.getElementById('myapprovalstatus_rad'+sno).value='';
			document.getElementById('mypaymentstatus_rad'+sno).value='';		
		}
	}
	
	if(nam=='serunapproves'){
		
		if (confirm("Do You Want to Revoke Approval?")==false){
		document.getElementById('serunapprove'+sno).checked =false;
		return false;
		}
		
		if(document.getElementById("serunapprove"+sno).checked==true)
		{
			
			document.getElementById("grandtotal").value=formatMoney(parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))-(parseFloat(document.getElementById("seritemrate"+sno).value.replace(RegExp(',', 'g'),''))-parseFloat(document.getElementById("sercashinput"+sno).value.replace(RegExp(',', 'g'),''))));	
			document.getElementById("balancelimit").value=formatMoney(parseFloat(document.getElementById("availablelimit").value.replace(RegExp(',', 'g'),''))-parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),'')));	
			
			document.getElementById('serunapprove'+sno).disabled=true;
			document.getElementById('sercheck'+sno).checked =false;
			document.getElementById('sercheck'+sno).disabled =false;
			document.getElementById('serlatertonow'+sno).disabled =false;
			document.getElementById('sercashinput'+sno).value='0.00';
			document.getElementById("serlatertonow"+sno).checked=false;
			document.getElementById('myapprovalstatus_ser'+sno).value='';
			document.getElementById('mypaymentstatus_ser'+sno).value='';		
		}
	}
}	

function approvalfunction2(nam,sno)
{
	if(document.getElementById(nam).checked==true)
	{
	document.getElementById('labcashinput'+sno).readOnly =false;
	}else{
	document.getElementById('labcashinput'+sno).readOnly =true;	
	}
}


function approvalfunction2_rad(nam,sno)
{
	if(document.getElementById(nam).checked==true)
	{
	document.getElementById('radcashinput'+sno).readOnly =false;
	}else{
	document.getElementById('radcashinput'+sno).readOnly =true;	
	}
}


function approvalfunction2_ser(nam,sno)
{
	if(document.getElementById(nam).checked==true)
	{
	document.getElementById('sercashinput'+sno).readOnly =false;
	}else{
	document.getElementById('sercashinput'+sno).readOnly =true;	
	}
}


function approvalfunction_rad(nam,amount)
{
	
	if(document.getElementById(nam).checked==true)
	{
		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
		document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
		

		if(document.getElementById("approve").checked==false){			
		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))<(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),'')) + parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))))
		{	
				alert("Approval Amount is greater than Available Limit");
				document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));
				document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(/,/g,''))-parseFloat(amount));
				document.getElementById(nam).checked = false;
				if(document.getElementById("selectalll").checked == true){
				document.getElementById("selectalll").checked =false;
				}
				return false;
		}
		}
		document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
	}
	else
	{	
		if(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount)>0)
		{
		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));
		document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(/,/g,''))-parseFloat(amount));
		document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(/,/g,''))-parseFloat(amount));
		}
		else
		{
		document.getElementById("approvallimit").value='0.00';
		document.getElementById("total1").value='0.00';
		document.getElementById("total_check").value='0.00';
		}
		
	}
	balanceamt();
}


function approvalfunction_ser(nam,amount)
{
	
	if(document.getElementById(nam).checked==true)
	{
		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
		document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
		

		if(document.getElementById("approve").checked==false){			
		if(parseFloat(document.getElementById("availablelimit").value.replace(/,/g,''))<(parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),'')) + parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))))
		{	
				alert("Approval Amount is greater than Available Limit");
				document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));
				document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(/,/g,''))-parseFloat(amount));
				document.getElementById(nam).checked = false;
				if(document.getElementById("selectalll").checked == true){
				document.getElementById("selectalll").checked =false;
				}
				return false;
		}
		}
		document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(RegExp(',', 'g'),''))+parseFloat(amount));
	}
	else
	{	
		if(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount)>0)
		{
		document.getElementById("approvallimit").value=formatMoney(parseFloat(document.getElementById("approvallimit").value.replace(/,/g,''))-parseFloat(amount));
		document.getElementById("total1").value=formatMoney(parseFloat(document.getElementById("total1").value.replace(/,/g,''))-parseFloat(amount));
		document.getElementById("total_check").value=formatMoney(parseFloat(document.getElementById("total_check").value.replace(/,/g,''))-parseFloat(amount));
		}
		else
		{
		document.getElementById("approvallimit").value='0.00';
		document.getElementById("total1").value='0.00';
		document.getElementById("total_check").value='0.00';
		}
		
	}
	balanceamt();
}



function balanceamt(){
	//alert("SALES");
	document.getElementById("balancelimit").value=formatMoney(parseFloat(document.getElementById("availablelimit").value.replace(RegExp(',', 'g'),''))-parseFloat(document.getElementById("grandtotal").value.replace(RegExp(',', 'g'),''))-parseFloat(document.getElementById("approvallimit").value.replace(RegExp(',', 'g'),'')));
}

function alertfun() { 

	if(parseFloat(document.getElementById("balancelimit").value.replace(/,/g,''))<0)
	{
	alert("Patient Does Not have Enough Limit. Either Copay or Remove to Proceed");
	return false;
	}
	
	var labasno=document.getElementById("labsno").value;
	for(i=1;i<=labasno;i++)
	{
		var s=i;
		if(document.getElementById('lablatertonow'+s).checked == true && (document.getElementById('labcashinput'+s).value == '' || document.getElementById('labcashinput'+s).value == 0))
		{
		alert("Copay Amount Should Not Be Empty Or Zero");
		return false;
		}
	}
	
	var radsno=document.getElementById("radsno").value;
	for(j=1;j<=radsno;j++)
	{
		var a=j;
		if(document.getElementById('radlatertonow'+a).checked == true && (document.getElementById('radcashinput'+a).value == '' || document.getElementById('radcashinput'+a).value == 0))
		{
		alert("Copay Amount Should Not Be Empty Or Zero");
		return false;
		}
	}
	
	var sersno=document.getElementById("sersno").value;
	for(j=1;j<=sersno;j++)
	{
		var a=j;
		if(document.getElementById('serlatertonow'+a).checked == true && (document.getElementById('sercashinput'+a).value == '' || document.getElementById('sercashinput'+a).value == 0))
		{
		alert("Copay Amount Should Not Be Empty Or Zero");
		return false;
		}
	}
	
	if (confirm("Do You Want to Save?")==false){
		return false;
	}
	return true;
}
function deletevalid(id,type,code,visit)
{
	if(type=='lab'){
		var msg=document.getElementById('labremarks-'+id).value;
		if(msg.trim()==''){
		alert("Must have remarks.");
		document.getElementById('labremarks-'+id).focus();
		return false;
		}
		var del;
		del=confirm("Do You want to delete this lab test ?");
		if(del == false)
		{
		return false;
		}else{
			window.location='opamend_paylaterapproval.php?delete='+id+'&&patientcode='+code+'&&visitcode='+visit+'&&remarks-'+id+'='+msg+'&&remove='+type;
		}
	}
	
	if(type=='radiology'){
		var msg=document.getElementById('radremarks-'+id).value;
		if(msg.trim()==''){
		alert("Must have remarks.");
		document.getElementById('radremarks-'+id).focus();
		return false;
		}
		var del;
		del=confirm("Do You want to delete this Radiology test ?");
		if(del == false)
		{
		return false;
		}else{
			window.location='opamend_paylaterapproval.php?delete='+id+'&&patientcode='+code+'&&visitcode='+visit+'&&remarks-'+id+'='+msg+'&&remove='+type;
		}
	}
	
	if(type=='service'){
		var msg=document.getElementById('serremarks-'+id).value;
		if(msg.trim()==''){
		alert("Must have remarks.");
		document.getElementById('serremarks-'+id).focus();
		return false;
		}
		var del;
		del=confirm("Do You want to delete this Service test ?");
		if(del == false)
		{
		return false;
		}else{
			window.location='opamend_paylaterapproval.php?delete='+id+'&&patientcode='+code+'&&visitcode='+visit+'&&remarks-'+id+'='+msg+'&&remove='+type;
		}
	}
}
</script>
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="opamend_paylaterapproval.php" enctype="multipart/form-data">
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

	<tr>
	<td width="1%">&nbsp;</td>
	<td width="99%" valign="top">
	<table width="93%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td>
			<table width="89%" border="0" align="left" cellpadding="2" cellspacing="2" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			
			<tr>
				<td width="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient</strong></td>
				<td width="" align="left" valign="middle" class="bodytext3"><input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
				</td>
				<td width="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
				<td colspan="" align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?><input type="hidden" value="<?php echo $planforall;?>" name="planforall" ></td>
				
				<td width="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"  style="font-size:15px;" ><strong>Pharmacy Amount</strong></td>
				<td colspan="" align="left" valign="middle" class="bodytext3"  style="font-size:15px;" ><strong>
				<?php
				$pharmrefund1=0;
				$querybilpharm1="select (amount-cash_copay) as pharmrate,medicinecode from master_consultationpharm  where patientcode = '$patientcode' and  patientvisitcode='$viscode' and  paymentstatus = 'pending'  ";
				$execbilpharm1=mysqli_query($GLOBALS["___mysqli_ston"], $querybilpharm1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				while ($resbilpharm1=mysqli_fetch_array($execbilpharm1))
				{
				$pharmrate1=$resbilpharm1['pharmrate'];
				$medicinecode1=$resbilpharm1['medicinecode'];
				$querybilpharm11="select totalamount as refundpharm from pharmacysalesreturn_details  where patientcode = '$patientcode' and  visitcode='$viscode' and itemcode ='".$medicinecode."' ";
				$execbilpharm11=mysqli_query($GLOBALS["___mysqli_ston"], $querybilpharm11) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				while ($resbilpharm11=mysqli_fetch_array($execbilpharm11))
				{
				$pharmrate11=$resbilpharm11['refundpharm'];
				$pharmrefund1=$pharmrefund1+$pharmrate11;
				}
				$pharmcalcrate1=$pharmcalcrate1+($pharmrate1-$pharmrefund1);
				}
				?>
				<?php echo number_format($pharmcalcrate1,2,'.',','); ?></strong></td>
			</tr>
			
			<tr>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
				<td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />
				<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>" >
				<input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" >
				<input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $res111subtype;?>">
				<span class="style4"><!--Area--> </span>
				<input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $res131subtype; ?>">
				</td>
				<td width="" align="left" valign="middle"  bgcolor="#ecf0f5" style="color:red;" class="bodytext3"><strong>Company</strong></td>
				<td colspan="" align="left" valign="middle" class="bodytext3" style="color:red;">
				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<strong><?php echo $patientaccount; ?></strong>
				<input type="hidden" name="billtype" value="<?php echo $billtype; ?>">		
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>">	
				<input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />		</td>
				<td width="" align="left" valign="middle"  bgcolor="#ecf0f5"  style="color:red;" class="bodytext3"><strong>Insurance</strong></td>
				<td colspan="1" align="left" valign="top" class="bodytext3"  style="color:red;"><strong><?php echo $res131subtype; ?></strong></td>				
			</tr>
			
			<tr>
				<td width="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
				<td colspan="1" align="left" valign="top" class="bodytext3" >
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?></td>
				<td colspan="1" align="left" valign="top" class="bodytext3" ><strong>Doc Number</strong></td>
				<td colspan="1" align="left" valign="top" class="bodytext3" ><?php echo $billnumbercode; ?></td>
			</tr>
			
			<tr>
				
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
			
			
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			
			$query223="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
			$exec223=mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res223=mysqli_fetch_array($exec223);
			mysqli_num_rows($exec223);
			$availablelimit1=$res223['availablelimit'];
			$overalllimit1=$res223['overalllimit'];
			$planper=$res223['planpercentage'];
			$planname=$res223['planname'];
			$consultationfees=$res223['consultationfees'];

			$query222 = "select * from master_planname where auto_number = '$planname'";
			$exec222=mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res222=mysqli_fetch_array($exec222);
			$planfixedamount=$res222['planfixedamount'];
			$visitlimit1=$res222['opvisitlimit'];

			if($billtype!="PAY NOW")
			{
			
			$billedrate=0;
			
			
			$querybillab="select sum(labitemrate-cash_copay) as labrate from consultation_lab where patientcode = '$patientcode' and patientvisitcode='$viscode' and ((paymentstatus='completed' and approvalstatus = '2') OR (paymentstatus='completed' and  resultentry='completed'))";
			$execbillab=mysqli_query($GLOBALS["___mysqli_ston"], $querybillab) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resbillab=mysqli_fetch_array($execbillab);
			$labrate=$resbillab['labrate'];
			$billedrate = $billedrate+$labrate;
			
			$querybillrad="select sum(radiologyitemrate-cash_copay) as radrate from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'  and ((paymentstatus='completed' and approvalstatus = '2') OR (paymentstatus='completed' and  resultentry='completed'))";
			$execbil1rad=mysqli_query($GLOBALS["___mysqli_ston"], $querybillrad) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resbillrad=mysqli_fetch_array($execbil1rad);
			$radrate=$resbillrad['radrate'];
			$billedrate = $billedrate+$radrate;
			
			$querybillser="select sum(amount-cash_copay) as serrate from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'  and ((paymentstatus='completed' and approvalstatus = '2') OR (paymentstatus='completed' and  process='completed'))";
			$execbil1ser=mysqli_query($GLOBALS["___mysqli_ston"], $querybillser) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$serbillser=mysqli_fetch_array($execbil1ser);
			$serrate=$serbillser['serrate'];
			$billedrate = $billedrate+$serrate;
			
			}
			
			$pharmrefund=0;
			$querybilpharm="select amount as pharmrate,medicinecode from master_consultationpharm  where patientcode = '$patientcode' and  patientvisitcode='$viscode' and  (paymentstatus = 'completed' and  approvalstatus <> '2') ";
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
				
			$availablelimit=$availablelimit1+$planfixedamount-($consultationfees-($consultationfees*$planper/100));
			$availablelimit=$availablelimit-$pharmcalcrate-$billedrate;
			
			//approvedamt
			$query171 = "select sum(labitemrate-cash_copay) as labapprovedamount from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'  and labsamplecoll='pending' and ((paymentstatus = 'completed' and approvalstatus = '1') OR (paymentstatus = 'pending' and approvalstatus = '2'))"; 
			$exec171= mysqli_query($GLOBALS["___mysqli_ston"], $query171) or die ("Error in Query171".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res171 = mysqli_fetch_array($exec171);
			$labtotapprovedamt=$res171['labapprovedamount'];		
			$grandtotal = $grandtotal + $labtotapprovedamt;

			$query171r = "select sum(radiologyitemrate-cash_copay) as radapprovedamount from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'  and prepstatus='pending' and ((paymentstatus = 'completed' and approvalstatus = '1') OR (paymentstatus = 'pending' and approvalstatus = '2'))"; 
			$exec171r= mysqli_query($GLOBALS["___mysqli_ston"], $query171r) or die ("Error in Query171r".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res171r = mysqli_fetch_array($exec171r);
			$radtotapprovedamt=$res171r['radapprovedamount'];		
			$grandtotal = $grandtotal + $radtotapprovedamt;
			
			$query171s = "select sum(amount-cash_copay) as serapprovedamount from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'  and process='pending' and ((paymentstatus = 'completed' and approvalstatus = '1') OR (paymentstatus = 'pending' and approvalstatus = '2'))"; 
			$exec171s= mysqli_query($GLOBALS["___mysqli_ston"], $query171s) or die ("Error in Query171s".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res171s = mysqli_fetch_array($exec171s);
			$serapprovedamount=$res171s['serapprovedamount'];		
			$grandtotal = $grandtotal + $serapprovedamount;

			
			?>
			<tr>
				<td  colspan="1" class="bodytext3" style="display:none"><input type="checkbox" value="selectall" name="selectalll" id="selectalll" onClick="selectall();" hidden> </td>
				<td class="bodytext3"><strong>Available limit:</strong></td>
				<td class="bodytext3"><input size="8" type="text" name="availablelimit" id="availablelimit"  value="<?php echo number_format($availablelimit, 2, '.', ','); ?>" readonly ><span class="bodytext3" valign="right"></td>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Approved Amt :</strong></span></td>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" id="grandtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>" readonly size="7"></td><input type="hidden" name="hidgrandtotal" id="hidgrandtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>">
				<td class="bodytext3"><strong>Approval limit:</strong></td>
				<td class="bodytext3"><input size="8" type="text" name="approvallimit" id="approvallimit"  value="<?php echo number_format($approvallimit, 2, '.', ','); ?>"   readonly  ></td>
				<td class="bodytext3"><strong>Bal limit:</strong></td>
				<td class="bodytext3"><input size="8" type="text" name="balancelimit" id="balancelimit"  value="<?php echo number_format($availablelimit-$grandtotal, 2, '.', ','); ?>" readonly  ></td>
			</tr>
			</tbody>
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
		$query171lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status' and labsamplecoll='pending' and (approvalstatus='' or approvalstatus='0' or approvalstatus='1')";
		$exec171lab = mysqli_query($GLOBALS["___mysqli_ston"], $query171lab) or die ("Error in Query171lab".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num171lab = mysqli_num_rows($exec171lab);
		 $query172lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and labsamplecoll='pending' and approvalstatus='2'";
		$exec172lab = mysqli_query($GLOBALS["___mysqli_ston"], $query172lab) or die ("Error in Query172lab".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num172lab = mysqli_num_rows($exec172lab);
		$query173lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and labsamplecoll='pending' and approvalstatus = '1'";
		$exec173lab = mysqli_query($GLOBALS["___mysqli_ston"], $query173lab) or die ("Error in Query173lab".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num173lab = mysqli_num_rows($exec173lab);
		$num17lab = $num171lab + $num172lab + $num173lab;
		?>
		<tr>
		<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Lab </strong></td>
		</tr>
		
		
		
		<tr>
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="93%" align="left" border="0">
		<tbody id="foo">
		<?php if($num17lab > 0) {?>
			<tr>
			<?php if($billtype == 'PAY LATER')
			{
			?>
			<td width="6%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
			<?php } ?>
			<td width="2%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
			<td width="26%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab</strong></div></td>
			<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
			<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
			<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
			<td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks </strong></div></td>
			<?php if($billtype == 'PAY LATER')
			{
			?>
			<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
			<?php } ?>
			<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cash Copay</strong></div></td>
			<!--<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" style="display:none"><div align="left"><strong>Override</strong></div></td>-->
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Revoke Approval</strong></div></td>
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
			$query30 = "select lablimit from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30);
			$labdptlimit = $res30['lablimit'];

			$dptlimitcheck = $availablelimit;
			
			$sno_lab = 0;
			$query17 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'  and labsamplecoll='pending' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))"; 
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while ($res17 = mysqli_fetch_array($exec17))
			{
			$paharmitemname=$res17['labitemname'];				
			$pharmitemcode=$res17['labitemcode'];
			$pharmitemrate=$res17['labitemrate'];
			$labamount=$res17['pharmitemrate'];
			$labcash_copay=$res17['cash_copay'];
			$labanum=$res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];
			$paymentstatus=$res17['paymentstatus'];
			$sno_lab=$sno_lab+1;
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
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="labcheck<?php echo $sno; ?>" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"  <?php if($approvalstatus=='1' && $res17['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled"; } if($approvalstatus=='2' && $res17['paymentstatus']!='completed'){ echo "disabled=disabled";}if($approvalstatus=='2' && $res17['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled";}?>  onClick="approvalfunction(this.id,<?php echo $pharmitemrate; ?>),selectselect('lab','<?php echo $sno; ?>')" />
				<input type="hidden" name="labanum[<?php echo $sno; ?>]" id="labanum<?php echo $sno; ?>"  value="<?php echo $labanum; ?>">
				</div></td>
				<?php } ?>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><strong><?php echo number_format($pharmitemrate,2,'.',','); ?></strong></div></td>
				<input type="hidden" name="pharmitemrate<?php echo $sno; ?>" id="pharmitemrate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>">
				<td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid('<?php echo $labanum; ?>','lab','<?php echo $patientcode; ?>','<?php echo $visitcode; ?>')"  href='javascript:return false;'>Delete</a></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type = "text" name ="labremarks-<?php echo $labanum; ?>" id ="labremarks-<?php echo $labanum; ?>"></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?> 
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="lablatertonow[<?php echo $sno; ?>]" id="lablatertonow<?php echo $sno; ?>"  onClick="approvalfunction2(this.id,<?php echo $sno; ?>),selectcash('lab','<?php echo $sno; ?>')" <?php  if($approvalstatus=='2' && $res17['paymentstatus']!='completed'){ echo "checked=checked disabled=disabled";}if($approvalstatus=='2' && $res17['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled";} if($approvalstatus=='1' && $res17['paymentstatus']=='completed'){ echo "disabled=disabled"; } ?>>
				</div></td>
				<?php } ?>
				<td class="bodytext31" valign="center"  align="lefts">
				<input type="hidden" name="dptlimit" id="dptlimit" value="<?php echo $labdptlimit; ?>">
				<input type="hidden" name="dptlimitcheck" id="dptlimitcheck" value="<?php echo $dptlimitcheck; ?>">
				<input style="text-align: right;" type="hidden" name="labcopayamount<?php echo $sno; ?>" id="labcopayamount<?php echo $sno; ?>" size="8" readonly>
				<input style="text-align: right;" type="hidden" name="labcashfixed<?php echo $sno; ?>" id="labcashfixed<?php echo $sno; ?>" size="8" readonly>
				<input style="text-align: right;" type="text" name="labcashinput<?php echo $sno; ?>" id="labcashinput<?php echo $sno; ?>" size="8" onkeypress="return isNumberKey(event)" onkeyup="myLabCalculateFunction(<?php echo $sno; ?>, event)" value="<?=$labcash_copay;?>"   readonly>
				<input type="hidden" name="myHiddencash<?php echo $sno; ?>" id="myHiddencash<?php echo $sno; ?>" value="2">
				<input type="hidden" name="myapprovalstatus<?php echo $sno; ?>" id="myapprovalstatus<?php echo $sno; ?>" value="<?php echo $approvalstatus;?>">
				<input type="hidden" name="mypaymentstatus<?php echo $sno; ?>" id="mypaymentstatus<?php echo $sno; ?>" value="<?php echo $paymentstatus;?>">
				</td>
				<td class="bodytext31" valign="center"  align="left" ><div align="center">
				
				<input type="checkbox" name="labunapprove[<?php echo $sno; ?>]" id="labunapprove<?php echo $sno; ?>" onClick="selectunapprove('labunapproves','<?php echo $sno; ?>')" value="<?php echo $labanum;?>" <?php if($approvalstatus<>'2'  && $res17['paymentstatus']=='pending'){ echo "disabled=disabled"; }?>></div></td>
			</tr>
			<?php } ?>
		
		<?php	} ?>
					

		</tbody>
		</table>
		</td>
		</tr>
		
		<tr>
		<td>&nbsp;</td>
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
		$query171rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status' and prepstatus='pending' and approvalstatus<>'2'";
		$exec171rad = mysqli_query($GLOBALS["___mysqli_ston"], $query171rad) or die ("Error in Query171rad".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num171rad  = mysqli_num_rows($exec171rad);
		$query172rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and prepstatus='pending' and approvalstatus='2'";
		$exec172rad = mysqli_query($GLOBALS["___mysqli_ston"], $query172rad) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num172rad  = mysqli_num_rows($exec172rad);
		$query173rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and prepstatus='pending' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
		$exec173rad = mysqli_query($GLOBALS["___mysqli_ston"], $query173rad) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num173rad  = mysqli_num_rows($exec173rad);
		$num17rad = $num171rad + $num172rad + $num173rad;
		?>
		<tr>
			<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology </strong></td>
		</tr>
		
		<tr>	  
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="89%" align="left" border="0">
		<tbody id="foo">
		<?php if($num17rad>0) { ?>
		
			<tr>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td width="6%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
				<?php }?>
				<td width="8%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="28%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology</strong></div></td>
				<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
				<td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
				<td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks </strong></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
				<?php } ?>
				<td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cash Copay</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Revoke Approval</strong></div></td>
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
			$query30 = "select lablimit, radiologylimit, serviceslimit, pharmacylimit from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";;
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30);
			$raddptlimit = $res30['radiologylimit'];

			$raddptlimitcheck = $raddptlimit;
			$sno_rad=0;
			$sno=0;
			$query17r = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'  and prepstatus='pending' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
			$exec17r = mysqli_query($GLOBALS["___mysqli_ston"], $query17r) or die ("Error in Query17r".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while ($res17r = mysqli_fetch_array($exec17r))
			{

			$paharmitemname=$res17r['radiologyitemname'];				
			$pharmitemcode=$res17r['radiologyitemcode'];
			$pharmitemrate=$res17r['radiologyitemrate'];
			$radanum=$res17r['auto_number'];
			$approvalstatus=$res17r['approvalstatus'];	
			$paymentstatus=$res17r['paymentstatus'];	
			$radcash_copay=$res17r['cash_copay'];	
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$sno=$sno+1;
			$sno_rad=$sno_rad+1;
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
				<?php if($billtype == 'PAY LATER'){ ?>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="radcheck<?php echo $sno; ?>" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"  <?php if($approvalstatus=='1' && $res17r['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled"; } if($approvalstatus=='2' && $res17r['paymentstatus']!='completed'){ echo "disabled=disabled";}if($approvalstatus=='2' && $res17r['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled";}?> onClick="approvalfunction_rad(this.id,<?php echo $pharmitemrate; ?>),selectselect('rad','<?php echo $sno; ?>')"  />
				<input type="hidden" name="radanum[<?php echo $sno; ?>]" id="radanum<?php echo $sno; ?>"  value="<?php echo $radanum; ?>">
				</div></td>
				<?php } ?>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div>
				<input type="hidden" name="radrate<?php echo $sno; ?>" id="radrate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>"></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><label id="radtotal<?php echo $sno; ?>"><?php echo $pharmitemrate; ?></label></div></td>
				<input type="hidden" name="raditemrate<?php echo $sno; ?>" id="raditemrate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>">
				
				
				<td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid('<?php echo $radanum; ?>','radiology','<?php echo $patientcode; ?>','<?php echo $visitcode; ?>')"  href='javascript:return false;'>Delete</a></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type = "text" name ="radremarks-<?php echo $radanum; ?>" id ="radremarks-<?php echo $radanum; ?>"></div></td>
				 
				<?php if($billtype == 'PAY LATER')
				{
				?>  
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="radlatertonow[<?php echo $sno; ?>]" id="radlatertonow<?php echo $sno; ?>" onClick="approvalfunction2_rad(this.id,<?php echo $sno; ?>),selectcash('rad','<?php echo $sno; ?>')" <?php  if($approvalstatus=='2' && $res17r['paymentstatus']!='completed'){ echo "checked=checked disabled=disabled";}if($approvalstatus=='2' && $res17r['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled";} if($approvalstatus=='1' && $res17r['paymentstatus']=='completed'){ echo "disabled=disabled"; } ?> >
				</div></td>
				<?php } ?>
				<td class="bodytext31" valign="center"  align="lefts">
				<input type="hidden" name="raddptlimit" id="raddptlimit" value="<?php echo $raddptlimit; ?>">
				<input type="hidden" name="raddptlimitcheck" id="raddptlimitcheck" value="<?php echo $raddptlimitcheck; ?>">
				<input style="text-align: right;" type="hidden" name="radcopayamount<?php echo $sno; ?>" id="radcopayamount<?php echo $sno; ?>" size="8" readonly>
				<input style="text-align: right;" type="hidden" name="radcashfixed<?php echo $sno; ?>" id="radcashfixed<?php echo $sno; ?>" size="8" readonly>
				<input style="text-align: right;" type="text" name="radcashinput<?php echo $sno; ?>" id="radcashinput<?php echo $sno; ?>" size="8" onkeypress="return isNumberKey(event)" onkeyup="myRadCalculateFunction(<?php echo $sno; ?>, event)" value="<?php echo $radcash_copay; ?>" readonly>
				<input type="hidden" name="myHiddencash_rad<?php echo $sno; ?>" id="myHiddencash_rad<?php echo $sno; ?>" value="2">
				<input type="hidden" name="myapprovalstatus_rad<?php echo $sno; ?>" id="myapprovalstatus_rad<?php echo $sno; ?>" value="<?php echo $approvalstatus;?>">
				<input type="hidden" name="mypaymentstatus_trad<?php echo $sno; ?>" id="mypaymentstatus_rad<?php echo $sno; ?>" value="<?php echo $paymentstatus;?>">
				</td>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="radunapprove[<?php echo $sno; ?>]" id="radunapprove<?php echo $sno; ?>" onClick="selectunapprove('radunapproves','<?php echo $sno; ?>')" value="<?php echo $radanum;?>" <?php if($approvalstatus<>'2'  && $res17r['paymentstatus']=='pending'){ echo "disabled=disabled"; }?>>
				</div></td>
			</tr>
			<?php } ?> 
			
			<?php } ?>
		</tbody>
		</table>
		</td>
		</tr>
		
		
		<tr>
		<td>&nbsp;</td>
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
		$query171ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status' and process='pending' and approvalstatus<>'2'";
		$exec171ser = mysqli_query($GLOBALS["___mysqli_ston"], $query171ser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num171ser = mysqli_num_rows($exec171ser);
		$query172ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and process='pending' and approvalstatus='2'";
		$exec172ser = mysqli_query($GLOBALS["___mysqli_ston"], $query172ser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num172ser = mysqli_num_rows($exec172ser);
		$query173ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and process='pending' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
		$exec173ser = mysqli_query($GLOBALS["___mysqli_ston"], $query173ser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num173ser = mysqli_num_rows($exec173ser);
		$num17ser = $num171ser + $num172ser+ $num173ser;
		?>
		<tr>
		<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Services </strong></td>
		</tr>
		
		<tr>
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="89%" align="left" border="0">
		<tbody id="foo">
		<?php
		if($num17ser>0)
		{
		?>
		
		
			<tr>
			<?php if($billtype == 'PAY LATER')
			{
			?>
			<td width="6%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
			<?php } ?>
			<td width="8%" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
			<td width="28%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Services</strong></div></td>
			<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
			<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Service Qty  </strong></div></td>
			<td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
			<td width="7%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
			<td width="7%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks </strong></div></td>
			<?php if($billtype == 'PAY LATER')
			{
			?>
			<td width="7%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
			<?php } ?>
			<td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cash Copay</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Revoke Approval</strong></div></td>
			</tr>
		<?php

		
		$sno = '';
		$sno_ser = '';
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
		$serdptlimit = $res30['serviceslimit'];
		$serdptlimitcheck = $serdptlimit;
		
		$query17s = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'  and process='pending' and wellnessitem <> '1' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
		$exec17s = mysqli_query($GLOBALS["___mysqli_ston"], $query17s) or die ("Error in Query17s".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		while ($res17s = mysqli_fetch_array($exec17s))
		{

		$paharmitemname=$res17s['servicesitemname'];
		$pharmitemcode=$res17s['servicesitemcode'];
		$pharmitemrate=$res17s['servicesitemrate'];
		$seranum = $res17s['auto_number'];
		$serqty = $res17s['serviceqty'];
		$amount11 = $res17s['amount'];
		$approvalstatus=$res17s['approvalstatus'];
		$cash_copay=$res17s['cash_copay'];
		$pharmitemrate1=$pharmitemrate*$serqty;
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		$sno=$sno+1;
		$sno_ser=$sno_ser+1;
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
		<?php if($billtype == 'PAY LATER'){?>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="sercheck<?php echo $sno; ?>" name="sercheck[<?php echo $sno; ?>]" value="<?php echo $seranum; ?>"  <?php if($approvalstatus=='1' && $res17s['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled"; } if($approvalstatus=='2' && $res17s['paymentstatus']!='completed'){ echo "disabled=disabled";}if($approvalstatus=='2' && $res17s['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled";}?> onClick="approvalfunction_ser(this.id,<?php echo $amount11; ?>),selectselect('ser','<?php echo $sno; ?>')" />
		<input type="hidden" name="seranum[<?php echo $sno; ?>]" id="seranum<?php echo $sno; ?>" value="<?php echo $seranum; ?>"></div></td>
		<?php } ?>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amount11; ?></div>
		<input type="hidden" name="seritemrate<?php echo $sno; ?>" id="seritemrate<?php echo $sno; ?>" value="<?php echo $amount11; ?>"></td>
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid('<?php echo $seranum; ?>','service','<?php echo $patientcode; ?>','<?php echo $visitcode; ?>')"  href='javascript:return false;'>Delete</a></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type = "text" name ="serremarks-<?php echo $seranum; ?>" id ="serremarks-<?php echo $seranum; ?>"></div></td>
				 
				 
		<?php if($billtype == 'PAY LATER')
		{
		?> 
		<td class="bodytext31" valign="center"  align="left"><div align="center">
		<input type="checkbox" name="serlatertonow[<?php echo $sno; ?>]" id="serlatertonow<?php echo $sno; ?>"  onClick="approvalfunction2_ser(this.id,<?php echo $sno; ?>),selectcash('ser','<?php echo $sno; ?>')" <?php  if($approvalstatus=='2' && $res17s['paymentstatus']!='completed'){ echo "checked=checked disabled=disabled";}if($approvalstatus=='2' && $res17s['paymentstatus']=='completed'){ echo "checked=checked disabled=disabled";} if($approvalstatus=='1' && $res17s['paymentstatus']=='completed'){ echo "disabled=disabled"; } ?>>
		</div></td>
		<?php }?>
		<td class="bodytext31" valign="center"  align="lefts">
		<input type="hidden" name="serdptlimit" id="serdptlimit" value="<?php echo $serdptlimit; ?>">
		<input type="hidden" name="serdptlimitcheck" id="serdptlimitcheck" value="<?php echo $serdptlimitcheck; ?>">
		<input style="text-align: right;" type="hidden" name="sercopayamount<?php echo $sno; ?>" id="sercopayamount<?php echo $sno; ?>" size="8" readonly>
		<input style="text-align: right;" type="hidden" name="sercashfixed<?php echo $sno; ?>" id="sercashfixed<?php echo $sno; ?>" size="8" readonly>
		<input style="text-align: right;" type="text" name="sercashinput<?php echo $sno; ?>" id="sercashinput<?php echo $sno; ?>" size="8" onkeypress="return isNumberKey(event)" onkeyup="mySerCalculateFunction(<?php echo $sno; ?>, event)" value="<?php echo $cash_copay; ?>" readonly>
		<input type="hidden" name="myHiddencash_ser<?php echo $sno; ?>" id="myHiddencash_ser<?php echo $sno; ?>" value="2">
		<input type="hidden" name="myapprovalstatus_ser<?php echo $sno; ?>" id="myapprovalstatus_ser<?php echo $sno; ?>" value="<?php echo $approvalstatus;?>">
		<input type="hidden" name="mypaymentstatus_ser<?php echo $sno; ?>" id="mypaymentstatus_ser<?php echo $sno; ?>" value="<?php echo $paymentstatus;?>">
		</td>
		<td class="bodytext31" valign="center"  align="left"><div align="center">
		<input type="checkbox" name="serunapprove[<?php echo $sno; ?>]" id="serunapprove<?php echo $sno; ?>" onClick="selectunapprove('serunapproves','<?php echo $sno; ?>')" value="<?php echo $seranum;?>" <?php if($approvalstatus<>'2' && $res17s['paymentstatus']=='pending'){ echo "disabled=disabled"; }?>>
		</div></td>
		</tr>
		<?php } ?>
		
		<?php } ?>
		</tbody>
		</table>
		</td>
		</tr>
		
		<tr >
			<td align="right" colspan="2" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span>
			<input type="hidden" name="labsno" id="labsno" value="<?php echo $sno_lab; ?>">
			<input type="hidden" name="radsno" id="radsno" value="<?php echo $sno_rad; ?>">
			<input type="hidden" name="sersno" id="sersno" value="<?php echo $sno_ser; ?>">
			<input type="text" name="total1" id="total1" readonly size="7" value="0.00">
			<input type="hidden" name="total_check" id="total_check" readonly size="7" value="0.00">
			</td>
		</tr>
		
		<tr>
		<td>&nbsp;</td>
		</tr>	<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>        
		<td colspan="2" align="right" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
		<!--<textarea name="approvecomment" id="approvecomment" style="display:none"></textarea>
		Approve check  -->
		<input type="checkbox" value="1"  name="approve" id="approve" onClick="approvecheck();" style="display:none">
		<input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
		<?php if($planforall=='yes' && $planpercentage>0){ ?>
		Please Check In Cashier.
		<?php } else { ?>
		<input name="Submit222" type="submit"  value="Approve" onClick="return alertfun()" class="button"  style="FONT-SIZE:26px;"/>
		<?php } ?>
		<?php $grandtotal=number_format($grandtotal,2); echo '<script>document.getElementById("grandtotal").value="'.$grandtotal.'";</script>'?>
		</td>
		</tr>

	</table>
	</td>
	</tr>
</table>
</form>
</body>

