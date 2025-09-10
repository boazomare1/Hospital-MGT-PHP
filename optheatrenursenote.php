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
	$patientage = $_REQUEST["patientage"];
	$patientgender = $_REQUEST["patientgender"];
	$operationname = $_REQUEST["operationname"];
	$patientgender = $_REQUEST["patientage"];
	$patientgender = $_REQUEST["patientgender"];
	$ward = $_REQUEST["ward"];
	$bed = $_REQUEST["bed"];
	$timein = $_REQUEST["timein"];
	$surgeon = $_REQUEST["surgeon"];
	$assistant = $_REQUEST["assistant"];
	$receivedby = $_REQUEST["receivedby"];
	$receivedbynote = $_REQUEST["receivedbynote"];
	$anaesthetist = $_REQUEST["anaesthetist"];
	$intraname = $_REQUEST["intraname"];
	$intradate = $_REQUEST["intradate"];
	$intratime = $_REQUEST["intratime"];
	$recoveryroom = $_REQUEST["recoveryroom"];
	$recoverytime = $_REQUEST["recoverytime"];
	$recoverynote = $_REQUEST["recoverynote"];
	$handoverby = $_REQUEST["handoverby"];
	$handoverdate = $_REQUEST["handoverdate"];
	$handovertime = $_REQUEST["handovertime"];
	
	$query7 = "select * from optheatrenursenotes where patientcode='$patientcode' and visitcode='$visitcode' ";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums7 = mysqli_num_rows($exec7);
	
	if($nums7 == '0')
	{

		if($patientcode!='' && $visitcode!='')
		{
			$query5 = "insert into optheatrenursenotes (docno,patientname,patientcode,visitcode,patientage,wardnumber,bednumber,timein,surgeon,assistant,receivedby,receivedbynote,anaesthetist,intraname,intradate,intratime, recoveryroom,recoverytime,recoverynote,handoverby,handoverdate,handovertime,recorddate,status,username,updatetime,ipaddress,locationname,locationcode)
			 VALUES('$docno', '$patientfullname','$patientcode','$visitcode','$patientage','$ward','$bed','$timein','$surgeon', '$assistant','$receivedby','$receivedbynote','$anaesthetist','$intraname','$intradate','$intratime', '$recoveryroom','$recoverytime','$recoverynote','$handoverby','$handoverdate','$handovertime','$recorddate','$status','$username','$updatedatetime', '$ipaddress','$locationname','$locationcode')";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
	}	
		else
	     {
		   if($patientcode!='' && $visitcode!='')
		    {
		   	$query6 = "update optheatrenursenotes set timein='$timein', surgeon='$surgeon',assistant='$assistant',receivedby='$receivedby',receivedbynote='$receivedbynote',anaesthetist='$anaesthetist',intraname='$intraname',intradate='$intradate',intratime='$intratime',
			recoveryroom='$recoveryroom',recoverytime='$recoverytime',recoverynote='$recoverynote',handoverby='$handoverby',handoverdate='$handoverdate',handovertime='$handovertime',recorddate='$recorddate',status='$status',username='$username',locationname='$locationname', locationcode='$locationcode'  where patientcode='$patientcode' and visitcode='$visitcode' ";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		    }
		 }	
	   header("Location:otpatients.php");

}

if($visitcode!='' && $patientcode!='')
{
	
	$query8 = "select * from optheatrenursenotes where patientcode='$patientcode' and visitcode='$visitcode' ";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums8 = mysqli_num_rows($exec8);
	if($nums8 > 0)
	{
	$res8 = mysqli_fetch_array($exec8);
	$res8patientname= $res8["patientname"];
	$res8patientcode = $res8["patientcode"];
	$res8locationcode = $res8["locationcode"];
	$res8patientage = $res8["visitcode"];
	$patientage = $res8["patientage"];
	$res8patientgender = $res8["patientgender"];
	$res8operationname = $res8["operationname"];
	$res8patientage = $res8["patientage"];
	$res8patientgender = $res8["patientgender"];
	$res8ward = $res8["ward"];
	$res8bed = $res8["bed"];
	$res8timein = $res8["timein"];
	$res8surgeon = $res8["surgeon"];
	$res8assistant = $res8["assistant"];
	$res8receivedby= $res8["receivedby"];
	$res8receivedbynote = $res8["receivedbynote"];
	$res8anaesthetist = $res8["anaesthetist"];
	$res8intraname = $res8["intraname"];
	$res8intradate = $res8["intradate"];
	$res8intratime = $res8["intratime"];
	$res8recoveryroom = $res8["recoveryroom"];
	$res8recoverytime = $res8["recoverytime"];
	$res8recoverynote = $res8["recoverynote"];
	$res8handoverby = $res8["handoverby"];
	$res8handoverdate = $res8["handoverdate"];
	$res8handovertime = $res8["handovertime"];
	}
	else
	{
	$res8patientname= '';
	$res8patientcode = '';
	$res8patientage = '';
	$res8patientage = '';
	$res8patientgender = '';
	$res8operationname = '';
	$res8patientage = '';
	$res8patientgender = '';
	$res8ward = '';
	$res8bed ='';
	$res8timein='00:00';
	$res8surgeon = '';
	$res8assistant = '';
	$res8receivedby= '';
	$res8receivedbynote = '';
	$res8anaesthetist = '';
	$res8intraname = '';
	$res8intradate ='';
	$res8intratime = '00:00';
	$res8recoveryroom ='';
	$res8recoverytime = '00:00';
	$res8recoverynote ='';
	$res8handoverby = '';
	$res8handoverdate = '';
	$res8handovertime = '00:00';
	}
}
?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
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
.style1 {COLOR: #3B3B3C; FONT-FAMILY: Tahoma; font-size: 11px;}
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
<form name="form1" id="form1" method="post" action="optheatrenursenote.php" onSubmit="return from1submit1()">

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
          <td width="10%" align="left" valign="middle" class="bodytext3"><strong>Ward/Bed</strong></td>
          <td width="13%" align="left" valign="middle" class="bodytext3"><?php echo $res30ward; ?>/<?php echo $res31bed; ?>
		    <input type="hidden" name="ward" id="ward" value="<?php echo $res30ward; ?>" style="border: 1px solid #001E6A;" size="45">
		    <input type="hidden" name="bed" id="bed" value="<?php echo $res31bed; ?>" style="border: 1px solid #001E6A;" size="45"></td>
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
          <td align="left" valign="top" class="bodytext3"><input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" />
            <?php echo $locationname; ?> <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>"></td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
		  <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong>
            <table width="1063" height="583" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
              <tbody>
                <tr>
                  <td height="21" colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong>THEATRE NURSE'S NOTES </strong></td>
                </tr>
                <!--<tr>
                <td colspan="12" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>-->
                <tr>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Time In </strong></td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="timein" id="timein" value="<?php echo date('H:i',strtotime($res8timein)); ?>"  size="10"  onKeyDown="return disableEnterKey()" />
                    <span class="bodytext32">(Ex: HH:MM)</span></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Surgeon</strong><strong>&nbsp;</strong></td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="surgeon" id="surgeon" value="<?php echo $res8surgeon; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                
                <tr>
                  <td height="30" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Assistant</strong></td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="assistant" id="assistant" value="<?php echo $res8assistant; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td height="27" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Pre-Operative</strong></td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                </tr>
                <tr>
                  <td width="4%" height="30" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">&nbsp;</td>
                  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Received By </td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="receivedby" id="receivedby" value="<?php echo $res8receivedby; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                <tr>
                  <td height="43" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><textarea cols="40" rows="4" id="receivedbynote" name="receivedbynote" value=""><?php echo $res8receivedbynote; ?></textarea></td>
                </tr>
                
                <tr>
                  <td height="27" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> Intra-Operative </strong></td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                </tr>
                <tr>
                  <td height="30" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Anaesthetist</td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="anaesthetist" id="anaesthetist" value="<?php echo $res8anaesthetist; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Name</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="intraname" id="intraname" value="<?php echo $res8intraname; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Date</td>
                  <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="intradate" id="intradate" style="border: 1px solid #001E6A" value="<?php echo $res8intradate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('intradate')" style="cursor:pointer"/></td>
                  <td width="2%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td width="3%" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" aalign="left">Time</td>
                  <td width="34%" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" aalign="left"><input name="intratime" id="intratime" value="<?php echo date('H:i',strtotime($res8intratime)); ?>"  size="10"  onKeyDown="return disableEnterKey()" />
                    <span class="bodytext32">(Ex: HH:MM)</span></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Post-Operative</strong></td>
                  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Recovery Room </td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="recoveryroom" id="recoveryroom" value="<?php echo $res8recoveryroom; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Time:</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="recoverytime" id="recoverytime" value="<?php echo date('H:i',strtotime($res8recoverytime)); ?>"  size="10" onKeyDown="return disableEnterKey()" /></td>
                  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td colspan="6" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3"><textarea name="recoverynote" cols="40" rows="4" id="recoverynote"><?php echo $res8recoverynote; ?></textarea></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td colspan="6" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">Handed Over To Ward </td>
                  <td colspan="6" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1">By Name </td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="handoverby" id="handoverby" value="<?php echo $res8handoverby; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                  <td width="4%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5">Date</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="handoverdate" id="handoverdate" style="border: 1px solid #001E6A" value="<?php echo $res8handoverdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('handoverdate')" style="cursor:pointer"/></td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Time</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="handovertime" id="handovertime" value="<?php echo date('H:i',strtotime($res8handovertime)); ?>"  size="10"  onKeyDown="return disableEnterKey()" />
                    <span class="bodytext32">(Ex: HH:MM)</span></td>
                </tr>
                
                
                <tr>
                  <td colspan="2" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="2" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="4" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="2" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                  <td colspan="4" align="middle"  bgcolor="#ecf0f5">
				      <input type="hidden" name="frmflag1" value="frmflag1" />
                      <input name="Submit222" type="submit"  value="Save Notes" class="button"/></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
        </tr>
      </tbody>
    </table> 
</form>
</body>
</html>

