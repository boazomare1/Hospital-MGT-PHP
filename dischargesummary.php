<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$recorddate = date('Y-m-d');
$errmsg = "";

$query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1111 = mysqli_fetch_array($exec1111))
	{
	$locationnumber = $res1111["location"];
	$query1112 = "select * from master_location where auto_number = '$locationnumber'";
    $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1112 = mysqli_fetch_array($exec1112))
	{
		 $locationname = $res1112["locationname"];		  
		 $locationcode = $res1112["locationcode"];
		
	}
	}
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == "frmflag1")
{
	$patientname = $_REQUEST["patientname"];
	$patientcode = $_REQUEST["patientcode"];
	$patientvisitcode = $_REQUEST["visitcode"];
	$summarydate = $_REQUEST["ADate1"];
	$patientage = $_REQUEST["age"];
	$patientgender = $_REQUEST["gender"];
	$wardnumber = $_REQUEST["wardname"];
	$bednumber = $_REQUEST['bedname'];
	$discharged = isset($_REQUEST["discharged"])? 1 : 0;
	$transrefer = isset($_REQUEST["transrefer"])? 1 : 0;
	$transferto = $_REQUEST['transferto'];
	$admissiondate = $_REQUEST['admitdate'];
	$dischargedate = $_REQUEST['dischargedate'];
	$leavedate = $_REQUEST['leavingdate'];
	$primary = $_REQUEST['primary'];
	$secondary = $_REQUEST['secondary'];
	$opprocedure = $_REQUEST['opprocedure'];
	$opprocdate = $_REQUEST['opprocdate'];
	$otherlabimage = $_REQUEST['otherlabimage'];
	$diagnosisintraop = $_REQUEST['diagnosisintraop'];
	$incission = $_REQUEST['incission'];
	$procfind = $_REQUEST['procfind'];
	$referother = $_REQUEST['referother'];
	$asneeded = isset($_REQUEST["asneeded"])? 1 : 0;
	$day = isset($_REQUEST["day"])? 1 : 0;
	$day1 = $_REQUEST['day1'];
	$returndate = $_REQUEST['returndate'];
	$returntime = $_REQUEST['returntime'];
	$referdoctor = isset($_REQUEST["referdoctor"])? 1 : 0;
	$referdoctor1 = $_REQUEST['referdoctor1'];
	$rconurse = isset($_REQUEST["rconurse"])? 1 : 0;
	$doctor = isset($_REQUEST["doctor"])? 1 : 0;
	$doctor1 = $_REQUEST['doctor1'];
	$opd = isset($_REQUEST["opd"])? 1 : 0;
	$tb = isset($_REQUEST["tb"])? 1 : 0;
	$mchfp = isset($_REQUEST["mchfp"])? 1 : 0;
	$treatmentrun = isset($_REQUEST["treatrm"])? 1 : 0;
	$gensurg = isset($_REQUEST["gensurg"])? 1 : 0;
	$accord = isset($_REQUEST["accord"])? 1 : 0;
	$otho = isset($_REQUEST["ortho"])? 1 : 0;
	$gynae = isset($_REQUEST["gynae"])? 1 : 0;
	$paesdsurg = isset($_REQUEST["paedssurg"])? 1 : 0;
	$paeds = isset($_REQUEST["paeds"])? 1 : 0;
	$ent = isset($_REQUEST["ent"])? 1 : 0;
	$other = isset($_REQUEST["other"])? 1 : 0;
	$other1 = $_REQUEST['type2'];
	$castoff = isset($_REQUEST["castoff"])? 1 : 0;
	$xraylabs = isset($_REQUEST["xraylabs"])? 1 : 0;
	$xraylabs1 = $_REQUEST['xraylabs1'];
	$xraylabs1 = isset($_REQUEST["xraylabs1"])? 1 : 0;
	$patientdischarge = isset($_REQUEST["patientdischarge"])? 1 : 0;
	$compilefile = isset($_REQUEST["compilefile"])? 1 : 0;
	$informpatient = isset($_REQUEST["informpatient"])? 1 : 0;
	$takerelative = isset($_REQUEST["takerelative"])? 1 : 0;
	$returnvaluables = isset($_REQUEST["returnvaluables"])? 1 : 0;
	$checkreceipt = isset($_REQUEST["checkreceipt"])? 1 : 0;
	$educatemeds = isset($_REQUEST["educatemeds"])? 1 : 0;
	$schedulevisit = isset($_REQUEST["schedulevisit"])? 1 : 0;
	$doctorname  = $_REQUEST["doctorname"];
	
	$query7 = "insert into dischargesummary (patientvisitcode,summarydate,patientname,patientcode,patientage,patientgender,wardnumber,bednumber,discharged,leavedate,transrefer,transferto,
	admissiondate,dischargedate,primaryname,secondary,opprocedure,opprocdate,otherlabimage,diagnosisintraop,incission,procfind,referother,doctorname,asneeded,day,day1,returndate,returntime,referdoctor,referdoctor1,
	rconurse,doctor,doctor1,opd,tb,mchfp,treatmentrun,gensurg,accord,otho,gynae,paesdsurg,paeds,ent,other,other1,castoff,xraylabs,xraylabs1,patientdischarge,compilefile,informpatient,takerelative,
	returnvaluables,checkreceipt,educatemeds,schedulevisit,recorddate,username,updatetime,ipaddress,locationname,locationcode)
	 values('$patientvisitcode','$summarydate','$patientname','$patientcode','$patientage','$patientgender','$wardnumber','$bednumber','$discharged','$leavedate','$transrefer','$transferto',
	 '$admissiondate','$dischargedate','$primary','$secondary','$opprocedure','$opprocdate','$otherlabimage','$diagnosisintraop','$incission','$procfind','$referother','$doctorname','$asneeded','$day','$day1',
	 '$returndate','$returntime','$referdoctor','$referdoctor1','$rconurse','$doctor','$doctor1','$opd','$tb','$mchfp','$treatmentrun','$gensurg','$accord','$otho','$gynae','$paesdsurg','$paeds','$ent',
	 '$other','$other1','$castoff','$xraylabs','$xraylabs1','$patientdischarge','$compilefile','$informpatient','$takerelative','$returnvaluables','$checkreceipt','$educatemeds','$schedulevisit','$recorddate',
	 '$username','$updatetime','$ipaddress','$locationname','$locationcode')";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	header("location:dischargediplist.php?patientcode=$patientcode&&visitcode=$visitcode");
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
.style1 {COLOR: #3B3B3C; FONT-FAMILY: Tahoma; font-size: 11px;}
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
<?php 
$query1 = "SELECT * FROM master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$patientname = $res1['patientfullname'];
$age = $res1['age'];
$gender = $res1['gender'];

$query2 = "SELECT * FROM ip_bedallocation where patientcode = '$patientcode' and visitcode = '$visitcode'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$bed = $res2['bed'];
$ward = $res2['ward'];
$recorddate = $res2['recorddate'];
$query3 = "SELECT * FROM master_ward where auto_number = '$ward'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$wardname = $res3['ward'];
$query4 = "SELECT * FROM master_bed where auto_number = '$bed'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$bedname = $res4['bed'];
$query4 = "select * from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$visitcode' and primarydiag <> ''  order by auto_number desc limit 0,1";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$primarydiag = $res4['primarydiag'];
$primaryicdcode = $res4['primaryicdcode'];

$query5 = "select * from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$visitcode' and secondarydiag <> ''  order by auto_number desc limit 0,1";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$secondarydiag = $res5['secondarydiag'];
$secicdcode = $res5['secicdcode'];
?>
<body>
<form name="form1" id="form1" method="post" action="dischargesummary.php" onSubmit="return from1submit1()">
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
    <td valign="top"><table width="61%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#ecf0f5">
          <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" />
          <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
		  <input type="hidden" name="patientname" value="<?php echo $patientname; ?>">
		  <input type="hidden" name="visitcode" value="<?php echo $visitcode; ?>">
		   <input type="hidden" name="age" value="<?php echo $age; ?>">
		    <input type="hidden" name="gender" value="<?php echo $gender; ?>">
			 <input type="hidden" name="wardname" value="<?php echo $wardname; ?>">
			  <input type="hidden" name="bedname" value="<?php echo $bedname; ?>">
          <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" bgcolor="#ecf0f5"><?php echo $patientname; ?></td>
          <td bgcolor="#ecf0f5" class="bodytext3"><strong>Date </strong></td>
          <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
          <td width="26%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $transactiondatefrom; ?>
            <input type="hidden" name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
         </td>
          <td width="15%" align="left" valign="middle" class="bodytext3"><strong>Ward/Bed</strong></td>
          <td width="17%" align="left" valign="middle" class="bodytext3"><?php echo $wardname.'/'.$bedname; ?></td>
        </tr>
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Code</strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" ><?php echo $patientcode; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code </strong></td>
          <td align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?></td>
          <td align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td align="left" valign="top" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Age &amp; Gender </strong></td>
          <td align="left" valign="middle" class="bodytext3"><?php echo $age; ?> & <?php echo $gender; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
        </tr>
      </tbody>
    </table>  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top">


      
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="900"><table width="1300" height="650" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="9"><strong>DISCHARGE SUMMARY </strong></td>
                </tr>
              <!--<tr>
                <td colspan="13" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php //echo $errmsg;?>&nbsp;</td>
              </tr>-->
              
              
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="discharged" id="instrument" onClick="return funcpackcheck();" <?php //if($instrument1 == '1') echo 'checked'; ?> value="1">
                    Discharge</td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="transrefer" id="instrument4" onClick="return funcpackcheck();" <?php //if($instrument1 == '1') echo 'checked'; ?> value="1">
                    Transfer/Referal to : 
                      <strong>
                      <input name="transferto" id="transferto" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                      </strong></td>
				  </tr>
				<tr>
				  <td width="20%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Admit Date </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="admitdate" id="admitdate" style="border: 1px solid #001E6A" value="<?php echo $recorddate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				    <img src="images2/cal.gif" onClick="javascript:NewCssCal('admitdate')" style="cursor:pointer"/>				    </td>
				  <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Discharge Date </td>
				  <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="dischargedate" id="dischargedate" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('dischargedate')" style="cursor:pointer"/></td>
				  <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Leaving Date</td>
				  <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="leavingdate" id="leavingdate" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('leavingdate')" style="cursor:pointer"/></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DISCHARGE DIAGNOSIS: </strong></td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Primary:</td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<?php
					$query4p = "select primarydiag,primaryicdcode from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$visitcode' and primarydiag <> ''  order by auto_number desc";
					$exec4p = mysqli_query($GLOBALS["___mysqli_ston"], $query4p) or die ("Error in Query4p".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res4p = mysqli_fetch_array($exec4p)){
						$primarydiagp = $res4p['primarydiag'];
						$primaryicdcodep = $res4p['primaryicdcode'];
						if($primaryicdcodep!=''){
							 echo $primarydiagp."/ ".$primaryicdcodep."<br> ";
						}
					}
				?>
				  
				  <input name="primary" id="primary" type="hidden" value="<?php  if($primaryicdcode!=''){ echo $primarydiag.'/ '.$primaryicdcode; } ?>" onKeyDown="return disableEnterKey()" size="20"></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Secondary:</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<?php
				
					$query4s = "select secondarydiag,secicdcode from  discharge_icd where patientcode='$patientcode' and patientvisitcode='$visitcode' and secondarydiag <> ''  order by auto_number desc";
					$exec4s = mysqli_query($GLOBALS["___mysqli_ston"], $query4s) or die ("Error in Query4s".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res4s = mysqli_fetch_array($exec4s)){
						$secondarydiags = $res4s['secondarydiag'];
						$secicdcodes = $res4s['secicdcode'];
						if($secicdcodes!=''){
							 echo $secondarydiags."/ ".$secicdcodes."<br> ";
						}
					}
				?>
				  
				  
				  <input name="secondary" id="secondary" type="hidden" value="<?php if($secicdcode!=''){ echo $secondarydiag.'/'.$secicdcode;} ?>" onKeyDown="return disableEnterKey()" size="20"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Operations/Procedure</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><!--<input name="opprocedure" id="opprocedure" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20">-->
				  <textarea name="opprocedure" id="opprocedure" onKeyDown="return disableEnterKey()" cols='30' rows='4'></textarea>
				  </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Date</td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="opprocdate" id="opprocdate" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('opprocdate')" style="cursor:pointer"/></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Other Laboratory/Imaging Findings </td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
				    <!--<input name="otherlabimage" id="otherlabimage" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20">-->
					<textarea name="otherlabimage" id="otherlabimage" onKeyDown="return disableEnterKey()" cols='30' rows='4'></textarea>
				  </span></td>
				  </tr>
				<tr>
				  <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Discharge Medications &amp; Supplies:</strong></td>
				  </tr>
				  <tr>
				    <td colspan="1" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
				    <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><table width="708" border="0">
                      <tr>
                        <td width="245" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medicine Name</strong></td>
                        <td width="59" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Dose</strong></td>
                        <td width="86" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Frequency</strong></td>
                        <td width="87" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Days</strong></td>
                        <td width="90" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Quantity</strong></td>
                        <td width="101" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Route</strong></td>
                      </tr>
   	                <?php 
					$query6 = "SELECT * FROM ipmedicine_issue where visitcode = '$visitcode' and dischargemedicine = 'Yes'";
					$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res6 = mysqli_fetch_array($exec6))
					{
					$itemname = $res6['itemname'];
					$dose = $res6['dose'];
					$frequency = $res6['frequency'];
					$days = $res6['days'];
					$quantity = $res6['quantity'];
					$route = $res6['route'];
					?>
				  <tr>
				  <td colspan="1" align="left" valign="middle"  class="bodytext3"><?php echo $itemname; ?></td>
				  <td colspan="1" align="left" valign="middle"  class="bodytext3"><?php echo $dose; ?></td>
				  <td colspan="1" align="left" valign="middle"  class="bodytext3"><?php echo $frequency; ?></td>
				  <td colspan="1" align="left" valign="middle"  class="bodytext3"><?php echo $days; ?></td>
				  <td colspan="1" align="left" valign="middle"  class="bodytext3"><?php echo intval($quantity); ?></td>
				  <td colspan="3" align="left" valign="middle"  class="bodytext3"><?php echo $route; ?></td>
				  </tr>
					<?php 
					}
				  ?>
                    </table></td>
			      </tr>
				  
			
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Referral/Other Instructions</strong></td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
				    <!--<input name="referother" id="referother" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20">-->
					<textarea name="referother" id="referother" onKeyDown="return disableEnterKey()" cols='30' rows='4'></textarea>

				  </span></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Name</strong></td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
				    <input name="doctorname" id="doctorname" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
				  </span></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Return To Clinic </strong></td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="asneeded" id="instrument1" onClick="return funcpackcheck();" <?php //if($instrument1 == '1') echo 'checked'; ?> value="1">
				    <span class="bodytext3">As Needed </span></td>
				  <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="day" id="day" onClick="return funcpackcheck();" <?php //if($instrument2 == '1')  echo 'checked'; ?> value="1">
				    <span class="style1">Day:</span><span class="bodytext3"><strong>				    <strong>
				    <input name="day1" id="day1" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
				    </strong>				    </strong></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="style1">Date</span></td>
				  <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
				    <input name="returndate" id="returndate" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('returndate')" style="cursor:pointer"/></span></td>
				  <td width="3%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="style1">Time</span></td>
				  <td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				    <input name="returntime" id="returntime" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="8">
				  </strong>					(Ex: HH:MM)				  </td>
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>To See </strong></td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="referdoctor" id="referdoctor" onClick="return funcpackcheck();" <?php //if($abdpacks1 == '1') //echo 'checked'; ?> value="1">				     <span class="style1">Your Referring Doctor/Hospital: 
				     </span><strong><span class="bodytext3"><strong>
				    <input name="referdoctor1" id="referdoctor1" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
				    </strong></span></strong></td>
				  </tr>
				<tr>
				  <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Hospital:</strong></td>
				  </tr>
				<tr>
				  <td colspan="9" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="rconurse" id="rconurse" onClick="return funcpackcheck();" <?php //if($swabs == '1') //echo 'checked'; ?> value="1">				    
				    <span class="style1">RCO/Nurse</span>
				    <p>
				      <input type="checkbox" name="doctor" id="doctor" onClick="return funcpackcheck();" <?php //if($abdpacks2 == '1') //echo 'checked'; ?> value="1">
				      <span class="style1">Dr</span><span class="bodytext3"><strong> <strong>
				        <input name="doctor1" id="doctor1" value="<?php //echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
				        </strong></strong></span>
				      <input type="checkbox" name="opd" id="opd" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
				      <span class="style1">OPD</span><span class="bodytext3"><strong> 
				        <input type="checkbox" name="tb" id="tb" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
				        </strong></span><span class="style1">TB</span><span class="bodytext3"><strong>
                        <input type="checkbox" name="mchfp" id="mchfp" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
                        </strong></span><span class="style1">MCH/FP</span><span class="bodytext3"><strong> <strong>
				        <input type="checkbox" name="treatrm" id="treatrm" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
				        </strong> </strong></span><span class="style1">Treatment Rm</span><span class="bodytext3"><strong>
                        <input type="checkbox" name="gensurg" id="gensurg" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
				        </strong></span><span class="style1">
                        Gen Surg</span><span class="bodytext3"><strong>
                        <input type="checkbox" name="accord" id="accord" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
                        </strong></span><span class="style1">Accord
                        </span><span class="bodytext3"><strong>
<input type="checkbox" name="ortho" id="ortho" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
</strong></span><span class="style1">Ortho</span><span class="bodytext3"><strong>
<input type="checkbox" name="gynae" id="gynae" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
</strong></span><span class="style1">Gynae</span><span class="bodytext3"><strong>
<input type="checkbox" name="paedssurg" id="paedssurg" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
</strong></span><span class="style1">Paeds Surg</span></p>				    
				    <p>
				      <input type="checkbox" name="paeds" id="paeds" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
				        <span class="style1">Paeds</span><strong> <span class="bodytext3"><strong> 
			            <input type="checkbox" name="ent" id="ent" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1"> 
			            </strong></span></strong><span class="style1">ENT</span><strong> 
			            <input type="checkbox" name="other" id="other" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
			            </strong> <span class="style1">Other</span> <span class="bodytext3">
		                <input name="type2" id="type2" value="<?php //echo $type; ?>" onKeyDown="return disableEnterKey()" size="20">
	                </span></p></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>On Return </strong></td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="castoff" id="castoff" onClick="return funcpackcheck();" <?php //if($spconsentward == '1') //echo 'checked'; ?> value="1">				    
				    <span class="style1">Cast Off</span>
				    <input type="checkbox" name="xraylabs" id="xraylabs" onClick="return funcpackcheck();" <?php //if($abdpacks2 == '1') //echo 'checked'; ?> value="1">
				    <span class="style1">X-Ray Labs</span><span class="bodytext3"><strong> 
				    <input name="xraylabs1" id="xraylabs1" value="<?php //echo $type; ?>" onKeyDown="return disableEnterKey()" size="20">
				    </strong></span></td>
				  </tr>
				<tr>
				  <td align="left" valign="left"  bgcolor="#ecf0f5" class="bodytext3"><strong>Discharge Check List : </strong></td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="left"  bgcolor="#ecf0f5" class="bodytext3"><strong>
				    <input type="checkbox" name="patientdischarge" id="patientdischarge" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1"> 
				    </strong>Inform Patient Of Discharge </td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>
                  <input type="checkbox" name="checkreceipt" id="checkreceipt" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1"> 
                  </strong></span><span class="style1">Check Payment Receipt; Cancel Name On Census And Enter In Discharge Book                  </span></td>
				  </tr>
				<tr>
				  <td align="left" valign="left"  bgcolor="#ecf0f5" class="bodytext3"><strong>
                  <input type="checkbox" name="compilefile" id="compilefile" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
</strong>Compile Patient File &amp; Meds </td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>
                  <input type="checkbox" name="educatemeds" id="educatemeds" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
                  </strong></span><span class="style1">Educate On Meds &amp; Instructions </span></td>
				  </tr>
				<tr>
				  <td align="left" valign="left"  bgcolor="#ecf0f5" class="bodytext3"><strong>
                  <input type="checkbox" name="informpatient" id="informpatient" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
</strong>Inform Patient Of Bill </td>
				  <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>
                  <input type="checkbox" name="schedulevisit" id="schedulevisit" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1"> 
                  </strong></span><span class="style1">Call To Schedule Return Visit Is Made 
				  </span></td>
				  </tr>
                <tr>
                  <td align="left"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>
                  <input type="checkbox" name="takerelative" id="takerelative" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
                  </strong></span><span class="style1">Take Patient/Relative To Billing Office </span></td>
                  <td colspan="8" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>
                  <input type="checkbox" name="returnvaluables" id="returnvaluables" onClick="return funcpackcheck();" <?php //if($abdpacks3 == '1') echo 'checked'; ?> value="1">
                  </strong></span><span class="style1">Return Clothes And Valuables </span></td>
                  <td colspan="8" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="8" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="4" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="4" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                
                <tr>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="middle"  bgcolor="#ecf0f5"><input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
                  <input name="Submit222" type="submit"  value="Save" class="button"/></td>
                <td align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>

</table>	</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

