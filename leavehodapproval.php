<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno1 = $_SESSION['docno'];
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	//print_r($_POST);
	$approvalstatus = '';
	$docno = $_REQUEST['docno'];
	$fromdate = $_REQUEST['fromdate'];
	$todate = $_REQUEST['todate'];
	$totaldays = $_REQUEST['totaldays'];
	if(isset($_REQUEST['approve'])) { $approvalstatus = 'approved'; }
	if(isset($_REQUEST['discard'])) { $approvalstatus = 'rejected'; }
	
	$query4 = "update leave_request set from_date = '$fromdate', to_date = '$todate', total_days = '$totaldays', approvalstatus = '$approvalstatus',
			   hodusername = '$username', hodupdatedatetime = '$updatedatetime' where docno = '$docno'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	header("location:leavehodapprovallist.php");
	exit;
}

//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$referalname=$_REQUEST['delete'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_referal where referalname='$referalname'");
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



//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];



/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));
$res99 = mysqli_fetch_array($exec99);
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

?>


<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

 $query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];

$query23 = "select * from master_employeelocation where username='$username' and defaultstore='default' and locationcode='".$locationcode."'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);

$res7storeanum = $res23['storecode'];
$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
$storecode = $res75['storecode'];
?>
<?php 
if(isset($_REQUEST['docno']))
{
$docno = $_REQUEST['docno'];
}

?>
<script language="javascript">
function deletevalid()
{
var del;
del=confirm("Do You want to delete this referal ?");
if(del == false)
{
return false;
}
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




function funcPopupPrintFunctionCall()
{
	
}

//Print() is at bottom of this page.

</script>
<?php include ("js/sales1scripting1.php"); ?>
<script type="text/javascript">

function loadprintpage1(varPaperSizeCatch)
{}

function cashentryonfocus1()
{}

function funcbalcalc() //Function to CST Taxes if required.
{
	var alloweddays = document.getElementById("alloweddays").value;
	var totaldays = document.getElementById("totaldays").value;
	var leavedays = document.getElementById("leavedays").value;
	
	var calc = parseFloat(alloweddays) - (parseFloat(totaldays) + parseFloat(leavedays));
	document.getElementById("balancedays").value = calc;
	if(parseInt(calc) < 0)
	{
		document.getElementById("approve").checked = false;	
		document.getElementById("approve").disabled = true;	
		document.getElementById("saveindent").disabled = true;	
	}
	else
	{
		document.getElementById("approve").disabled = false;
		document.getElementById("saveindent").disabled = false;		
	}
}

function funcOnLoadBodyFunctionCall()
{
	funcbalcalc();
}


</script>
<script>
function funqty(id)
{}
function calc(serialnumber,totalcount)
{}

</script>
<script language="JavaScript">
	
	function process()
	{	
		if(document.getElementById("discard").checked==false && document.getElementById("approve").checked==false)
		{
			alert('Select Approve or Reject Checkbox');
			return false;
		}
		if(document.getElementById("discard").checked==true && document.getElementById("approve").checked==true)
		{
			alert('Select Any One Approve or Reject Checkbox');
			return false;
		}
	
		document.getElementById("saveindent").disabled=true;
	}
	


Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf())
    date.setDate(date.getDate() + days);
    return date;
}

 function DayCalc() { // input given as Date objects
 
 	if (document.form1.fromdate.value == "")
	{
		alert ("Please Enter From Date.");
		document.form1.fromdate.focus();
		document.form1.todate.value = '';
		return false;
	}
		var startDate1 = document.getElementById("fromdate").value;
		var endDate1 = document.getElementById("todate").value;
		
		var startDate = new Date(startDate1);
		var endDate = new Date(endDate1);


		var count = 0;
		var curDate = startDate;
		while (curDate <= endDate) {
			var dayOfWeek = curDate.getDay();
			var isWeekend = (dayOfWeek == 6) || (dayOfWeek == 0); 
			if(!isWeekend)
				count++;
				curDate = curDate.addDays(1);
		}
		
		document.getElementById("totaldays").value = (count); // add 1 because dates are inclusive
		funcbalcalc();
  }
</script>
<script >

 function DateCalc() { // input given as Date objects
	
	var numberOfDays = document.getElementById("leavestype").value;
	var numberOfDays = numberOfDays.split('|');
	var noOfDays = numberOfDays[0];
	var noOfDaysType = numberOfDays[1];
	//alert(noOfDays);
	//alert(noOfDaysType);
	
		if (noOfDays != "0" && noOfDaysType =='Annual Leave' || noOfDaysType =='Maternity Leave' || noOfDaysType =='Paternity Leave' || noOfDaysType =='Compassionate Leave' )
	{
		var startDate1 = document.getElementById("fromdate").value;
		
		var count1 = 0;
		var endDate = "";
		var startDate = new Date(startDate1);
		var noOfDaysToAdd = noOfDays -1;
		/* 	var startDate = "15-Aug-2018";
		startDate = new Date(startDate.replace(/-/g, "/")); 
		//alert(startDate);
		*/
		
		while(count1 < noOfDaysToAdd){
			endDate = new Date(startDate.setDate(startDate.getDate() + 1));
			if(endDate.getDay() != 0 && endDate.getDay() != 6){
				//Date.getDay() gives weekday starting from 0(Sunday) to 6(Saturday)
				count1++;
			}
		}
		//alert(endDate);
		var	month = '' + (endDate.getMonth() + 1),
			day = '' + endDate.getDate(),
			year = endDate.getFullYear();
			
		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;
			
		var endDate1 = year+"-"+month+"-"+day;
		//alert(endDate1);

		document.getElementById("todate").value = endDate1;
		document.getElementById("totaldays").value = noOfDays;
	}else if (noOfDays != "0" && noOfDaysType =='Absence' || noOfDaysType =='Sick Leave' || noOfDaysType =='Unpaid Leave' || noOfDaysType =='Study Leave' )
	{
		var startDate1 = document.getElementById("fromdate").value;
		var endDate1 = document.getElementById("todate").value;
		
		var startDate = new Date(startDate1);
		var endDate = new Date(endDate1);
		var count = 0;
		var count1 = 0;
		var curDate = startDate;
		
		while (curDate < endDate) {
			var dayOfWeek = curDate.getDay();
			var isWeekend = (dayOfWeek == 6) || (dayOfWeek == 0); 
			if(!isWeekend)
				count++;
				curDate = curDate.addDays(1);
			
		}
		
		if(count > noOfDays){
			var noOfDaysToAdd = parseInt(count)- parseInt(noOfDays);
			alert(noOfDaysToAdd);
			while(count1 <= noOfDaysToAdd){
				curDate = new Date(curDate.setDate(curDate.getDate() - 1));
				if(curDate.getDay() != 0 && curDate.getDay() != 6){
					//Date.getDay() gives weekday starting from 0(Sunday) to 6(Saturday)
					count1++;
				}
			}
			count1 = noOfDays;
		
		}else{
			count1 = count+1;
		}
		
		var	month = '' + (curDate.getMonth() + 1),
			day = '' + curDate.getDate(),
			year = curDate.getFullYear();
			
		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;
		
		var endDate11 = year+"-"+month+"-"+day;
		
		document.getElementById("todate").value = endDate11;
		document.getElementById("totaldays").value = (count1); // add 1 because dates are inclusive
		funcbalcalc();
		
	}else{
		var startDate1 = document.getElementById("fromdate").value;
		var endDate1 = document.getElementById("todate").value;
		
		var startDate = new Date(startDate1);
		var endDate = new Date(endDate1);


		var count = 0;
		var curDate = startDate;
		while (curDate <= endDate) {
			var dayOfWeek = curDate.getDay();
			var isWeekend = (dayOfWeek == 6) || (dayOfWeek == 0); 
			if(!isWeekend)
				count++;
				curDate = curDate.addDays(1);
		}
		
		document.getElementById("totaldays").value = (count); // add 1 because dates are inclusive
		funcbalcalc();
	}
	
}
  
  
</script>
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
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma;
}
#remarks{
	border-color:red;
	}
input[name="priority"] {
  -webkit-appearance: checkbox; /* Chrome, Safari, Opera */
  -moz-appearance: checkbox;    /* Firefox */
  -ms-appearance: checkbox;     /* not currently supported */
}
</style>

<script src="js/datetimepicker_css_noweekend.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
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
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
    <form name="form1" id="frmsales" method="post" action="" onKeyDown="return disableEnterKey(event)" onSubmit="return process()">

      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="5" cellspacing="5" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
            <tr>
            <td colspan="8">&nbsp;</td>
            </tr>
              <tr>
              <td bgcolor="#ecf0f5" colspan="8" class="bodytext3" align="left"><strong>Leave Request HOD Approval</strong></td>
              </tr>
               <tr>
              <td width="4%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="11%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Req Date</strong></div></td>
              <td width="9%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No </strong></div></td>
				 <td width="30%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Employee Name</strong></div></td>
				<td width="15%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Leave Type</strong></div></td>
              <td width="17%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From Date</strong></div></td>
                <td width="20%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>To Date</strong></div></td>
                <td width="15%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Total Days</strong></div></td>
                <td width="4%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong></strong></div></td>
              </tr>
			 <?php 
			if(isset($_REQUEST['docno']))
			{
			$query1 = "select * from leave_request where docno = '$docno' order by entrydate";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$date = $res1['entrydate'];
			$user = $res1['username'];
			$fromdate = $res1['from_date'];
			$todate = $res1['to_date'];
			$status = $res1['status'];
			$docno1 = $res1['docno'];
			$remarks = $res1['remarks'];
			$total_days = $res1['total_days'];
			$employeecode = $res1['employeecode'];
			$employeename = $res1['employeename'];
			$approvalstatus = $res1['approvalstatus'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$leavestypearr1 = $res1['leavestype'];
			
			if($leavestypearr1 !=''){
				$leavestypearr = explode('|',$leavestypearr1);
				$leavestypeval = $leavestypearr[0];
				$leavestype = $leavestypearr[1];
				
			}else{
				$leavestypeval = '';
				$leavestype = '';
			}
			
			if($leavestypearr1 ==''){
				$onchange ='onChange="return DayCalc()"';
				
			}else{
				if($leavestypeval !='0' || $leavestypeval !=''){
					$onchange ='onChange="return DateCalc()"';
					
				}else{
					$onchange ='onChange="return DayCalc()"';
				}
			}
			
			
			$leavestypes = preg_replace('/\s+/', '', strtolower($leavestype));
			
			if($leavestype !=''){
			
			//$query88 = "select allowed_leavedays,annualleave,maternityleave,paternityleave,compassionateleave,absence, sickleave, unpaidleave, studyleave from master_employee where employeecode = '$employeecode' and status <> 'deleted'";
			
			$query88 = "select `$leavestypes` as `allowed_leavedays` from master_employee where employeecode = '$employeecode' and `$leavestypes` = '$leavestypeval' and status <> 'deleted'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res88 = mysqli_fetch_array($exec88);
			$allowed_leavedays = $res88['allowed_leavedays'];
			}else{
				$allowed_leavedays = 0;
			}
			$query89 = "select sum(total_days) as total_days from leave_request where employeecode = '$employeecode' and approvalstatus = 'approved' and docno <> '$docno' and leavestype = '$leavestypearr1' and status <> 'deleted'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res88 = mysqli_fetch_array($exec88);
			$leavedays = $res88['total_days'];
			if($leavedays ==''){
				$leavedays = 0;
			}
			$pendingdays = $allowed_leavedays - $leavedays;
			
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
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div>
			  <input type="hidden" name="leavedays" id="leavedays" value="<?= $leavedays; ?>">
            </td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $docno1;?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $employeename; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $leavestype; ?></div>
				<input type="hidden" name="leavestype" id="leavestype" value="<?= $leavestypeval.'|'.$leavestype;?>">
				</td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><input name="fromdate" id="fromdate" value="<?php echo $fromdate; ?>" style="border: 1px solid #001E6A;" size="8" readonly <?= $onchange;?> />
                 <img src="images2/cal.gif" onClick="javascript:NewCssCal('fromdate')" style="cursor:pointer"/></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><input name="todate" id="todate" value="<?php echo $todate; ?>" style="border: 1px solid #001E6A;" size="8" readonly <?= $onchange;?> />
                 <img src="images2/cal.gif" onClick="javascript:NewCssCal('todate')" style="cursor:pointer"/></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="text" name="totaldays" id="totaldays" value="<?php echo $total_days; ?>" size="2" readonly /></div></td>
                 <td class="bodytext31" valign="center" align="left">
			    <div align="left">&nbsp;</div></td>
              </tr>
              <tr>
              <td colspan="3" align="right" class="bodytext3"><strong>Remarks</strong></td>
              <td colspan="4" class="bodytext31" valign="center"  align="left"><div align="left"><textarea rows="3" cols="60" readonly><?php echo $remarks; ?></textarea></div></td>
              </tr>
			<?php			
			$allowed_leavedays
			?>			  
            </tbody>
        </table></td>
      </tr>
      <tr bgcolor="#CCC">
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
	  <td>
	  <table width="100%">
     <tr>
	 <td width="72" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">User Name</td>
	   <td width="75" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input type="text" name="username" value="<?php echo $username; ?>" readonly size="10"></td>
	   <td width="56" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><td width="56" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
	    <td width="189" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" calign="left"><strong>Allowed : </strong>
        <input type="" name="alloweddays" id="alloweddays" value="<?= $allowed_leavedays; ?>" readonly size="2" /> Days</td>
	    <td width="189" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" calign="left"><strong>Balance : </strong><input type="" name="balancedays" id="balancedays" value="<?php  $pendingdays; ?>" readonly size="2" /> Days</td>
      <td width="41" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Reject</td>
	   <td width="46" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input type="checkbox" id="discard" name="discard" value="<?php echo $docno; ?>"> </td>
      <td width="45" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Approve</td>
	   <td width="89" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input type="checkbox" name="approve" id="approve" value="<?php echo $docno; ?>" <?php if($pendingdays<=0){ echo "disabled"; } ?>></td>
	  </tr>
	
		</table>
		</td>
		</tr>				
		   <?php
			}
			?>
      <tr>
        <td align="left"></td>
		 <td colspan="1" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
          <input type="hidden" name="docno" id="docno" value="<?php echo $docno; ?>">
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Save" class="button" id="saveindent" <?php if($pendingdays<=0){ echo "disabled"; } ?>>		 </td>
              
      </tr>
	  </table>
      </td>
      </tr>
     </form>
  </table>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
