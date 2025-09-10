<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$dateonly2 = date('Y-m-d');
$username = $_SESSION["username"];
$timeonly = date('H:i:s');
$companyname = $_SESSION["companyname"];
$errmsg = "";

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if(isset($_REQUEST['patientcode'])) {$patientcode=$_REQUEST['patientcode']; } else{$patientcode="";}
if(isset($_REQUEST['visitcode'])) {$visitcode = $_REQUEST['visitcode']; } else{$visitcode="";}

$query21 = "select * from master_consultationlist where visitcode='$visitcode' order by auto_number";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num21 = mysqli_num_rows($exec21);

$res21 = mysqli_fetch_array($exec21);
$consultationdatetime = $res21['consultationdate'];

$query1 = "select * from master_customer where customercode = '$patientcode' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1patientcode = $res1['customercode'];
$res1customerfullname = $res1['customerfullname'];
$res1paymenttype = $res1['paymenttype'];
$res1user = $res1['username'];
$res1age = $res1['age'];
$res1gender = $res1['gender'];
$res1accountname = $res1['accountname'];
$res1consultingdoctor = $res1['consultingdoctor'];
$res1nationalidnumber = $res1['nationalidnumber'];

$query5 = "select * from master_accountname where auto_number = '$res1accountname'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$res5accountname = $res5['accountname'];

$queryy=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where visitcode='$visitcode'");
$res6=mysqli_fetch_array($queryy);
$age = $res6['age'];
$gender = $res6['gender'];

$query222 = "select * from sickleave_entry order by auto_number desc limit 0, 1";
$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query2222".mysqli_error($GLOBALS["___mysqli_ston"]));
$res222 = mysqli_fetch_array($exec222);
$res222sickoffnumber = $res222["sickoffnumber"];

$billdigit=strlen($res222sickoffnumber);
if ($res222sickoffnumber == '')
{
	$billnumbercode ='1';
}
else
{
	$billnumber = $res222["sickoffnumber"];
	$billnumbercode =$billnumber;
	
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
}


if($cbfrmflag1 == "cbfrmflag1")
{
   $patientcode = $_REQUEST['patientcode'];
   $visitcode = $_REQUEST['visitcode'];
   $fromdate = $_REQUEST['ADate1'];
   $todate = $_REQUEST['ADate2'];
   $fromreview = $_REQUEST['ADate3'];
   $toreview = $_REQUEST['ADate4'];
   $fromduty = $_REQUEST['ADate5'];
   $toduty = $_REQUEST['ADate6'];
   $nodays1 = $_REQUEST['nodays1'];
   $nodays2 = $_REQUEST['nodays2'];
   $work = $_REQUEST['work'];
   $sicktype = $_REQUEST['sicktype'];
   $remarks = $_REQUEST['remarks'];
   
    if($nodays1 != '')
	 {	
	$query26="insert into sickleave_entry(patientname,patientcode,sickoffnumber,visitcode,recorddate,fromdate,todate,fromreview,toreview,fromduty,toduty,work,nodays1,nodays2,sicktype,remarks,preparedby,status,recordtime)values('$res1customerfullname',
'$patientcode','$billnumbercode','$visitcode','$dateonly2','$fromdate','$todate','$fromreview','$toreview','$fromduty','$toduty','$work','$nodays1','$nodays2','$sicktype','$remarks','$username','completed','$timeonly')";
	$exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
     }
   header("location:sickleavelist.php?patientcodes=$patientcode");
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
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
-->
</style>
</head>

<!--<script>
function funcPopupOnLoader1()
 {
 <?php
   if(isset($_REQUEST['patientcodes'])) {$patientcodes=$_REQUEST['patientcodes']; } else{$patientcodes="";}
   if(isset($_REQUEST['visitcodes'])) {$visitcodes = $_REQUEST['visitcodes']; } else{$visitcodes="";}
 ?>
		var patientcodes;
		var patientcodes = "<?php echo $patientcodes; ?>";
		var visitcodes;
		var visitcodes = "<?php echo $visitcodes; ?>";
		//alert(visitcodes);
		if(patientcodes != "") 
		{
			window.open("print_sickleave.php?patientcode="+patientcodes,"OriginalWindowA5",'width=700,height=700,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
        }
    
 }				
</script>
-->

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
	  
	function DateDiff() {
		var date1 = document.getElementById("ADate1").value;
		var date2 = document.getElementById("ADate2").value;
		
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
		document.getElementById("nodays1").value = timeDifferenceInDays;
	}
	
	function DateDiff1() {
		var date1 = document.getElementById("ADate5").value;
		var date2 = document.getElementById("ADate6").value;
		
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
		document.getElementById("nodays2").value = timeDifferenceInDays;
	}
</script>

<script src="js/datetimepicker_css.js"></script>
<body>
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
	   <form name="form1" id="form1" method="post" action="sickleave.php">
        <tr bgcolor="#ecf0f5">
		          <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
          <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
          <td width="20%" class="bodytext3" align="left" valign="middle" bgcolor="#ecf0f5"><?php echo $res1customerfullname; ?>
		  <input type="hidden" name="patientnames" value="<?php echo $res1customerfullname; ?>">
		  <input type="hidden" name="visitcode" value="<?php echo $visitcode; ?>">

		  </td>
          <td bgcolor="#ecf0f5" class="bodytext3"><strong>Date </strong></td>
          <td width="26%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $updatedatetime; ?></td>
          <td width="11%" align="left" valign="middle" class="bodytext3"><strong>Sick Off No. </strong></td>
          <td width="21%" align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode; ?></td>
		  <input type="hidden" name="sickoffnumber" id="sickoffnumber" value="<?php echo $sickoffnumber; ?>">
       
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Code</strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" ><?php echo $patientcode; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Scheme</strong></td>
          <td align="left" valign="top" class="bodytext3"><?php echo $res5accountname; ?></td>
          <td align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td align="left" valign="top" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
          <td align="left" valign="middle" class="bodytext3"><?php echo $res1age; ?> & <?php echo $res1gender; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor</strong></td>
          <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo strtoupper($username); ?></td>
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
          <td width="860"><table width="1336" height="96" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
				<tr>
				  <td height="21" colspan="14" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>THIS IS TO CERTIFY THAT : </strong><strong><?php echo $res1customerfullname; ?></strong></td>
			    </tr>
				<tr>
				  <td height="21" colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>OF P/NO : </strong><?php echo $patientcode; ?></td>
				  <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>SECTION : </strong></span></td>
			    </tr>
				
			   <tr>
			     <td colspan="8" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><p>IS SICK AND REQUIRES SICK OFF</p>			      </td>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		        </tr>
			   <tr>
			     <td width="143" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">FROM DATE: </td>
			     <td width="140" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="ADate1" id="ADate1" value="<?php //echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></span></td>
			     <td width="96" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TO DATE: </td>
			     <td width="149" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="ADate2" id="ADate2" value="<?php //echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" onChange="return DateDiff();"/>
                  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/></span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">No. of DAYS: <span class="bodytext31">
			       <input name="nodays1" id="nodays1" value=""  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			     </span></td>
			     <td width="95" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Work Related: </td>
			     <td width="63" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><select name="work" id="work">
                   <option value="1">No</option>
                   <option value="2">Yes</option>
                 </select></td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TYPE OF SICK OFF: </td>
			     <td width="199" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="sicktype" id="sicktype" value=""  size="20" onKeyDown="return disableEnterKey()" />
			     </span></td>
			   </tr>
			   
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">DATE  OF REVIEW : </td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="ADate3" id="ADate3" value="<?php //echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                   <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate3')" style="cursor:pointer"/></span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td width="124" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td width="87" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		        </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TO RESUME DUTY ON : </td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="ADate4" id="ADate4" value="<?php //echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                   <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate4')" style="cursor:pointer"/></span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">LIGHT DUTY FROM : </td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="ADate5" id="ADate5" value="<?php //echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                   <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate5')" style="cursor:pointer"/></span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		        </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">LIGHT DUTY TO :</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="ADate6" id="ADate6" value="<?php //echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" onChange="return DateDiff1();"/>
                   <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate6')" style="cursor:pointer"/></span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">No. of Days : </td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="nodays2" id="nodays2" value="<?php //echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			     </span></td>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		        </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">REMARKS : </td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext31">
			       <input name="remarks" id="remarks" value=""  size="20"  onKeyDown="return disableEnterKey()" />
			     </span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		        </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		        </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">PREPARED BY :&nbsp;&nbsp; <strong><?php echo strtoupper($username); ?></strong></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">DATE :&nbsp;<?php echo $updatedatetime; ?></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TIME: <?php echo $timeonly; ?></td>
		        </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		        </tr>
			   		  
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td width="147" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				 	<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Save" name="Submit"/>				 </td>
		        </tr>
            </tbody>
          </table></td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

