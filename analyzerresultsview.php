<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL'; 
$dateonly = date("Y-m-d");

$colorloopcount = '';
$sno = '';

$query24 = "select labrslt from master_employee where username = '$username'";
$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res24 = mysqli_fetch_array($exec24);
$labrslt = $res24['labrslt'];
?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>

<?php
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{ 

//////////////////// FOR AUDIT RESULT ENTRY //////////////////				  
 $paynowbillprefix_ad = 'ARE-';
$paynowbillprefix1_ad=strlen($paynowbillprefix_ad);
$query2_ad = "select * from audit_resultentry_lab order by auto_number desc limit 0, 1";
$exec2_ad = mysqli_query($GLOBALS["___mysqli_ston"], $query2_ad) or die ("Error in Query2_ad".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2_ad = mysqli_fetch_array($exec2_ad);
$billnumber_ad = $res2_ad["audit_id"];
$billdigit_ad=strlen($billnumber_ad);
if ($billnumber_ad == '')
{
	$billnumbercode_ad ='ARE-'.'1';
}
else
{
	$billnumber_ad = $res2_ad["audit_id"];
	$billnumbercode_ad = substr($billnumber_ad,$paynowbillprefix1_ad, $billdigit_ad);
	//echo $billnumbercode_ad;
	$billnumbercode_ad = intval($billnumbercode_ad);
	$billnumbercode_ad = $billnumbercode_ad + 1;

	$maxanum_ad = $billnumbercode_ad;
	$billnumbercode_ad = 'ARE-' .$maxanum_ad;
	//echo $companycode;
}
//////////////////// FOR AUDIT RESULT ENTRY //////////////////	


    $patientcode=$_REQUEST['patientcode'];
	$visitcode=$_REQUEST['visitcode'];
	$patientname=$_REQUEST['customername'];
	$sampleid = $_REQUEST['sampleid'];
	$sample_doc = $_REQUEST['docnumber'];
	$vtype = $_REQUEST['vtype'];

	$equipmentname = $_POST['eqname'];
		$equipmentcode = $_POST['eqid'];	
	
	if($vtype=='IP') {

		$paynowbillprefix = 'IPLRE-';
		$paynowbillprefix1=strlen($paynowbillprefix);
		$query2 = "select * from ipresultentry_lab order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$billnumber = $res2["docnumber"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
			$billnumbercode ='IPLRE-'.'1';
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber = $res2["docnumber"];
			$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
			//echo $billnumbercode;
			$billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;

			$maxanum = $billnumbercode;
			
			
			$billnumbercode = 'IPLRE-' .$maxanum;
			$openingbalance = '0.00';
			//echo $companycode;
		}

		$docnumber=$billnumbercode;

		$query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";
		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res612 = mysqli_fetch_array($exec612);
		$orderedby = $res612['username'];
		$locationcodeget = $res612['locationcode'];
 		$locationnameget = $res612['locationname'];

		$query24 = "select * from ipconsultation_lab where username = '$orderedby'";
		$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24 = mysqli_fetch_array($exec24);
		$doctorname = $res24['employeename'];

		foreach($_POST['lab'] as $key => $value)
		{
		$status1 ='norefund';
	     $labname = $_POST['lab'][$key];
		 $itemcode = $_POST['code'][$key];
		$resultvalue=$_POST['result'][$key];
		$unit=$_POST['units'][$key];
		$referencevalue=$_POST['reference'][$key];
		$refname = $_POST['referencename'][$key];
		$refcomments = $_POST['refcomments'][$key];
		$radiology= $_POST['radiology'][$key];
		 			
		$color = $_POST['color'][$key];
		
		if($resultvalue != '')
		{
			$query26="insert into ipresultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,color,username,sampleid,doctorname,locationname,locationcode,referencecomment,updatedatetime,radiology,equipmentcode,equipmentname)values('$patientname','$patientcode',
		'$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$color','$username','$sampleid','$doctorname','".$locationnameget."','".$locationcodeget."','$refcomments','$updatedatetime','$radiology','$equipmentcode','$equipmentname')";
			$exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


				// FOR AUDIT ENTRY
				$query262="INSERT into audit_resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,referencecomments,radiology,color,sampleid,username,equipmentcode,equipmentname,audit_id,datetime,ipaddress,locationname,locationcode,doctorname)values('$patientname','$patientcode',
				'$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$refcomments','$radiology','$color','$sampleid','$username','$equipmentcode','$equipmentname','$billnumbercode_ad','$updatedatetime','$ipaddress','$locationnameget','$locationcodeget','$doctorname')";
				// $equipmentcode','$equipmentname
				$exec262=mysqli_query($GLOBALS["___mysqli_ston"], $query262) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   // FOR AUDIT ENTRY

		}
		
		
			
				$status1='completed';
			
				
				$query76 = "update ipsamplecollection_lab set resultentry='$status1' where itemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'";
				 $exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 
				$query77 = "update ipresultentry_lab set resultstatus='completed' where docnumber='$docnumber'";
				$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$query77_arl = "update audit_resultentry_lab set resultstatus='completed' where docnumber='$docnumber'";
				$exec77_arl = mysqli_query($GLOBALS["___mysqli_ston"], $query77_arl) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$query29="update ipconsultation_lab set resultentry='$status1' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and docnumber='$docnumber'";
				 $exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29);

				$query43 = "update pending_test_orders set publishstatus='completed',publishdatetime='".date('Y-m-d h:i:s')."',resultdatetime='".date('Y-m-d h:i:s')."' where sample_id='$sample_doc' and testcode='$itemcode' and visitcode='$visitcode' and publishstatus=''";
	        	$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			
	 
	}



	}else{
 
        $paynowbillprefix = 'LRE-';
		$paynowbillprefix1=strlen($paynowbillprefix);
		$query2 = "select * from resultentry_lab order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$billnumber = $res2["docnumber"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
			$billnumbercode ='LRE-'.'1';
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber = $res2["docnumber"];
			$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
			//echo $billnumbercode;
			$billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;

			$maxanum = $billnumbercode;
			
			
			$billnumbercode = 'LRE-' .$maxanum;
			$openingbalance = '0.00';
			//echo $companycode;
		}

		$docnumber=$billnumbercode;

		$query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";
		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res612 = mysqli_fetch_array($exec612);
		$orderedby = $res612['username'];
		$locationcodeget = $res612['locationcode'];
 		$locationnameget = $res612['locationname'];

		$query24 = "select * from master_employee where username = '$orderedby'";
		$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24 = mysqli_fetch_array($exec24);
		$doctorname = $res24['employeename'];
		//$labrslt = $res24['labrslt'];

		foreach($_POST['lab'] as $key => $value)
		{
		$status1 ='norefund';
	     $labname = $_POST['lab'][$key];
		 $itemcode = $_POST['code'][$key];
		$resultvalue=$_POST['result'][$key];
		$unit=$_POST['units'][$key];
		$referencevalue=$_POST['reference'][$key];
		$refname = $_POST['referencename'][$key];
		$refcomments = $_POST['refcomments'][$key];
		$radiology= $_POST['radiology'][$key];
		 			
		$color = $_POST['color'][$key];
		
		if($resultvalue != '')
		{
			$query26="insert into resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,color,username,sampleid,doctorname,locationname,locationcode,referencecomments,datetime,radiology,equipmentcode,equipmentname)values('$patientname','$patientcode',
		'$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$color','$username','$sampleid','$doctorname','".$locationnameget."','".$locationcodeget."','$refcomments','$updatedatetime','$radiology','$equipmentcode','$equipmentname')";
			$exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


			// FOR AUDIT ENTRY
			   $query_auditentry="insert into audit_resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,color,username,sampleid,doctorname,locationname,locationcode,referencecomments,datetime,radiology,equipmentcode,equipmentname,audit_id,ipaddress)values('$patientname','$patientcode',
			   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$color','$username','$sampleid','$doctorname','".$locationnameget."','".$locationcodeget."','$refcomments','$updatedatetime','$radiology','$equipmentcode','$equipmentname','$billnumbercode_ad','$ipaddress')";
			   $exec_auditentry=mysqli_query($GLOBALS["___mysqli_ston"], $query_auditentry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			    // FOR AUDIT ENTRY
		}
		
		
			
				$status1='completed';
			
			 
				$query76 = "update samplecollection_lab set resultentry='$status1' where itemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'";
				$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 
				$query77 = "update resultentry_lab set resultstatus='completed',publishstatus='completed' where docnumber='$docnumber'";
				$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$query77_auditentry = "update audit_resultentry_lab set resultstatus='completed', publishstatus='completed' where docnumber='$docnumber'";
 				$exec77_auditentry = mysqli_query($GLOBALS["___mysqli_ston"], $query77_auditentry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$query29="update consultation_lab set resultentry='$status1',resultdoc='$docnumber', publishdatetime='$updatedatetime',publishstatus = 'completed' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and docnumber='$docnumber'";
				 $exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29);

				$query43 = "update pending_test_orders set publishstatus='completed',publishdatetime='".date('Y-m-d h:i:s')."',resultdatetime='".date('Y-m-d h:i:s')."' where sample_id='$sample_doc' and testcode='$itemcode' and visitcode='$visitcode'  and publishstatus=''";
	        	$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			
	 
	}

	}
	header("location:analyzerresults.php");
	
	exit;

}
?>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">

<!-- <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />       -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>

function equipmentsearch(){
	//$("#eqname"+sno).val('');
	$("#eqid").val('');
	
	$('#eqname').autocomplete({
	source:"ajaxequipmentname_analyzer.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var citemnamevalue=ui.item.value;
			var citemname=ui.item.citemname;
			var citemcode=ui.item.citemcode;
			$("#eqname").val(citemname);
			$("#eqid").val(citemcode);
			},
    
	});
}


function funcrange(varserialnumber1)
{
//alert('hi');
var varserialnumber1 = varserialnumber1;
//alert(varserialnumber1);
var varrange111 = document.getElementById("range111"+varserialnumber1+"").value;
var varrange112 = document.getElementById("range112"+varserialnumber1+"").value;
var result1 = document.getElementById("result"+varserialnumber1+"").value;

if(parseFloat(result1) < parseFloat(varrange111))
{
//alert('h');


document.getElementById("result"+varserialnumber1+"").style.borderColor="orange";
document.getElementById("color"+varserialnumber1+"").value="orange";

}
else if(parseFloat(result1) > parseFloat(varrange112))
{
//alert('hi');
document.getElementById("result"+varserialnumber1+"").style.borderColor="red";
document.getElementById("color"+varserialnumber1+"").value="red";
}
else if(parseFloat(result1) >= parseFloat(varrange111) && parseFloat(result1) <=(varrange112))
{
document.getElementById("result"+varserialnumber1+"").style.borderColor="green";
document.getElementById("color"+varserialnumber1+"").value="green";
}
}

function funcLabHideView(para)
{	
var idname=para;
alert(idname);
 if (document.getElementById(idname) != null) 
	{
	document.getElementById(idname).style.display = 'none';
	}			
}
function funcLabShowView(param)
{
var idname1=param;

  if (document.getElementById(idname) != null) 
     {
	 document.getElementById(idname).style.display = 'none';
	}
	if (document.getElementById(idname) != null) 
	  {
	  document.getElementById(idname).style.display = '';
	 }
}

function validcheck1(){
	var eorm = document.getElementById("eqname").value;
	var eoid = document.getElementById("eqid").value;
		if(eoid == ''){
			alert('Please select the Equipment from the list');
			// $("#eqname").focus();
			document.getElementById("eqname").focus();
			return false;
	}

var confirm1=confirm("HAVE YOU CHECKED ALL THE VALUES PROPERLY FOR HAEMOGRAM & TBC? RECONFIRM BEFORE YOU SAVE.");
if(confirm1 == false) 
{
  return false;
}

}
</script>
<script>
function funcOnLoadBodyFunctionCall()
{
funcLabHideView();
	}
</script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
$itemcode = $_REQUEST["itemcode"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php

$query65= "select * from master_visitentry where visitcode='$visitcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$type = 'OP';

if(mysqli_num_rows($exec65)==0)
{
$query65= "select * from master_ipvisitentry where visitcode='$visitcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$type = 'IP';
}

$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$patientage=$res65['age'];
 $patientgender=$res65['gender'];
 //get locationcode to get locationname
  $locationcode=$res65['locationcode'];


if($type=='IP'){
$query79="SELECT recorddate,sampleid from ipsamplecollection_lab where patientcode='$patientcode' and patientvisitcode='$visitcode'  and sampleid like '%$docnumber%'";
$exec79=mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res79=mysqli_fetch_array($exec79);
 $date2_recorddate=$res79['recorddate'];
 $sampleid=$res79['sampleid'];
}else{
 $query79="SELECT recorddate,sampleid from samplecollection_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and  sampleid like '%$docnumber%'";
$exec79=mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res79=mysqli_fetch_array($exec79);
 $date2_recorddate=$res79['recorddate'];
 $sampleid=$res79['sampleid'];
}
 /*
$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysql_query($query78) or die(mysql_error());
$res78=mysql_fetch_array($exec78);
*/




$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$dateofbirth=$res69['dateofbirth'];

$date1=strtotime($dateofbirth);
$date2=strtotime($date2_recorddate);
$datediff = $date2 - $date1;
$birth_days = round($datediff / (60 * 60 * 24));

if($dateofbirth>'0000-00-00'){
$today = new DateTime($date2_recorddate);
$diff = $today->diff(new DateTime($dateofbirth));
$patientage1 = format_interval($diff);
}else{
  $patientage1 = '<font color="red">DOB Not Found.</font>';
}


function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result .= $interval->format("%y Years "); }
    if ($interval->m) { $result .= $interval->format("%m Months "); }
    if ($interval->d) { $result .= $interval->format("%d Days "); }

    return $result;
}


 $query = "select * from master_location where locationcode='".$locationcode."'";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 //get locationname end here


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body >
<form name="frm" id="frmsales" method="post" action="analyzerresultsview.php" onKeyDown="return disableEnterKey(event)" >
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="0%">&nbsp;</td>
    <td width="84%" valign="top">
	<table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td colspan="8"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#ecf0f5">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
	  <td width="22%" class="bodytext3" align="left" valign="middle" bgcolor="#ecf0f5">
				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>
                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="sampleid" id="sampleid" value="<?php echo $sampleid; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="26%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
				<td width="11%" align="left" valign="middle" class="bodytext3"><strong>Sample ID</strong></td>
                <td width="21%" align="left" valign="middle" class="bodytext3">
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $docnumber; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $docnumber; ?>
                  </td>
              </tr>
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" class="bodytext3" align="left" valign="middle" >
			<input name="visitcode" type="hidden" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
                  </td>
                 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage1; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
			        </td>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="1" align="left" valign="top" class="bodytext3">
				<input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				<input type="hidden" name="samplecollectiondocno" value="<?php echo $docnumber; ?>">
				</td>
                 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $locationname;?></td>
				  </tr>
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
              
				  </tr>
            </tbody>
        </table></td>
      </tr>
	<input name="vtype" type="hidden" id="vtype" value="<?php echo $type; ?>" >
     <tr>
	  <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext365">
				 <strong>LAB RESULTS</strong>
				  </td> </tr>
				  
				   <tr>
		    <td width="5%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
			<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Result value</strong></div></td>
			<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Units</strong></div></td>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Reference Value</strong></div></td>
				
		  </tr>
				  <?php 
				  $sno=0;
				  $sn=0;
	  $query31="select * from pending_test_orders where patientcode = '$patientcode' and visitcode = '$visitcode' and sample_id='$docnumber' and testcode='$itemcode' group by testcode";
	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	  $num=mysqli_num_rows($exec31);
	  while($res31=mysqli_fetch_array($exec31))
	  { 
		
	   $labname1=$res31['testname'];
	   $itemcode2=$res31['testcode'];
       
	   
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
			$sno = $sno + 1;
		?>		  
			  <tr id="idTRMain<?php echo $sno; ?>" <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="center"><div align="left"><?php echo $labname1; ?></div></td>
			  	   <input type="hidden" name="lab[]" value="<?php echo $labname1;?>">
              <td class="bodytext31" valign="center"  align="center">
			  <div align="center">
			  <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcShowDetailHide('<?php echo $sno; ?>')" onClick="return funcShowDetailView('<?php echo $sno; ?>')">			  </div>			  </td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"></div></td>
			       	  <td class="bodytext31" valign="center"  align="center">
			  <div class="bodytext31"></div></td>
			
		
         </tr>
		 	<tr id="idTRSub<?php echo $sno; ?>">
			<td colspan="7"  align="left" valign="center" class="bodytext31">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1000"
            align="left" border="0">
              <tbody>
               
			   <?php 
			   $subTRsno = 0;
			  $query52="select * from master_labreference where itemcode='$itemcode2' and (gender = '$patientgender' or gender='All' or gender='') and '$birth_days' >= agefrom and '$birth_days' <= ageto  and status <> 'deleted'";
			   $exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52);
			  $num=mysqli_num_rows($exec52);
			   while($res52=mysqli_fetch_array($exec52))
			   {
			   $sn=$sn+1;
			   $subTRcolorloopcount=0;
			   $labname2=$res52['itemname'];
				$itemcode2=$res52['itemcode'];
			    /* $query52="select * from master_lab where itemname='$labname2'";
				  $exec52=mysql_query($query52);
				  $res52=mysql_fetch_array($exec52);*/
				  $labunit1=$res52['itemname_abbreviation'];
				   $labreferenceunit = $res52['referenceunit'];
				   
				$labreferencename = $res52['referencename'];
				$labitemanum = $res52['auto_number'];
				   $labreferencerange = $res52['referencerange'];
				  
				  $labreferencevalue1=$res52['referencevalue'];
				   //echo $color = $res31['color'];
				 if($labreferencename != '')
				 {
				  $query87 = "select * from pending_test_orders where patientcode = '$patientcode' and visitcode = '$visitcode' and sample_id='$docnumber' and parametername = '$labreferencename' and result!=''";
				  $exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res87 = mysqli_fetch_array($exec87);
				  $resultvalue = $res87['result'];
				 //$color1 = $res87['color'];
				  }
				  else
				  {
				    $query87 = "select * from pending_test_orders where patientcode = '$patientcode' and visitcode = '$visitcode' and sample_id='$docnumber'";
				  $exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res87 = mysqli_fetch_array($exec87);
				  $resultvalue = $res87['result'];
				 // $color1 = $res87['color'];
				  }
				  $query64 = "select * from master_labreference where itemcode='$itemcode2' and referencename = '$labreferencename' and auto_number = '$labitemanum' and status <> 'deleted' group by referencename";
				  $exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $num64 = mysqli_num_rows($exec64);
				  if($num64 > 0)
				  {
				  
				  	$subTRcolorloopcount = $subTRcolorloopcount + 1;
				$subTRshowcolor = ($subTRcolorloopcount & 1); 
				if ($subTRshowcolor == 0)
				{
					//echo "if";
					$subTRcolorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$subTRcolorcode = 'bgcolor="#ecf0f5"';
				}
				 
				$labreferencerange1 = $labreferencerange;
			    $labreferencerange1 = explode('-', $labreferencerange1);
				//echo $labreferencerange1[0];
				

				if($type == 'IP'){

					$query49 = "select * from ipresultentry_lab where patientcode='$patientcode' and itemcode='$itemcode2' and referencename='$labreferencename' and docnumber <> '$docnumber' order by auto_number desc limit 0,1";
				}else{
					$query49 = "select * from resultentry_lab where patientcode='$patientcode' and itemcode='$itemcode2' and referencename='$labreferencename' and docnumber <> '$docnumber' order by auto_number desc limit 0,1";
				}
				 

				 $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $res49 = mysqli_fetch_array($exec49);
				 $pastresult = $res49['resultvalue'];

						   ?> 
						     <tr <?php echo $subTRcolorcode; ?>>
							 <input type="hidden" value="<?php echo $subTRsno = $subTRsno + 1; ?>">
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="250"><div class="bodytext311"> <?php if($labreferencename == '')
				   {
				   echo $labname2;
				   }
				   else
				   {
				   echo $labreferencename;
				   } ?></div></td>
				   <input type="hidden" name="lab[]" value="<?php echo $labname2;?>"><input type="hidden" name="referencename[]" value="<?php echo $labreferencename; ?>">
				  <input type="hidden" name="code[]" value="<?php echo $itemcode2; ?>">
				  
				
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center"><div align="center"> 
				   <?php //if($labrslt==1){ ?>
				  <textarea  name="result[]" id="result<?php echo $sn; ?>" onBlur="return funcrange('<?php echo $sn; ?>')"><?php echo $resultvalue;?></textarea></div></td>
				  <?php// }else{ ?>
                   <!--<textarea <?php if($resultvalue=='' || $resultvalue=='0') echo ''; else echo 'readonly';?> name="result[]" id="result<?php echo $sn; ?>" ><?php echo $resultvalue;?></textarea></div></td>-->
				  <?php //} ?>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="170"><div align="left"> <?php if($labreferenceunit == '')
				  {
				  echo $labunit1;
				  }
				  else
				  {
				  echo $labreferenceunit;
				  } ?><input type="hidden" name="units[]" size="8" value="<?php echo $labreferenceunit; ?>"/> </div></td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="75" style="color:red;"><?php echo $pastresult; ?></td>
               <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" width="158"><div align="left"> <?php if($labreferencerange == '')
			   {
			   echo $labreferencevalue1;
			   }
			   else
			   {
			   echo $labreferencerange;
			   } ?>
			   <input type="hidden" name="color[]" id="color<?php echo $sn; ?>" value="">
			   <input type="hidden" name="serialnumber" id="serialnumber<?php echo $sn; ?>" value="<?php echo $sn; ?>">
			   <input type="hidden" name="reference[]" size="8" value="<?php echo $labreferencerange; ?>"/>
			   <input type="hidden" name="range111[]" id="range111<?php echo $sn; ?>" value="<?php echo $labreferencerange1[0] ; ?>">
				  <input type="hidden" name="range112[]" id="range112<?php echo $sn; ?>" value="<?php echo $labreferencerange1[1] ; ?>">
			   </div></td>
              </tr>
			  <?php 
		 }
		 }
		 ?>
			  </tbody>
            </table>			</td>
			
			</tr>
			 
		 
			 
		 <tr>
		 <td class="bodytext31" colspan="7" valign="center"  align="left"><div align="left">&nbsp;</div></td>
			
		 </tr> 
		 <?php
		  
		 }
		 ?>
		 
				  
				  
				  	<script language="javascript">
			//alert ("Inside JS");
			//To Hide idTRSub rows this code is not given inside function. This needs to run after rows are completed.
			for (i=1;i<=100;i++)
			{
				if (document.getElementById("idTRSub"+i+"") != null) 
				{
					document.getElementById("idTRSub"+i+"").style.display = '';
				}
			}
			
			function funcShowDetailView(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRSub"+i+"") != null) 
					{
						document.getElementById("idTRSub"+i+"").style.display = '';
					}
				}

				if (document.getElementById("idTRSub"+varSerialNumber+"") != null) 
				{
					document.getElementById("idTRSub"+varSerialNumber+"").style.display = '';
				}
			}
			
			function funcShowDetailHide(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRSub"+i+"") != null) 
					{
						document.getElementById("idTRSub"+i+"").style.display = '';
					}
				}
			}
			</script>	

      <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name:
               <input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly><?php echo strtoupper($_SESSION['username']); ?></td>

               <td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">Equipment :
               	<input type="text" id="eqname" name="eqname"  value="<?php echo $eqname; ?>" onkeyup = "return equipmentsearch()" size='23'>
				<input type="hidden" id="eqid" name="eqid"  value="<?php echo $eqid; ?>">
              </td>

               </tr>
			   <tr> 
              <td colspan="7" align="right" valign="top" >
                  
				  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                     <input name="Submit2223" type="submit" value="Save & Publish Results"   accesskey="b" class="button" onclick="return validcheck1();" />

               </td>
          </tr>
		  </table>
		  </td>
    <td width="16%" valign="top">
	<table>
	<tr>
	<td>&nbsp;</td>
	<td width="41">&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td align="left" valign="middel" width="35" bgcolor="orange"></td>
	<td class="bodytext32"><strong>Below Range</strong></td>
	</tr>
    <tr>
	<td align="left" valign="middel" width="35" bgcolor="green"></td>
	<td class="bodytext32"><strong>Normal</strong></td>
	</tr>
	<tr>
	<td align="left" valign="middel" width="35" bgcolor="red"></td>
	<td class="bodytext32"><strong>Above Range</strong></td>
	</tr>
	</table>
	</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>
<script>
   $(document).ready(function(){
            
			varserialnumber1='<?php echo $sn; ?>';
			
			for (i = 1; i <= varserialnumber1; i++) {
		    
			
			var varrange111 = document.getElementById("range111"+i+"").value;
			var varrange112 = document.getElementById("range112"+i+"").value;
			var result1 = document.getElementById("result"+i+"").value;
			if(result1!=''){
			if(parseFloat(result1) < parseFloat(varrange111))
			{
			//alert('h');


			document.getElementById("result"+i+"").style.borderColor="orange";
			document.getElementById("color"+i+"").value="orange";

			}
			else if(parseFloat(result1) > parseFloat(varrange112))
			{
			//alert('hi');
			document.getElementById("result"+i+"").style.borderColor="red";
			document.getElementById("color"+i+"").value="red";
			}
			else if(parseFloat(result1) >= parseFloat(varrange111) && parseFloat(result1) <=(varrange112))
			{
			document.getElementById("result"+i+"").style.borderColor="green";
			document.getElementById("color"+i+"").value="green";
			}
			}
			}

	});
</script>
</body>
</html>