<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$amount1 = '';
$percent1 = '';
if (isset($_REQUEST["type"])) { $global = $_REQUEST["type"]; } else { $global = ""; }

$query23 = "select employeecode, employeename, supervisor from master_employee where status NOT IN ('Deleted','Inactive') and username = '$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$employeecode = $res23['employeecode'];
$employeename = $res23['employeename'];
$supervisor_name = $res23['supervisor'];

$query23 = "select employeecode, employeename from master_employee where status NOT IN ('Deleted','Inactive') and employeename LIKE '%$supervisor_name%'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$supervisorcode = $res23['employeecode'];
$supervisorname = $res23['employeename'];

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$paynowbillprefix1 = 'LRQ-';
	$paynowbillprefix12=strlen($paynowbillprefix1);
	$query23 = "select * from leave_request order by auto_number desc limit 0, 1";
	$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_fetch_array($exec23);
	$billnumber1 = $res23["docno"];
	$billdigit1=strlen($billnumber1);
	if ($billnumber1 == '')
	{
		$billnumbercode1 ='LRQ-'.'1';
		$openingbalance1 = '0.00';
	}
	else
	{
		$billnumber1 = $res23["docno"];
		$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
		//echo $billnumbercode;
		$billnumbercode1 = intval($billnumbercode1);
		$billnumbercode1 = $billnumbercode1 + 1;
	
		$maxanum1 = $billnumbercode1;
		
		
		$billnumbercode1 = 'LRQ-'.$maxanum1;
		$openingbalance1 = '0.00';
		//echo $companycode;
	}

	$employeecode = $_REQUEST['employeecode'];
	$employeename = $_REQUEST['employeename'];
	$fromdate = $_REQUEST['fromdate'];
	$todate = $_REQUEST['todate'];
	$totaldays = $_REQUEST['totaldays'];
	$remarks = $_REQUEST['remarks'];
	$supervisor = $_REQUEST['supervisor'];
	$supervisorcode = $_REQUEST['supervisorcode'];
	$leavestype = $_REQUEST['leavestype'];
	
	
	$query77 = "INSERT INTO `leave_request`(`entrydate`, `docno`, `employeecode`, `employeename`, `from_date`, `to_date`, `total_days`, `remarks`, `supervisor`, `supervisorcode`, `username`, `ipaddress`, `updatedatetime`,`leavestype`) 
	VALUES ('".date('Y-m-d')."', '$billnumbercode1', '$employeecode', '$employeename', '$fromdate', '$todate', '$totaldays', '$remarks', '$supervisor', '$supervisorcode', '$username', '$ipaddress', '$updatedatetime', '$leavestype')";
	$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	header("location:leaverequest.php?st=success");
	exit;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if($st=='success')
{
	$msg = "Saved successfully";
}
else
{
	$msg = '';	
}

$gendertype = "SELECT gender FROM master_employeeinfo WHERE employeecode = '$employeecode' ";
$genderexec = mysqli_query($GLOBALS["___mysqli_ston"], $gendertype);
$genderes = mysqli_fetch_array($genderexec);
$gender = strtolower($genderes['gender']);

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      
<script>
$(document).ready(function(e) {
	
	$('#supervisor').keyup(function(){
		$('#supervisorcode').val('');
	});
   
		$('#supervisor').autocomplete({
		
	source:"ajaxsupervisor_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var s_code=ui.item.s_code;
			var accountanum=ui.item.anum;	
			$('#supervisorcode').val(s_code);		
			},
    
	});
		
});
</script>

<script language="javascript">
function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.fromdate.value == "")
	{
		alert ("Please Enter From Date.");
		document.form1.fromdate.focus();
		return false;
	}
	if (document.form1.todate.value == "")
	{
		alert ("Please Enter To Date.");
		document.form1.todate.focus();
		return false;
	}
	if (document.form1.remarks.value == "")
	{
		alert ("Please Enter Remarks.");
		document.form1.remarks.focus();
		return false;
	}
	if (document.form1.supervisorcode.value == "")
	{
		alert ("Please Enter Supervisor.");
		document.form1.supervisor.focus();
		return false;
	}
}

/* function DayCalc()
{
	if (document.form1.fromdate.value == "")
	{
		alert ("Please Enter From Date.");
		document.form1.fromdate.focus();
		document.form1.todate.value = '';
		return false;
	}
		var date1 = document.getElementById("fromdate").value;
		var date2 = document.getElementById("todate").value;
		
		date1 = date1.split('-');
		date2 = date2.split('-');
		
		// Now we convert the array to a Date object, which has several helpful methods
		date1 = new Date(date1[0], parseInt(date1[1]) - 1, date1[2]);
		date2 = new Date(date2[0], parseInt(date2[1]) - 1, date2[2]);
		
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
		timeDifferenceInDays = parseInt(timeDifferenceInDays) + parseInt(1);
		if(timeDifferenceInDays < 0)
		{
			alert("Please select proper dates");
			document.getElementById("todate").value = '';
			return false;
		}
		document.getElementById("totaldays").value = timeDifferenceInDays;
} */


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
        var isWeekend = (dayOfWeek == 0); 
        if(!isWeekend)
           count++;
        curDate = curDate.addDays(1);
    }
  

    document.getElementById("totaldays").value = (count); // add 1 because dates are inclusive
  }
  
  
 function DateCalc() { // input given as Date objects

	if (document.form1.leavestype.value == "")
	{
		alert ("Please Select Leaves Type.");
		document.form1.leavestype.focus();
		document.form1.todate.value = '';
		document.form1.totaldays.value = '';
		return false;
	}
		
		
	var numberOfDays = document.getElementById("leavestype").value;
	var numberOfDays = numberOfDays.split('|');
	var noOfDays = numberOfDays[0];
	var noOfDaysType = numberOfDays[1];
	//alert(noOfDaysType);
	
	if (noOfDays != "0" )
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
			if(endDate.getDay() != 0 ){
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
	}else if (noOfDays != "0")
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
			var isWeekend = (dayOfWeek == 0); 
			if(!isWeekend)
				count++;
				curDate = curDate.addDays(1);
			
		}
		
		if(count > noOfDays){
			var noOfDaysToAdd = parseInt(count)- parseInt(noOfDays);
			
			while(count1 <= noOfDaysToAdd){
				curDate = new Date(curDate.setDate(curDate.getDate() - 1));
				if(curDate.getDay() != 0 ){
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
		
	}else{
		var startDate1 = document.getElementById("fromdate").value;
		var endDate1 = document.getElementById("todate").value;
		
		var startDate = new Date(startDate1);
		var endDate = new Date(endDate1);
		
		var count = 0;
		var curDate = startDate;
		while (curDate <= endDate) {
			var dayOfWeek = curDate.getDay();
			var isWeekend = (dayOfWeek == 0); 
			if(!isWeekend)
			count++;
			curDate = curDate.addDays(1);
		}
		document.getElementById("totaldays").value = (count++); // add 1 because dates are inclusive
	}
	
}
  
$(function() {
$('#employeename').autocomplete({
	source:'autoemployeesearch.php?requestfrm=employeename&', 
	select: function(event,ui){
			var accountname=ui.item.value;
			var code = ui.item.code;
			var anum = ui.item.anum;
			var supervisorcode = ui.item.supervisorcode;
			var supervisorname = ui.item.supervisorname;
			
			$('#employeecode').val(code);
			$('#supervisorcode').val(supervisorcode);
			$('#supervisor').val(supervisorname);
			},
	html: true
    });
});
</script>
<script src="js/datetimepicker_css.js"></script>
<body>
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
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="leaverequest.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Leave Request</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($st == '') { echo '#FFFFFF'; } else if ($st == 'success') { echo '#FFBF00'; } else if ($st == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $msg; ?></div></td>
                      </tr>
                    <?php if($global != ''){?>  
                    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Employee Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                        <input name="employeename" id="employeename" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
                        <input type="hidden" name="employeecode" id="employeecode" ></td>
                    </tr>
					<?php }else{ ?>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Employee Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                        <input type="hidden" name="employeecode" id="employeecode" value="<?php echo $employeecode; ?>">
						<input name="employeename" id="employeename" value="<?php echo $employeename; ?>" style="border: 1px solid #001E6A;" size="40" readonly /></td>
                      </tr>
					<?php } ?>
				<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Leaves Type </div></td>
					<td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="leavestype" id="leavestype" onChange="return DateCalc()" >
							<option value="" selected> Select </option>
						<?php
							$sleavestype = "SELECT annualleave,maternityleave,paternityleave,compassionateleave,absence, sickleave, unpaidleave, studyleave FROM master_employee WHERE employeecode = '$employeecode' ";
							$sleaveexec = mysqli_query($GLOBALS["___mysqli_ston"], $sleavestype);
							$sleaveres = mysqli_fetch_array($sleaveexec);
								$sleaveres1 = $sleaveres['annualleave'];
								$sleaveres2 = $sleaveres['maternityleave'];
								$sleaveres3 = $sleaveres['paternityleave'];
								$sleaveres4 = $sleaveres['compassionateleave'];
								$sleaveres5 = $sleaveres['absence'];
								$sleaveres6 = $sleaveres['sickleave'];
								$sleaveres7 = $sleaveres['unpaidleave'];
								$sleaveres8 = $sleaveres['studyleave'];

							?>
							<option value="<?= $sleaveres1.'|'.'Annual Leave'; ?>" > Annual Leave </option>
                            <?php if($gender == 'female' || $global !== ""){?>
							<option value="<?= $sleaveres2.'|'.'Maternity Leave'; ?>" > Maternity Leave </option>
                            <?php } if($gender == 'male' || $global !== ""){?>
							<option value="<?= $sleaveres3.'|'.'Paternity Leave'; ?>" > Paternity Leave </option>
                            <?php } ?>
							<option value="<?= $sleaveres4.'|'.'Compassionate Leave'; ?>" > Compassionate Leave </option>
							<option value="<?= $sleaveres5.'|'.'Absence'; ?>" > Absence</option>
							<option value="<?= $sleaveres6.'|'.'Sick Leave'; ?>" > Sick Leave </option>
							<option value="<?= $sleaveres7.'|'.'Unpaid Leave'; ?>" > Unpaid Leave </option>
							<option value="<?= $sleaveres8.'|'.'Study Leave'; ?>" > Study Leave </option>
							
							
						</select>
						
					</td>
				</tr>
				
				
				<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">From Date </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="fromdate" id="fromdate" value="<?= date('Y-m-d');?>" style="border: 1px solid #001E6A;" size="10" readonly onChange="return DateCalc()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('fromdate')" style="cursor:pointer"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">To Date </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="todate" id="todate" value="" style="border: 1px solid #001E6A;" size="10" readonly onChange="return DateCalc()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('todate')" style="cursor:pointer"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Total Days </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="totaldays" id="totaldays" value="" style="border: 1px solid #001E6A;" size="10" readonly /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Leave Remarks</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<textarea name="remarks" id="remarks" rows="3" cols="40" style="border: 1px solid #001E6A;"></textarea></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Supervisor</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="supervisor" id="supervisor" style="border: 1px solid #001E6A;" size="40" value="<?php echo $supervisorname; ?>" />
                        <input type="hidden" name="supervisorcode" id="supervisorcode" style="border: 1px solid #001E6A;" size="40" value="<?php echo $supervisorcode; ?>"/></td>
                      </tr>
                      <tr>
                        <td width="25%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="75%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	</td>
	</tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

