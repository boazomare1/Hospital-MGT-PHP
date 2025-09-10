<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$recorddate = date('Y-m-d');

$errmsg = "";


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

if ($frmflag1 == "frmflag1")
{
	$patientfullname= $_REQUEST["patientname"];
	$patientcode = $_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$locationcode = $_REQUEST["locationcode"];
	$operationname = $_REQUEST["operationname"];
	$patientage = $_REQUEST["patientage"];
	$patientgender = $_REQUEST["patientgender"];
	$wardname = $_REQUEST["wardname"];
	$bednumber = $_REQUEST["bednumber"];
	$timecommenced = $_REQUEST["timecommenced"];
    $instrument1 = $_REQUEST["instrument1"];
    $instrument2 = $_REQUEST["instrument2"];
	$instrument3 = $_REQUEST["instrument3"];
	$abdpacks1 = $_REQUEST["abdpacks1"];
	$abdpacks2 = $_REQUEST["abdpacks2"];
	$abdpacks3 = $_REQUEST["abdpacks3"];
	$swabs1 = $_REQUEST["swabs1"];
	$swabs2 = $_REQUEST["swabs2"];
	$swabs3 = $_REQUEST["swabs3"];
	$intnursename = $_REQUEST["intnursename"];
	$runnursename = $_REQUEST["runnursename"];
	$procfind = $_REQUEST["procfind"];
	$incission = $_REQUEST["incission"];
	$operation = $_REQUEST["operation"];
	$diagnosisintraop = $_REQUEST["diagnosisintraop"];
	$diagnosispreop = $_REQUEST["diagnosispreop"];
	$specimen = $_REQUEST["specimen"];
	$type = $_REQUEST["type"];
	$lab = $_REQUEST["lab"];
	$ward = $_REQUEST["ward"];
	$surgeon = $_REQUEST["surgeon"];
	$anaesthetist = $_REQUEST["anaesthetist"];
	$assistant = $_REQUEST["assistant"];
	$scrubnurse = $_REQUEST["scrubnurse"];

	$query7 = "select * from operationrecord where patientcode='$patientcode' and visitcode='$visitcode' "; 
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $nums7 = mysqli_num_rows($exec7);
	
	if($nums7 == '0')
	{
		if($patientcode!='' && $visitcode!='')
		{
		 	$query5 = "insert into operationrecord (docno,patientname,patientcode,visitcode,patientage,wardnumber,bednumber,surgeon,anaesthetist,assistant,scrubnurse,operation, diagnosispreop,diagnosisintraop,incission,procfind,instrument1,instrument2,instrument3,abdpacks1,abdpacks2,abdpacks3,swabs1,swabs2,swabs3,specimen,type,lab,ward,intnursename, runnursename,recorddate,timecommenced,status,username,updatetime,ipaddress,locationname,locationcode)
			 VALUES('$docno', '$patientfullname','$patientcode','$visitcode','$patientage','$wardname','$bednumber','$surgeon', '$anaesthetist','$assistant','$scrubnurse','$operation','$diagnosispreop','$diagnosisintraop','$incission','$procfind','$instrument1','$instrument2','$instrument3','$abdpacks1', '$abdpacks2','$abdpacks3','$swabs1','$swabs2','$swabs3','$specimen','$type','$lab','$ward','$intnursename','$runnursename','$recorddate','$status','$timecommenced','$username','$updatedatetime', '$ipaddress','$locationname','$locationcode')";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			header("Location:otpatients:.php");
		}
	}
	
	else
	     {
		   if($patientcode!='' && $visitcode!='')
		    {
		   	$query6 = "update operationrecord set surgeon='$surgeon', anaesthetist='$anaesthetist',assistant='$assistant',scrubnurse='$scrubnurse',operation='$operation',diagnosispreop='$diagnosispreop',diagnosisintraop='$diagnosisintraop',incission='$incission',procfind='$procfind',instrument1='$instrument1',instrument2='$instrument2',instrument3='$instrument3',abdpacks1='$abdpacks1',abdpacks2='$abdpacks2',abdpacks3='$abdpacks3',swabs1='$swabs1',swabs2='$swabs2',swabs3='$swabs3',specimen='$specimen',type='$type',lab='$lab',ward='$ward',intnursename='$intnursename',runnursename='$runnursename',recorddate='$recorddate',timecommenced='$timecommenced',status='$status',username='$username',updatetime='$updatedatetime',ipaddress='$ipaddress', locationname='$locationname', locationcode='$locationcode' where patientcode='$patientcode' and visitcode='$visitcode' ";
			
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			header("Location:otpatients.php");
		    }
		 }	
		
}
if($visitcode!='' && $patientcode!='')
{	
	$query8 = "select * from operationrecord where patientcode='$patientcode' and visitcode='$visitcode' ";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $nums8 = mysqli_num_rows($exec8);
	if($nums8 > 0)
	{
	$res8 = mysqli_fetch_array($exec8);
	$res8patientfullname= $res8["patientname"];
	$res8locationcode = $res8["locationcode"];
	$res8patientcode = $res8["patientcode"];
	$res8visitcode = $res8["visitcode"];
	$res8operationname = $res8["operationname"];
	$res8patientage = $res8["patientage"];
	$res8patientgender = $res8["patientgender"];
	$res8wardname = $res8["wardname"];
	$res8bednumber = $res8["bednumber"];
	$res8instrument1 = $res8["instrument1"];
    $res8instrument2 = $res8["instrument2"];
	$res8instrument3 = $res8["instrument3"];
	$res8abdpacks1 = $res8["abdpacks1"];
	$res8abdpacks2 = $res8["abdpacks2"];
	$res8abdpacks3 = $res8["abdpacks3"];
	$res8swabs1 = $res8["swabs1"];
	$res8swabs2 = $res8["swabs2"];
	$res8swabs3 = $res8["swabs3"];
	$res8intnursename = $res8["intnursename"];
	$res8runnursename = $res8["runnursename"];
	$res8procfind = $res8["procfind"];
	$res8incission = $res8["incission"];
	$res8operation = $res8["operation"];
	$res8diagnosisintraop = $res8["diagnosisintraop"];
	$res8diagnosispreop = $res8["diagnosispreop"];
	$res8specimen = $res8["specimen"];
	$res8type = $res8["type"];
	$res8lab = $res8["lab"];
	$res8ward = $res8["ward"];
	$res8surgeon = $res8["surgeon"];
	$res8anaesthetist = $res8["anaesthetist"];
	$res8assistant = $res8["assistant"];
	$res8scrubnurse = $res8["scrubnurse"];
    $res8timecommenced = $res8["timecommenced"];

	}
	else
	{
	$res8patientfullname= '';
	$res8patientcode = '';
	$res8visitcode = '';
	$res8operationname = '';
	$res8patientage = '';
	$res8patientgender = '';
	$res8wardname = '';
	$res8bednumber ='';
	$res8instrument1 = '';
    $res8instrument2 = '';
	$res8instrument3 = '';
	$res8abdpacks1 = '';
	$res8abdpacks2 = '';
	$res8abdpacks3 = '';
	$res8swabs1 = '';
	$res8swabs2 = '';
	$res8swabs3 = '';
	$res8intnursename = '';
	$res8runnursename ='';
	$res8procfind = '';
	$res8incission = '';
	$res8operation = '';
	$res8diagnosisintraop = '';
	$res8diagnosispreop ='';
	$res8specimen = '';
	$res8type ='';
	$res8lab = '';
	$res8ward = '';
	$res8surgeon = '';
	$res8anaesthetist ='';
	$res8assistant = '';
	$res8scrubnurse ='';
	$res8timecommenced='00:00';
	}
}

?>

<?php 
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode' ");
$execlab=mysqli_fetch_array($Querylab);
$patientage=$execlab['age'];
$patientgender=$execlab['gender'];
$patientname = $execlab['customerfullname'];
$billtype = $execlab['billtype'];
$patienttype=$execlab['maintype'];
$patientaccount=$execlab['accountname'];
$dateofbirth=$execlab['dateofbirth'];
$locationcode = $execlab['locationcode'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];

$query19=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' ");
$exec19=mysqli_fetch_array($query19);
$res19ward=$exec19['ward'];
$res19bed=$exec19['bed'];

$query30=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ward where auto_number='$res19ward' ");
$exec30=mysqli_fetch_array($query30);
$res30ward=$exec30['ward'];

$query31 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_bed where auto_number='$res19bed' ");
$exec31=mysqli_fetch_array($query31);
$res31bed=$exec31['bed'];

$query66 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$ipdate = $res66['consultationdate'];
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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}

function from1submit1()
{
	if (document.form1.companyname.value == "")
	{
		alert ("Hospital Name Cannot Be Empty.");
		document.form1.companyname.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		//alert ("City Cannot Be Empty.");
		//document.form1.city.focus();
		//return false;
	}
	else if (document.form1.state.value == "")
	{
		//alert ("State Cannot Be Empty.");
		//document.form1.state.focus();
		//return false;
	}
	else if (document.form1.patientcodeprefix.value == "") 
	{
		alert ("Please Enter Patient Code Prefix.");
		document.form1.patientcodeprefix.focus();
		return false;
	}
	else if (document.form1.visitcodeprefix.value == "") 
	{
		alert ("Please Enter Visit Number Prefix.");
		document.form1.visitcodeprefix.focus();
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
	}
}

</script>
<script src="js/datetimepicker_css.js"></script>
<body>
<form name="form1" id="form1" method="post" action="operationrecord.php" onSubmit="return from1submit1()">

<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="82%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#ecf0f5">
          <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" />
          <input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
          <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient * </strong></td>
         <td width="54%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<?php echo $patientname; ?></td>
				<input name="patientname" id="patientname" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden">
          <td bgcolor="#ecf0f5" class="bodytext3"><strong>Date </strong></td>
          <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
          <td width="8%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $transactiondatefrom; ?></td>
			
          <td width="10%" align="left" valign="middle" class="bodytext3"><strong>Ward</strong></td>
          <td width="13%" align="left" valign="middle" class="bodytext3"><?php echo $res30ward; ?>/<?php echo $res31bed; ?>
		    <input type="hidden" name="wardname" id="wardname" value="<?php echo $res30ward; ?>" style="border: 1px solid #001E6A;" size="45">
		    <input type="hidden" name="bednumber" id="bednumber" value="<?php echo $res31bed; ?>" style="border: 1px solid #001E6A;" size="45"></td>
        </tr>
        <tr>
          <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Code</strong></td>
          <td width="54%" class="bodytext3" align="left" valign="middle" ><input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?>
            <?php echo $patientcode; ?></td>
          <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code </strong></td>
          <td align="left" valign="top" class="bodytext3"><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />
            <?php echo $visitcode; ?></td>
          <td align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td align="left" valign="top" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Age &amp; Gender </strong></td>
          <td align="left" valign="middle" class="bodytext3"><?php echo $patientage; ?>
            <input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;" size="45">
&amp; <?php echo $patientgender; ?>
            <input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;" size="45">         </td>
          <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location </strong></td>
		               <?php
					   $query131 = "select * from master_location where locationcode = '$locationcode'";
                       $exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
                       $res131 = mysqli_fetch_array($exec131);
                       $locationname = $res131['locationname'];
					   ?>
		   <td align="left" valign="top" class="bodytext3"><input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" /><?php echo $locationname; ?>
		   <input type="hidden" id="locationcode" value="<?php echo locationcode; ?>"></td>
		  <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong>
            <table width="1063" height="650" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
              <tbody>
                <tr>
                  <td bgcolor="#ecf0f5" class="bodytext3" colspan="8"><strong>OPERATION RECORD </strong></td>
                </tr>
                <!--<tr>
                <td colspan="12" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>-->
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Time Commenced </strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="timecommenced" id="timecommenced" value="<?php echo date('H:i',strtotime($res8timecommenced)); ?>"  size="10"  onKeyDown="return disableEnterKey()" />
                    <span class="bodytext32">(Ex: HH:MM)</span></td>
                </tr>
                <tr>
                  <td width="19%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Surgeon</strong><strong>&nbsp;</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="surgeon" id="surgeon" value="<?php echo $res8surgeon; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Anaesthetist</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="anaesthetist" id="anaesthetist" value="<?php echo $res8anaesthetist; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Assistant</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="assistant" id="assistant" value="<?php echo $res8assistant; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Scrub Nurse </strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="scrubnurse" id="scrubnurse" value="<?php echo $res8scrubnurse; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>OPERATION:</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="operation" id="operation" value="<?php echo $res8operation; ?>" onKeyDown="return disableEnterKey()" size="20">                  </td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Diagnosis - Pre OP</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="diagnosispreop" id="diagnosispreop" value="<?php echo $res8diagnosispreop; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Diagnosis - Intra OP</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="diagnosisintraop" id="diagnosisintraop" value="<?php echo $res8diagnosisintraop; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Incission</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="incission" id="incission" value="<?php echo $res8incission; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Procedure / Findings</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="procfind" id="procfind" value="<?php echo $res8procfind; ?>" onKeyDown="return disableEnterKey()" size="20">                  </td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>COUNTS:</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Instrument</strong></td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="instrument1" id="instrument1" onClick="return funcpackcheck();" <?php if($res8instrument1 == '1') echo 'checked'; ?> value="1">
                      <strong>1st</strong></td>
                  <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="instrument2" id="instrument2" onClick="return funcpackcheck();" <?php if($res8instrument2 == '1')  echo 'checked'; ?> value="1">
                    <strong>2nd</strong></td>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="instrument3" id="instrument3" onClick="return funcpackcheck();" <?php if($res8instrument3 == '1') echo 'checked'; ?> value="1">
                    <strong>3rd</strong></td>
                  <td colspan="3" align="left" class="bodytext3" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Abdominal Packs </strong></td>
                  <td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="abdpacks1" id="abdpacks1" onClick="return funcpackcheck();" <?php if($res8abdpacks1 == '1') echo 'checked'; ?> value="1">
                      <strong>1st</strong></td>
                  <td colspan="3" align="left" valign="middle" class="bodytext3"  bgcolor="#ecf0f5"><input type="checkbox" name="abdpacks2" id="abdpacks2" onClick="return funcpackcheck();" <?php if($res8abdpacks2 == '1') echo 'checked'; ?> value="1">
                      <strong>2nd</strong></td>
                  <td colspan="2" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5"><input type="checkbox" name="abdpacks3" id="abdpacks3" onClick="return funcpackcheck();" <?php if($res8abdpacks3 == '1') echo 'checked'; ?> value="1">
                      <strong>3rd</strong></td>
                  <td align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Swabs</strong></td>
                  <td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="swabs1" id="swabs1" onClick="return funcpackcheck();" <?php if($res8swabs1 == '1') echo 'checked'; ?> value="1">
                      <strong>1st</strong></td>
                  <td colspan="3" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5"><input type="checkbox" name="swabs2" id="swabs2" onClick="return funcpackcheck();" <?php if($res8swabs2 == '1') echo 'checked'; ?> value="1">
                      <strong>2nd</strong></td>
                  <td colspan="2" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5"><input type="checkbox" name="swabs3" id="swabs3" onClick="return funcpackcheck();" <?php if($res8swabs3 == '1') echo 'checked'; ?> value="1">
                      <strong>3rd</strong></td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Specimen</strong></td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="specimen" id="specimen" onClick="return funcpackcheck();" <?php if($res8specimen == '1') echo 'checked'; ?> value="1"></td>
                  <td width="4%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5"><strong>Type</strong></td>
                  <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="type" id="type" value="<?php echo $res8type; ?>" onKeyDown="return disableEnterKey()" size="20">                  </td>
                  <td width="3%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5"><strong>TO</strong></td>
                  <td width="15%" align="left" valign="middle" class="bodytext3"  bgcolor="#ecf0f5"><input type="checkbox" name="lab" id="lab" onClick="return funcpackcheck();" <?php if($res8lab == '1') echo 'checked'; ?> value="1">
                    <strong>Laboratory</strong></td>
                  <td width="13%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5"><input type="checkbox" name="ward" id="ward" onClick="return funcpackcheck();" <?php if($res8ward == '1') echo 'checked'; ?> value="1">
                      <strong>Ward</strong></td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Instrument Nurse Name</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="intnursename" id="intnursename" value="<?php echo $res8intnursename; ?>" onKeyDown="return disableEnterKey()" size="20">                  </td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Runners Nurse Name</strong></td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="runnursename" id="runnursename" value="<?php echo $res8runnursename; ?>" onKeyDown="return disableEnterKey()" size="20">                  </td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="4" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="3" align="middle"  bgcolor="#ecf0f5"><input type="hidden" name="frmflag1" value="frmflag1" />
                      <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
                      <input name="Submit222" type="submit"  value="Save Operation" class="button"/></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
      </tbody>
    </table> 
	
	 
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
    
</form>
</body>
</html>

