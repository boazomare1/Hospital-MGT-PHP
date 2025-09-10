<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTC Walk-in Services - MedStar Hospital Management</title>
    <link rel="stylesheet" type="text/css" href="css/otc_walkin_services-modern.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
</head>
<body>
<?php
session_start();
error_reporting(0);
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
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';
$docno = $_SESSION['docno'];
/// Hardcoded for quick fix
$accountname='603';
$accname_full='Cash Patient';
$paymenttype=1;
$maintype=1;
$subtype=1;	
$departmentname ='WALK IN';
$department ='24';
$consultingdoctor_name='GENERAL PRACTITIONER';
$consultingdoctorcode='03-2000-170';
$consultationtype='4954';
$scheme_id='SHM-3585';
$billingtype = 'PAY NOW';
$planname = '3585';
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];
}
						
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
		$paynowbillprefix = 'EB-';
		$paynowbillprefix1=strlen($paynowbillprefix);
		$query2 = "SELECT MAX(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(consultationid, '-', 2), '-', -1) AS UNSIGNED)) AS billnumber FROM ( SELECT consultationid FROM consultation_lab WHERE consultationid LIKE 'EB-%' UNION ALL SELECT consultationid FROM consultation_radiology WHERE consultationid LIKE 'EB-%' UNION ALL SELECT consultationid FROM consultation_services WHERE consultationid LIKE 'EB-%' ) AS consultation_ids";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		if($res2["billnumber"]=='')
		{
		$res2 = mysqli_fetch_array($exec2);
		}
		$billnumber = $res2["billnumber"]; 
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
		$billnumbercode ='EB-'.'1'."-".date('y');
		$openingbalance = '0.00';
		}
		else
		{
		$billnumber = $res2["billnumber"];
		$maxanum = $billnumber + 1;
		$billnumbercode = 'EB-' .$maxanum."-".date('y');
		$openingbalance = '0.00';
		//echo $companycode;
		}
		
		//get locationcode and locationname here for insert
		$locationcodeget=$_REQUEST['locationcodeget'];
		$locationnameget=$_REQUEST['locationnameget'];
		//get locationcode ends here
		$billnumber=$billnumbercode;
		$consultationid=$billnumber;
		$billdate=$_REQUEST['billdate'];
		$patientfirstname = $_REQUEST["customername"];
		$patientfirstname = strtoupper($patientfirstname);
		$patientmiddlename = $_REQUEST['customermiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $_REQUEST["customerlastname"];
		$patientlastname = strtoupper($patientlastname);
		$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender']; 
		$visitcode=$_REQUEST['visitcode'];
		$dateofbirth=$_REQUEST['dateofbirth'];
		$timestamp=date('H:i:s');
		$totalamount=$_REQUEST['total'];
		$consultingdoctor=$username;
		$store=$_REQUEST['store'];
		$mobilenumber  = $_REQUEST["mobilenumber"];
		$ageduration  = $_REQUEST["duration"];
		$customercode  = $_REQUEST["customercode"];
		$searchpaymentcode  = $_REQUEST["searchpaymentcode"];    
	    $status='pending';
	    $approvalstatus = '';
        patientcreate:
		
		if($searchpaymentcode=='1'){
		 $query3 = "select * from master_location as ml LEFT JOIN login_locationdetails as ll ON ml.locationcode=ll.locationcode where ll.docno = '".$docno."' order by ml.locationname";
		 $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res3 = mysqli_fetch_array($exec3);
		 $patientcodeprefix = $res3['prefix'];
		 $suffix =  date('y');
		 $patientcodeprefix1=strlen($patientcodeprefix);
		 $query2 = "select * from master_customer order by auto_number desc limit 0, 1"; 
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		 $res2customercode = $res2["customercode"];
		if ($res2customercode == '')
		{
			$customercode = $patientcodeprefix.'-'.'1'.'-'.$suffix;
			$openingbalance = '0.00';
		}
		else
		{
			$res2customercode = $res2["customercode"];
			$customercode11 = explode("-",$res2customercode);
			$customercode=$customercode11[1];
			$customercode = $customercode + 1;
			$maxanum = $customercode;
			
			$maxanum;
			$customercode = $patientcodeprefix.'-'.$maxanum.'-'.$suffix;
			$openingbalance = '0.00';
		}
		$query1 = "insert into master_customer (customercode,customername,customermiddlename,customerlastname,customerfullname,gender,age,mobilenumber,dateofbirth,registrationdate,registrationtime,ageduration,paymenttype,billtype,accountname,maintype,subtype,locationname,locationcode,username,scheme_id,planname) values ('$customercode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$gender','$age','$mobilenumber','$dateofbirth','$dateonly','$timeonly','$ageduration','$paymenttype','$billingtype','$accountname','$maintype','$subtype','$locationname','$locationcode', '$username','$scheme_id','$planname')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) ;
		if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) {
		   goto patientcreate;
		}
		else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0){
		   die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
        $patientcode= $customercode; 
		
		visitcreate:
		
		
			$query3 = "select visitcodeprefix from master_company where companystatus = 'Active'"; 
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$visitcodeprefix = $res3['visitcodeprefix'];
			$visitcodeprefix=chop($visitcodeprefix,"-");
			$query3s = "select * from master_location where status = '' and locationcode='$locationcodeget'";
			$exec3s = mysqli_query($GLOBALS["___mysqli_ston"], $query3s) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3s = mysqli_fetch_array($exec3s);
			$loc_anum = $res3s['auto_number'];
			
			$query2 = "select * from master_visitentry order by auto_number desc limit 0, 1";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec2);
			$res2 = mysqli_fetch_array($exec2);
			$res2visitcode = $res2["visitcode"];
			if($num!='')
			{
			$res2visitnum=strlen($res2visitcode);
			$vvcode6=explode("-",$res2visitcode);
			$testvalue= $vvcode6[1];
			$value6=strlen($testvalue);
			$visitcodepre6=$res2visitnum-$value6;
			}
			if ($res2visitcode == '')
			{
			$visitcode =$visitcodeprefix.'-'.'1'.'-'.$loc_anum; 
			$openingbalance = '0.00';
			}
			else
			{
			$res2visitcode = $res2["visitcode"];
			$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
			$visitcode = intval($visitcode);
			//$visitcode = $visitcode + 1;
			$visitcode = $testvalue + 1;
			$maxanum = $visitcode;
			$visitcode = $visitcodeprefix.'-'.$maxanum.'-'.$loc_anum; 
			$openingbalance = '0.00';
			}
			
			$query56="insert into master_visitentry(patientcode, visitcode,registrationdate, patientfirstname,patientmiddlename, patientlastname,patientfullname,paymenttype,subtype,billtype,accountname,consultingdoctor,consultingdoctorcode,department,departmentname,consultationdate,consultationtime,consultationfees,consultationremarks,complaint,visittype,paymentstatus,username,visitcount,doctorconsultation,consultationtype,consultationrefund,triagestatus,age,gender,accountfullname,locationcode,scheme_id,planname)values('$patientcode','$visitcode','$dateonly','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$paymenttype','$subtype','$billingtype','$accountname','$consultingdoctor_name','$consultingdoctorcode','$department','$departmentname','$dateonly','$timeonly','0','OTC WALKIN',		'1','hospital','completed','$username','1','completed','$consultationtype','torefund','completed','$age','$gender','$accname_full','$locationcodeget','$scheme_id','$planname')"; 
			$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) ;
			if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) {
			   goto visitcreate;
			}
			else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0){
			   die ("Error in query56".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		
		if(isset($_POST['dis']) && count($_POST['dis'])>1){
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
		
		$icdquery1 = "INSERT into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,primaryicdcode,secondarydiag,secicdcode,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$accname_full','$currentdate','$timestamp','$pairs111','$pairs112','$pairs113','$pairs114','$locationnameget','$locationcodeget')";
		$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}
		else{
		$pairs111='Examination and observation for other reasons';
		$pairs112='Z04';
		$icdquery1 = "insert into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,primaryicdcode,secondarydiag,secicdcode,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$accname_full','$currentdate','$timestamp','$pairs111','$pairs112','','','$locationnameget','$locationcodeget')";
		$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
	
		
		
		//Lab
		
		
		$query3 = "select labrefnoprefix from master_company where companystatus = 'Active'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$labrefnoprefix = $res3['labrefnoprefix'];
		$labrefnoprefix1=strlen($labrefnoprefix);
		$query2 = "select refno from consultation_lab order by auto_number desc limit 0, 1";
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
		}
		
		
		
		foreach($_POST['lab'] as $key=>$value)
		{
			//echo '<br>'.$k;
			$labname=$_POST['lab'][$key];
			$labname = addslashes($labname);
			$labcode=$_POST['labcode5'][$key];
			$labrate=preg_replace('[,]','',$_POST['rate5'][$key]);
			$urgentstatus='';
			if(($labname!="")&&($labrate!='')&&($labcode!=''))
			{
				
			 $query001="insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,billnumber,refno,labsamplecoll,resultentry,labrefund,urgentstatus,consultationtime,username,locationname,locationcode,approvalstatus)values('$consultationid','$patientcode','$patientfullname','$visitcode','$labcode','$labname','$labrate','$billingtype','$accname_full','$currentdate','$status','$consultationid','$labrefcode','pending','pending','norefund','$urgentstatus','$timestamp','$username','$locationnameget','$locationcodeget','$approvalstatus')"; 
			 $labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $query001) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 
			}		
		}		
		//end lab
		
		//rad
		
		$query31 = "select radrefnoprefix from master_company where companystatus = 'Active'";
		$exec31= mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$radrefnoprefix = $res31['radrefnoprefix'];
		$radrefnoprefix1=strlen($radrefnoprefix);
		$query21 = "select refno from consultation_radiology order by auto_number desc limit 0, 1";
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
		}
		
		foreach($_POST['radiology'] as $key=>$value){	
		$pairs= $_POST['radiology'][$key]; 
		$pairvar= $pairs;
	    $pairs1= preg_replace('[,]','',$_POST['rate8'][$key]);
		$pairvar1= $pairs1;
		$radiologycode=$_POST['radiologycode5'][$key];
		$urgentstatus1='';
		if(($pairvar!="")&&($radiologycode!=""))
		{
		$query1="insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,refno,resultentry,consultationtime,username,locationname,locationcode,urgentstatus,approvalstatus)values('$consultationid','$patientcode','$patientfullname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billingtype','$accname_full','$currentdate','$status','$radrefcode','pending','$timestamp','$username','$locationnameget','$locationcodeget','$urgentstatus1','$approvalstatus')";				
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		
		///rad end
		
		//ser
		
		$query3 = "select serrefnoprefix from master_company where companystatus = 'Active'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$labrefnoprefix = $res3['serrefnoprefix'];
		$labrefnoprefix1=strlen($labrefnoprefix);
		$query2 = "select refno from consultation_services order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$labrefnonumber = $res2["refno"];
		$billdigit=strlen($labrefnonumber);
		if ($labrefnonumber == '')
		{
		$serrefcode =$labrefnoprefix.'1';
		$openingbalance = '0.00';
		}
		else
		{
		$labrefnonumber = $res2["refno"];
		$serrefcode = substr($labrefnonumber,$labrefnoprefix1, $billdigit);
		$serrefcode = intval($serrefcode);
		$serrefcode = $serrefcode + 1;
		$maxanum = $serrefcode;
		$serrefcode = $labrefnoprefix.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		}
		
		
		foreach($_POST['services'] as $key=>$value)
		{ 
		//echo '<br>'.$k;
		$labname=$_POST['services'][$key];
		$servicescode=$_POST["servicescode5"][$key];
		$wellnesspkg='0';
		$labrate=$_POST['rate3'][$key];
		$serviceqty=$_POST['serviceqty'][$key];		
		$serviceamount1=$_POST['serviceamount'][$key];
		$serviceamount=(int)preg_replace('[,]','',$serviceamount1);
		$labrate=(int)preg_replace('[,]','',$labrate);
		$wellnesspkg='0';

		$qrycheckhc = "select wellnesspkg,itemname from master_services where itemcode like '$servicescode' and status <> 'deleted'";
		$execcheckhc = mysqli_query($GLOBALS["___mysqli_ston"], $qrycheckhc) or die("Error in Qrycheckhc ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rescheckhc = mysqli_fetch_array($execcheckhc);
		$wellnesspkg=$rescheckhc['wellnesspkg'];
		if(($labname!="")&&($servicescode!=""))
		{
		$query001 ="insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,billnumber,refno,locationname,locationcode,billtype,accountname,serviceqty,amount,consultationtime,username,wellnesspkg,approvalstatus)values('$consultationid','$patientcode','$patientfullname','$visitcode','$servicescode','$labname','$labrate','$currentdate','$status','pending','$consultationid','$serrefcode','".$locationnameget."','".$locationcodeget."','$billingtype','$accname_full','$serviceqty','".$serviceamount."','$timeonly','$username','$wellnesspkg','$approvalstatus')"; 
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $query001) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		include("hcpacakge_externalconsultation.php");
		}
		}
		
		//ser end
	header("location:otc_walkin_services.php");
		exit;
}

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
.number
{
padding-left:800px;
text-align:right;
font-weight:bold;
}
-->
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
.style1 {
	font-size: 30px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
.ui-menu .ui-menu-item{ zoom:1 !important; }
.red-border{
        border: 1px solid red;
    }
.ui-menu .ui-menu-item{ zoom:1 !important; }
</style>
<?php
include ("autocompletebuild_labpkg.php");
include ("autocompletebuild_radiologypkg.php");
include ("autocompletebuild_servicespkg.php");
?>
<script src="jquery/jquery-1.11.3.min.js"></script>
<script src="js/datetimepicker_css.js"></script>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
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
<script type="text/javascript" src="js/autoservicescodesearch12_new.js"></script>
<script type="text/javascript" src="js/insertnewitemtriage2_self.js"></script>
<script type="text/javascript" src="js/insertnewitemtriage3_self.js"></script>
<script type="text/javascript" src="js/insertnewitemtriage4_self.js"></script>
<?php include ("js/dropdownlist1icd.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd.js"></script>
<?php include ("js/dropdownlist1icd1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd1.js"></script>
<script type="text/javascript" src="js/insertnewitem13.js"></script>
<script type="text/javascript" src="js/insertnewitem14.js"></script>
<script>
function dobcalc()
{
var age=document.getElementById("age").value;
var year1= new Date();
var yob=year1.getFullYear() - age;
var dob= yob+"-"+"0"+1+"-"+"0"+1;
document.getElementById("dateofbirth").value = dob;
console.log(dob);
}
function funcOnLoadBodyFunctionCall()
{
	
	funcCustomerDropDownSearch10();
	funcCustomerDropDownSearch15();
	funcCustomerDropDownSearch3();
	funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch2();
	funcOnLoadBodyFunctionCall1();
	
}
function funcOnLoadBodyFunctionCall1()
{
    
	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	
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
	 
	return true;
	 
}
	
function funcLabHideView()
{		
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
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
	 return true;
	
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
	 return true;
	 
}
function funcRadHideView()
{		
 if (document.getElementById("radid") != null) 
	{
	document.getElementById("radid").style.display = 'none';
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
function numbervaild(key)
{
	var keycode = (key.which) ? key.which : key.keyCode;
	 if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
	{
		return false;
	}
}

$(function() {
$('#customersearch').autocomplete({
		
	source:'ajaxselfcustomernewsearch.php', 
	//alert(source);
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var patientfirstname = ui.item.value;
			var customername = ui.item.customername;
			var patientmiddlename = ui.item.customermiddlename;
			var patientlastname = ui.item.customerlastname;
			var age = ui.item.age;
			var gender = ui.item.gender;
			var mobile = ui.item.mobile;
			
            
			$('#customercode').val(customercode);
			$('#customername').val(customername);
			$('#customermiddlename').val(patientmiddlename);
			$('#customerlastname').val(patientlastname);
			$('#age').val(age);
			$('#gender').val(gender);			
			$('#mobilenumber').val(mobile);			
			}
    });
});


$(document).ready(function() {
	$("input:radio[name=searchpaymenttype]").click(function () {	
		var val=this.value;	
		$("#searchpaymentcode").val(val);
		if(val =="1")
		{$("#oldsearch").hide();	
		}else{
		$("#oldsearch").show();
		}
	});
});


function validcheck()
{
	if(document.getElementById("customername").value=='')
	{
		alert("Please select the patient First Name");
		document.getElementById("customername").focus();
		return false;
	}
	
	
	if (isNaN(document.getElementById("age").value))
	{
		alert ("Please Enter Number to Age");
		document.getElementById("age").focus();
		return false;
	}
	if(document.getElementById("gender").value=='')
	{
		alert("Please select the Gender");
		document.getElementById("gender").focus();
		return false;
	}
	
	
	if(document.getElementById("insertrow13").childNodes.length < 2)
	{
	 alert("Please Enter the primary disease");
	 document.getElementById("dis").focus();
	  return false;
	}
	
	document.getElementById("Submit222").disabled=true;
	
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	if (varUserChoice == false)
	{
		document.getElementById("Submit222").disabled=false;
		return false;
	}
	else
	{
		FuncPopup();
		document.form1.submit();		
	}
}
function FuncPopup()
{
	window.scrollTo(0,0);
	document.body.style.overflow='auto';
	document.getElementById("imgloader").style.display = "";
	//return false;
}
function validatenumerics(key) {
   //getting key code of pressed key
   var keycode = (key.which) ? key.which : key.keyCode;
   //comparing pressed keycodes
   if (keycode > 31 && (keycode < 48 || keycode > 57)) {
	   //alert(" You can enter only characters 0 to 9 ");
	   return false;
   }
   else return true;

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
	var varDeleteID14= delID14;
	var fRet14; 
	fRet14 = confirm('Are You Sure Want To Delete This Entry?'); 
	if (fRet14 == false)
	{
		return false;
	}
	var child14 = document.getElementById('idTR'+varDeleteID14);  
    var parent14 = document.getElementById('insertrow14'); // tbody name.
	document.getElementById ('insertrow14').removeChild(child14);
	
	var child14= document.getElementById('idTRaddtxt'+varDeleteID14);  //tr name
    var parent14 = document.getElementById('insertrow14'); // tbody name.
	
	if (child14 != null) 
	{
		document.getElementById ('insertrow14').removeChild(child14);
	}
}
function btnDeleteClick1(delID1,vrate1)
{
var vrate1 = vrate1;
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
	newtotal3= parseFloat(currenttotal3)-parseFloat(vrate1);
	newtotal3=newtotal3.toFixed(2);
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3;

}
function btnDeleteClick5(delID5,radrate)
{
var radrate=radrate;
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	//alert(delID5);
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
	//alert(child2);
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert(parent2);
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	radrate=Number(radrate.replace(/[^0-9\.]+/g,""));
	var currenttotal2=document.getElementById('total2').value;

	newtotal2= parseFloat(currenttotal2)-parseFloat(radrate);
	newtotal2=newtotal2.toFixed(2);
	
	document.getElementById('total2').value=newtotal2;
	
	
}
function btnDeleteClick3(delID3,vrate3)
{
var vrate3=vrate3;
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
	vrate3=Number(vrate3.replace(/[^0-9\.]+/g,""));
	var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1=parseFloat(currenttotal1)-parseFloat(vrate3);
	newtotal1=newtotal1.toFixed(2);
	//alert(newtotal);
	document.getElementById('total3').value=newtotal1;
}
function checkptdet()
{
	if(document.getElementById("customername").value=='')
	{
		alert("Please select the patient First Name");
		document.getElementById("customername").focus();
		return false;
	}
	
	if (isNaN(document.getElementById("age").value))
	{
		alert ("Please Enter Number to Age");
		document.getElementById("age").focus();
		return false;
	}
	if(document.getElementById("gender").value=='')
	{
		alert("Please select the Gender");
		document.getElementById("gender").focus();
		return false;
	}
	
}
</script>
</head>
<?php
	$paynowbillprefix = 'EB-';
		$paynowbillprefix1=strlen($paynowbillprefix);
		$query2 = "SELECT MAX(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(consultationid, '-', 2), '-', -1) AS UNSIGNED)) AS billnumber FROM ( SELECT consultationid FROM consultation_lab WHERE consultationid LIKE 'EB-%' UNION ALL SELECT consultationid FROM consultation_radiology WHERE consultationid LIKE 'EB-%' UNION ALL SELECT consultationid FROM consultation_services WHERE consultationid LIKE 'EB-%' ) AS consultation_ids";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		if($res2["billnumber"]=='')
		{
		$res2 = mysqli_fetch_array($exec2);
		}
		$billnumber = $res2["billnumber"]; 
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
		$billnumbercode ='EB-'.'1'."-".date('y');
		$openingbalance = '0.00';
		}
		else
		{
		$billnumber = $res2["billnumber"];
		$maxanum = $billnumber + 1;
		$billnumbercode = 'EB-' .$maxanum."-".date('y');
		$openingbalance = '0.00';
		//echo $companycode;
		}
?>     

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="imgloader">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <p><strong>Saving</strong></p>
            <p>Please Wait...</p>
        </div>
    </div>

    <!-- Modern Header -->
    <header class="modern-header">
        <div class="header-content">
            <div class="hospital-logo">
                <div class="hospital-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="hospital-info">
                    <h1>MedStar Hospital Management</h1>
                    <p>OTC Walk-in Services System</p>
                </div>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($username, 0, 2)); ?>
                </div>
                <div class="user-details">
                    <h3><?php echo $username; ?></h3>
                    <p><?php echo $companyname; ?></p>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <div class="breadcrumb-content">
            <div class="breadcrumb">
                <a href="dashboard.php">Dashboard</a>
                <span class="breadcrumb-separator">›</span>
                <a href="patient_management.php">Patient Management</a>
                <span class="breadcrumb-separator">›</span>
                <span>OTC Walk-in Services</span>
            </div>
        </div>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admissionlist.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Admission List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipbeddiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Bed Discount</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbed.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Add Bed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancysummary.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Bed Occupancy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedtransferlist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Bed Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="otc_walkin_services.php" class="nav-link active">
                            <i class="fas fa-walking"></i>
                            <span>OTC Walk-in</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <div class="page-icon">
                    <i class="fas fa-walking"></i>
                </div>
                <div>
                    <h1>OTC Walk-in Services</h1>
                    <p class="page-subtitle">Register walk-in patients and manage their laboratory, radiology, and other services</p>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="patient_list.php" class="action-btn">
                    <i class="fas fa-list"></i>
                    View Patients
                </a>
                <a href="service_management.php" class="action-btn">
                    <i class="fas fa-cogs"></i>
                    Manage Services
                </a>
                <a href="billing_dashboard.php" class="action-btn">
                    <i class="fas fa-chart-line"></i>
                    Billing Dashboard
                </a>
            </div>
        </div>

        <form name="form1" id="frmsales" method="post" action="" onSubmit="return validcheck()">
            <!-- Hidden Fields -->
            <input type="hidden" name="opdate" id="opdate" value="<?= date('Y-m-d') ?>">
            <input type="hidden" name="ipaddress" id="ipaddress" value="<?php echo $ipaddress; ?>">
            <input type="hidden" name="entrytime" id="entrytime" value="<?php echo $timeonly; ?>">   
            <input type="hidden" name="locationnameget" id="locationnameget" value="<?php echo $locationname;?>">
            <input type="hidden" name="locationcodeget" id="locationcodeget" value="<?php echo $locationcode;?>">
            <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode;?>">
            <input name="billtype" id="billtype" value="<?php echo $billingtype;?>" type="hidden">
            <input name="billtypes" id="billtypes" value="<?php echo $billingtype;?>" type="hidden">
            <input name="paymenttype" id="paymenttype" value="<?php echo $paymenttype;?>" type="hidden">
            <input name="payment" id="payment" value="<?php echo $paymenttype;?>" type="hidden">
            <input name="subtypeano" id="subtypeano" value="<?php echo $subtype;?>" type="hidden">
            <input name="subtype" id="subtype" value="CASH" type="hidden">
            <input name="dateofbirth" id="dateofbirth" value="" type="hidden">

            <!-- Patient Details -->
            <div class="form-container">
                <div class="form-header">
                    <div class="form-header-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2>Patient Details</h2>
                    <div style="margin-left: auto; color: var(--white);">
                        <strong>Location: <?php echo $locationname; ?></strong>
                    </div>
                </div>
                <div class="form-body">
                    <!-- Patient Type Selection -->
                    <div class="patient-type-selection">
                        <div class="patient-type-options">
                            <div class="radio-group">
                                <input type="radio" name="searchpaymenttype" id="searchpaymenttype11" value="1">
                                <label for="searchpaymenttype11">New Patient</label>
                            </div>
                            <div class="radio-group">
                                <input type="radio" name="searchpaymenttype" id="searchpaymenttype12" value="2">
                                <label for="searchpaymenttype12">Existing Patient</label>
                            </div>
                        </div>
                        <input type="hidden" name="searchpaymentcode" id="searchpaymentcode">
                    </div>

                    <!-- Patient Search (for existing patients) -->
                    <div class="patient-search" id="oldsearch" style="display: none;">
                        <h3>
                            <div class="patient-search-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            Patient Search
                        </h3>
                        <input name="customersearch" id="customersearch" class="form-control" value="" autocomplete="off" placeholder="Search for existing patient...">
                    </div>

                    <!-- Patient Information -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="customername">First Name *</label>
                            <input name="customername" id="customername" class="form-control" value="" autocomplete="off" placeholder="Enter first name">
                            <input type="hidden" name="customercode" id="customercode" value="">
                            <input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>">
                        </div>
                        <div class="form-group">
                            <label for="customermiddlename">Middle Name</label>
                            <input name="customermiddlename" id="customermiddlename" class="form-control" value="" autocomplete="off" placeholder="Enter middle name">
                        </div>
                        <div class="form-group">
                            <label for="customerlastname">Last Name *</label>
                            <input name="customerlastname" id="customerlastname" class="form-control" value="" autocomplete="off" placeholder="Enter last name">
                        </div>
                        <div class="form-group">
                            <label for="age">Age *</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="text" name="age" id="age" class="form-control" value="" onKeyUp="return dobcalc();" onKeyPress="return validatenumerics(event);" autocomplete="off" placeholder="Age" style="flex: 1;">
                                <select name="duration" id="duration" class="form-control form-select" style="flex: 1;">
                                    <option value="YEARS">YEARS</option>
                                    <option value="MONTHS">MONTHS</option>
                                    <option value="DAYS">DAYS</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender *</label>
                            <select name="gender" id="gender" class="form-control form-select">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mobilenumber">Mobile Number</label>
                            <input name="mobilenumber" id="mobilenumber" class="form-control" value="" type="text" autocomplete="off" placeholder="Enter mobile number">
                        </div>
                        <div class="form-group">
                            <label for="billdate">Bill Date</label>
                            <input type="text" name="billdate" id="billdate" class="form-control" value="<?php echo $dateonly; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="billno">Bill Number</label>
                            <input type="text" name="billno" id="billno" class="form-control" value="<?php echo $billnumbercode; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="billtype">Bill Type</label>
                            <input name="billtype" id="billtype" class="form-control" value="PAY NOW" type="text" readonly>
                        </div>
                    </div>
                </div>
            </div>
		
            <!-- Laboratory Services -->
            <div class="services-section">
                <div class="services-header" onclick="toggleServiceSection(this)">
                    <div class="services-header-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h3>Laboratory Services</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="services-content">
                    <table class="service-items-table">
                        <thead>
                            <tr>
                                <th>Laboratory Test</th>
                                <th>Rate</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="insertrow1">
                            <!-- Lab services will be added here dynamically -->
                        </tbody>
                    </table>
                    
                    <!-- Add Lab Service Form -->
                    <div class="add-service-form">
                        <div class="add-service-grid">
                            <div class="form-group">
                                <label for="lab">Laboratory Test</label>
                                <input name="lab[]" id="lab" type="text" class="form-control" autocomplete="off" onclick="checkptdet()" placeholder="Enter lab test name">
                                <input type="hidden" name="labcode" id="labcode" value="">
                            </div>
                            <div class="form-group">
                                <label for="rate5">Rate</label>
                                <input name="rate5[]" type="text" id="rate5" class="form-control" readonly placeholder="Rate">
                                <input type="hidden" id="r1" readonly>
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" name="Add1" id="Add1" onClick="insertitem2()" class="add-service-btn">
                                    <i class="fas fa-plus"></i>
                                    Add Lab Test
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="serial1" id="serial1" value="1"> 
                        <input type="hidden" name="serialnumber1" id="serialnumber17" value="1">
                        <input type="hidden" name="hiddenlab" id="hiddenlab">
                    </div>
                    
                    <!-- Lab Total -->
                    <div class="service-totals">
                        <div class="service-total-label">Laboratory Total</div>
                        <div class="service-total-amount">
                            <input type="text" id="total1" readonly style="border: none; background: none; text-align: right; font-weight: bold; color: var(--success-color);">
                        </div>
                    </div>
                </div>
            </div> 
            <!-- Radiology Services -->
            <div class="services-section">
                <div class="services-header" onclick="toggleServiceSection(this)">
                    <div class="services-header-icon">
                        <i class="fas fa-x-ray"></i>
                    </div>
                    <h3>Radiology Services</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="services-content">
                    <table class="service-items-table">
                        <thead>
                            <tr>
                                <th>Radiology Test</th>
                                <th>Rate</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="insertrow2">
                            <!-- Radiology services will be added here dynamically -->
                        </tbody>
                    </table>
                    
                    <!-- Add Radiology Service Form -->
                    <div class="add-service-form">
                        <div class="add-service-grid">
                            <div class="form-group">
                                <label for="radiology">Radiology Test</label>
                                <input name="radiology[]" id="radiology" type="text" class="form-control" autocomplete="off" onclick="checkptdet()" placeholder="Enter radiology test name">
                                <input type="hidden" name="radiologycode" id="radiologycode" value="">
                            </div>
                            <div class="form-group">
                                <label for="rate8">Rate</label>
                                <input name="rate8[]" type="text" id="rate8" class="form-control" readonly placeholder="Rate">
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" name="Add2" id="Add2" onClick="return insertitem3()" class="add-service-btn">
                                    <i class="fas fa-plus"></i>
                                    Add Radiology Test
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="serialnumber2" id="serialnumber27" value="1">
                        <input type="hidden" name="hiddenradiology" id="hiddenradiology" value="">
                    </div>
                    
                    <!-- Radiology Total -->
                    <div class="service-totals">
                        <div class="service-total-label">Radiology Total</div>
                        <div class="service-total-amount">
                            <input type="text" id="total2" readonly style="border: none; background: none; text-align: right; font-weight: bold; color: var(--success-color);">
                        </div>
                    </div>
                </div>
            </div>

            <!-- General Services -->
            <div class="services-section">
                <div class="services-header" onclick="toggleServiceSection(this)">
                    <div class="services-header-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h3>General Services</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="services-content">
                    <table class="service-items-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Base Rate</th>
                                <th>Base Unit</th>
                                <th>Incr Qty</th>
                                <th>Incr Rate</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="insertrow3">
                            <!-- Services will be added here dynamically -->
                        </tbody>
                    </table>
                    
                    <!-- Add Service Form -->
                    <div class="add-service-form">
                        <div class="add-service-grid">
                            <div class="form-group">
                                <label for="services">Service</label>
                                <input name="services[]" type="text" id="services" class="form-control" autocomplete="off" onclick="checkptdet()" placeholder="Enter service name">
                                <input type="hidden" name="servicescode" id="servicescode" value="">
                            </div>
                            <div class="form-group">
                                <label for="rate3">Base Rate</label>
                                <input name="rate3[]" type="text" id="rate3" class="form-control" readonly placeholder="Base Rate">
                            </div>
                            <div class="form-group">
                                <label for="baseunit">Base Unit</label>
                                <input name="baseunit[]" type="text" id="baseunit" class="form-control" readonly placeholder="Base Unit">
                            </div>
                            <div class="form-group">
                                <label for="incrqty">Incr Qty</label>
                                <input name="incrqty[]" type="text" id="incrqty" class="form-control" readonly placeholder="Incr Qty">
                            </div>
                            <div class="form-group">
                                <label for="incrrate">Incr Rate</label>
                                <input name="incrrate[]" type="text" id="incrrate" class="form-control" readonly placeholder="Incr Rate">
                                <input name="slab[]" type="hidden" id="slab" readonly>
                                <input type='hidden' name='pkg2[]' id='pkg2'>
                            </div>
                            <div class="form-group">
                                <label for="serviceqty">Qty</label>
                                <input name="serviceqty[]" type="text" id="serviceqty" class="form-control" autocomplete="off" onKeyDown="return numbervaild(event)" onKeyUp="return sertotal()" placeholder="Qty">
                            </div>
                            <div class="form-group">
                                <label for="serviceamount">Amount</label>
                                <input name="serviceamount[]" type="text" id="serviceamount" class="form-control" readonly placeholder="Amount">
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" name="Add3" id="Add3" onClick="insertitem4()" class="add-service-btn">
                                    <i class="fas fa-plus"></i>
                                    Add Service
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
                        <input type="hidden" name="hiddenservices" id="hiddenservices">
                    </div>
                    
                    <!-- Services Total -->
                    <div class="service-totals">
                        <div class="service-total-label">Services Total</div>
                        <div class="service-total-amount">
                            <input type="text" id="total3" readonly style="border: none; background: none; text-align: right; font-weight: bold; color: var(--success-color);">
                        </div>
                    </div>
                </div>
            </div>
			
            <!-- Primary Disease Section -->
            <div class="services-section">
                <div class="services-header" onclick="toggleServiceSection(this)">
                    <div class="services-header-icon">
                        <i class="fas fa-disease"></i>
                    </div>
                    <h3>Primary Disease</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="services-content">
                    <table class="service-items-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Disease</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="insertrow13">
                            <!-- Primary diseases will be added here dynamically -->
                        </tbody>
                    </table>
                    
                    <!-- Add Primary Disease Form -->
                    <div class="add-service-form">
                        <div class="add-service-grid">
                            <div class="form-group">
                                <label for="dis">Primary Disease</label>
                                <input name="dis[]" id="dis" type="text" class="form-control" autocomplete="off" placeholder="Enter primary disease name">
                                <input type="hidden" name="diseas" id="diseas" value="">
                            </div>
                            <div class="form-group">
                                <label for="code">Disease Code</label>
                                <input name="code[]" type="text" id="code" class="form-control" readonly placeholder="Disease Code">
                                <input name="autonum" type="hidden" id="autonum" readonly>
                                <input name="searchdisease1hiddentextbox" type="hidden" id="searchdisease1hiddentextbox">
                                <input name="chapter[]" type="hidden" id="chapter" readonly>
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" name="Add2" id="Add2" onClick="return insertitem13()" class="add-service-btn">
                                    <i class="fas fa-plus"></i>
                                    Add Primary Disease
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="serialnumberdisease" id="serialnumberdisease" value="1">
                    </div>
                </div>
            </div>


            <!-- Secondary Disease Section -->
            <div class="services-section">
                <div class="services-header" onclick="toggleServiceSection(this)">
                    <div class="services-header-icon">
                        <i class="fas fa-disease"></i>
                    </div>
                    <h3>Secondary Disease</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="services-content">
                    <table class="service-items-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Disease</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="insertrow14">
                            <!-- Secondary diseases will be added here dynamically -->
                        </tbody>
                    </table>
                    
                    <!-- Add Secondary Disease Form -->
                    <div class="add-service-form">
                        <div class="add-service-grid">
                            <div class="form-group">
                                <label for="dis1">Secondary Disease</label>
                                <input name="dis1[]" id="dis1" type="text" class="form-control" autocomplete="off" placeholder="Enter secondary disease name">
                                <input type="hidden" name="diseas1" id="diseas1" value="">
                            </div>
                            <div class="form-group">
                                <label for="code1">Disease Code</label>
                                <input name="code1[]" type="text" id="code1" class="form-control" readonly placeholder="Disease Code">
                                <input name="autonum1" type="hidden" id="autonum1" readonly>
                                <input name="searchdisease1hiddentextbox1" type="hidden" id="searchdisease1hiddentextbox1">
                                <input name="chapter1[]" type="hidden" id="chapter1" readonly>
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" name="Add2" id="Add2" onClick="return insertitem14()" class="add-service-btn">
                                    <i class="fas fa-plus"></i>
                                    Add Secondary Disease
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="serialnumberdisease1" id="serialnumberdisease1" value="1">
                    </div>
                </div>
            </div>
			
			
            <!-- Grand Total Section -->
            <div class="grand-total-section">
                <div class="grand-total-display">
                    <div class="grand-total-label">Grand Total</div>
                    <div class="grand-total-amount" id="grand-total-display">$0.00</div>
                </div>
                <input type="text" id="grandtotal" readonly style="display: none;">
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <input type="hidden" name="frm1submit1" value="frm1submit1" />
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-secondary" onclick="clearForm()">
                    <i class="fas fa-undo"></i>
                    Clear Form
                </button>
                <button type="submit" class="btn btn-success" id="Submit222" accesskey="s">
                    <i class="fas fa-save"></i>
                    Save (Alt+S)
                </button>
            </div>
        </form>
    </div>

    <!-- Include Modern JavaScript -->
    <script type="text/javascript" src="js/otc_walkin_services-modern.js"></script>

    <!-- Include Required JavaScript Files -->
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
    <script type="text/javascript" src="js/automedicinecodesearch5kiambu1.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/autocomplete_purchaseorder.js"></script>
    <script type="text/javascript" src="js/autosuggestpurchaseorder.js"></script>
    <script type="text/javascript" src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/otc_walkin_services.js"></script>
    
    <script>
    $(document).ready(function(e) {
        $("#searchpaymenttype12").trigger('click');
        $("#customersearch").focus();
    });
    
    // Clear form function
    function clearForm() {
        if (confirm('Are you sure you want to clear the form? All entered data will be lost.')) {
            document.getElementById('frmsales').reset();
            document.getElementById('insertrow1').innerHTML = '';
            document.getElementById('insertrow2').innerHTML = '';
            document.getElementById('insertrow3').innerHTML = '';
            document.getElementById('insertrow13').innerHTML = '';
            document.getElementById('insertrow14').innerHTML = '';
            document.getElementById('total1').value = '';
            document.getElementById('total2').value = '';
            document.getElementById('total3').value = '';
            document.getElementById('grandtotal').value = '';
            document.getElementById('grand-total-display').textContent = '$0.00';
        }
    }
    </script>

            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/otc_walkin_services-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>