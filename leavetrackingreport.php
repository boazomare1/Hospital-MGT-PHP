<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchjob"])) { $searchjob = $_REQUEST["searchjob"]; } else { $searchjob = ""; }
if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
if (isset($_REQUEST["employeetype"])) { $employeetype = $_REQUEST["employeetype"]; } else { $employeetype = ""; }
if (isset($_REQUEST["lastatus"])) { $lastatus = $_REQUEST["lastatus"]; } else { $lastatus = ""; }


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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />        

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
$('#searchemployee').autocomplete({
	source:'autoemployeesearch.php?requestfrm=searchemployee&', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#searchemployeecode').val(code);
			},
	html: true
    });
});
</script>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<!--<script type="text/javascript" src="js/autoemployeecodesearch6.js"></script> -->
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">



<script language="javascript">

function captureEscapeKey1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		//alert ("Escape Key Press.");
		//event.keyCode=0; 
		//return event.keyCode 
		//return false;
	}
}

</script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{
	if(document.getElementById("updatestatus").value == "")
	{
		alert("Select Status");
		document.getElementById("updatestatus").focus();
		return false;
	}
}

</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<form name="form1" id="form1" method="post" action="leavetrackingreport.php">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search  Employee Leave Tracking Report</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input name="searchemployee" id="searchemployee" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
	<input type="hidden" name="searchemployeecode" id="searchemployeecode" ></td>
	</tr>
	
	
	 <tr>
			  <td align="left" class="bodytext3">Employee Type</td>
			  <td align="left" class="bodytext3"><select name="employeetype" id="employeetype" style="border:solid 1px #001E6A;" onChange="return fncemptype()">
			     <?php 
			if($employeetype != '') { ?>
			<option value = "<?php echo $employeetype;?>"><?php echo $employeetype; ?></option>
			<?php } ?>	
			 <option value="">Select</option>
			  <?php
			  $query7 = "select * from master_employeetype where recordstatus <> 'deleted' order by employeetype";
			  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res7 = mysqli_fetch_array($exec7))
			  {
			  $employee_type = $res7['employeetype'];
			  ?>
			  <option value="<?php echo $employee_type; ?>"><?php echo $employee_type; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  
			  </tr>
	<tr>
	  <td align="left" class="bodytext3">Job Group</td>
			  <td align="left" class="bodytext3"><select name="searchjob" id="searchjob" style="border:solid 1px #001E6A;" >
			  <option value="">Select</option>
			  <?php
			  $query7 = "select * from master_employeegroup where recordstatus <> 'deleted' order by employeegroup";
			  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res7 = mysqli_fetch_array($exec7))
			  {
			  $employeegroup = $res7['employeegroup'];
			  ?>
			  <option value="<?php echo $employeegroup; ?>"><?php echo $employeegroup; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
	<td width="74" align="left" class="bodytext3">&nbsp;</td>
	</tr>
		<tr>
	   <td align="left" class="bodytext3">Department</td>
			  <td align="left" class="bodytext3"><select name="department" id="department" style="border:solid 1px #001E6A;" onChange="return DeptUnitBuild()">
			  <option value="">Select</option>
			  <?php
			  $query5 = "select * from master_payrolldepartment where recordstatus <> 'deleted' group by department order by department";
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res5 = mysqli_fetch_array($exec5))
			  {
			  $departmentanum = $res5['auto_number'];
			  $departmentname = $res5['department'];
			  ?>
			  <option value="<?php echo $departmentname; ?>"><?php echo $departmentname; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
	<td width="74" align="left" class="bodytext3">&nbsp;</td>
	</tr>
	
	
		<tr>
	  <td align="left" class="bodytext3">Leave Approval Status</td>
			  <td align="left" class="bodytext3"><select name="lastatus" id="lastatus" style="border:solid 1px #001E6A;" >
			 
			  <option value="approved">Approved</option>
			  <option value="rejected">Rejected</option>

			  </select></td>
	<td width="74" align="left" class="bodytext3">&nbsp;</td>
	</tr>
	
	<tr>
	<td width="56" align="left" class="bodytext3">&nbsp;</td>
	<td width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Search" style="border:solid 1px #001E6A;"></td>
	<td width="74" align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
	</td>
	</tbody>
	</table>
	</form>
	</td>
	</tr>
	<tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
<?php
	
	
	if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

	
	if ($frmflag1 == 'frmflag1')
{
	
	
	?>
	<table  border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Employees Leave Tracking Report</strong></td>
	</tr>
	<tr>
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
	<td width="105" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE CODE</strong></td>
	<td width="217" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Payroll No</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Gender</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Date of Birth</strong></td>

	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Department</strong></td>
	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Dept Unit</strong></td>
	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Job Group</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Leaves Type</strong></td>
	
	<td width="250" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Leave Start Date</strong></td>
	<td width="250" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Leave End Date</strong></td>
	<td width="250" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Requested By</strong></td>
	<td width="250" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Head of Department</strong></td>
	<td width="250" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Human Resource</strong></td>
	<td width="250" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Approval Status</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$total_days=0;
	$query2 = "select * from master_employee where employeename like '%$searchemployee%' order by employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res46 = mysqli_fetch_array($exec2))
	{
	$anum = $res46['auto_number'];
	$res2employeecode = $res46['employeecode'];
	$res2employeename = $res46['employeename'];
	$res2status = $res46['payrollstatus'];
	$doj = $res46['dateofjoining'];
	$employmenttype = $res46['employmenttype'];
	$departmentanum = $res46['departmentanum'];
	$category = $res46['category'];
	$designation = $res46['designation'];
	$supervisor = $res46['supervisor'];
	$firstjob = $res46['firstjob']; 
	$overtime = $res46['overtime']; 
	$user = $res46['is_user']; 
	$prorata = $res46['prorata'];
	$hold = $res46['hold'];
	$doh = $res46['dateofholding'];
	$status = $res46['status'];
	$job_title = $res46['job_title'];
		 $allowed_leave_days=$res46['allowed_leavedays']; 

	
	 $query45 ="select * from master_employeeinfo where employeecode = '$res2employeecode' and employee_type ='$employeetype' and job_group like '%$searchjob%' and departmentname like '%$department%' group by employeecode";
	$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res45 = mysqli_fetch_array($exec45);
		$res22 = mysqli_num_rows($exec45);
	if($res22 > 0)
	{
	$photo=$res45['photo'];
	$employeecode = $res45['employeecode'];
	$employeename = $res45['employeename'];
	$fathername = $res45['fathername'];
	$nationality = $res45['nationality'];
	$gender = $res45['gender'];
	$dob = $res45['dateofbirth'];
	$maritalstatus = $res45['maritalstatus'];
	$religion = $res45['religion'];
	$bloodgroup = $res45['bloodgroup'];
	$height = $res45['height'];
	$weight = $res45['weight'];
	$address = $res45['address'];
	$city = $res45['city'];
	$state = $res45['state'];
	$phone = $res45['phone'];
	$mobile = $res45['mobile'];
	$email = $res45['email'];
	$university = $res45['university'];
	$univregno = $res45['univregno'];
	$disabledperson = $res45['disabledperson'];
	$nextofkin = $res45['nextofkin'];
	$pinno = $res45['pinno'];
	$spouseemail = $res45['spouseemail'];
	$spousemob = $res45['spousemob'];
	$spousename = $res45['spousename'];
	$kinemail = $res45['kinemail'];
	$kinmob = $res45['kinmob'];
	$hosp = $res45['hosp'];
	$nssf = $res45['nssf'];
	$nhif = $res45['nhif'];
	$passportnumber = $res45['passportnumber'];
	$passportcountry = $res45['passportcountry'];
	$sacconumber = $res45['sacconumber'];
	$costcenter = $res45['costcenter'];
	$bankname = $res45['bankname'];
	$bankbranch = $res45['bankbranch'];
	$accountnumber = $res45['accountnumber'];
	$bankcode = $res45['bankcode'];
	$insurancename = $res45['insurancename'];
	$insurancecity = $res45['insurancecity'];
	$policytype = $res45['policytype'];
	$policynumber = $res45['policynumber'];
	$policyfrom = $res45['policyfrom'];
	$policyto = $res45['policyto'];
	$qualificationbasic = $res45['qualificationbasic'];
	$qualificationadditional = $res45['qualificationadditional'];
	$employername = $res45['employername'];
	$employeraddress = $res45['employeraddress'];
	$promotiondue = $res45['promotiondue'];
	$incrementdue = $res45['incrementdue'];
	$freetravel = $res45['freetravel'];
	$companycar = $res45['companycar']; 
	$vehicleno = $res45['vehicleno'];
	$dol = $res45['dateofleaving'];
	$blacklisted = $res45['blacklisted'];
	$reasonforleaving = $res45['reasonforleaving'];
	$lastjobforexpatriate = $res45['lastjobforexpatriate'];
	$departmentname = $res45['departmentname'];
	$payrollno = $res45['payrollno'];
	$deptunit = $res45['departmentunit'];
	
	 $appraisal_date=$res45['appraisal_date']; 
	 $end_date=$res45['end_date']; 
	 $from_date=$res45['from_date']; 
	 $employeestart_date=$res45['employeestart_date']; 
	 $employment_status=$res45['employment_status']; 
	 $employee_type=$res45['employee_type']; 
	 $job_group=$res45['job_group']; 
	 $retirement_date=$res45['retirement_date']; 

	 
	    $query51 = "select * from leave_request where employeecode='$res2employeecode' and approvalstatus = '$lastatus'   ";
			  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res51 = mysqli_fetch_array($exec51))
			{

			$from_date = $res51['from_date'];
			$to_date = $res51['to_date'];
			
			$leavestypearr1 = $res51['leavestype'];
			$supervisor = $res51['username'];
			$updatedatetime = $res51['updatedatetime'];
			
			$approvalstatus = $res51['approvalstatus'];
			$hodusername = $res51['hodusername'];
			$hodupdatedatetime = $res51['hodupdatedatetime'];
			$hrusername = $res51['hrusername'];
			$hrupdatedatetime = $res51['hrupdatedatetime'];
			
			if($supervisor == ''){$updatedatetime = '';} else{
				$query12 = "select employeename from master_employee where username = '$supervisor'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res146 = mysqli_fetch_array($exec12))
				{
				$supervisor = $res146['employeename'];
				}				
			}
			
			if($hodusername == ''){$hodupdatedatetime = '';} else{
				$query12 = "select employeename from master_employee where username = '$hodusername'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res146 = mysqli_fetch_array($exec12))
				{
				$hodusername = $res146['employeename'];
				}				
			}
			
			if($hrusername == ''){$hrupdatedatetime = '';} else{
				$query12 = "select employeename from master_employee where username = '$hrusername'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res146 = mysqli_fetch_array($exec12))
				{
				$hrusername = $res146['employeename'];
				}
			}
			
			if($leavestypearr1 !=''){
				$leavestypearr = explode('|',$leavestypearr1);
				$leavestypeval = $leavestypearr[0];
				$leavestype = $leavestypearr[1];
				
			}else{
				$leavestypeval = '';
				$leavestype = '';
			}
			
	 
	 
	 
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#CBDBFA"';
	}
	else

	{
		$colorcode = 'bgcolor="#ecf0f5"';
	}
	  
	?>
	<tr <?php echo $colorcode; ?>>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left"   class="bodytext3"><?php echo $res2employeecode; ?></td>
	<td align="left"   class="bodytext3"><?php echo $res2employeename; ?></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $payrollno; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $gender; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $dob; ?></strong></td>

	<td  align="left"  class="bodytext3"><strong><?php echo $departmentname; ?></strong></td>
	
	<td  align="left"  class="bodytext3"><strong><?php echo $deptunit; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $job_group; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $leavestype; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $from_date; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $to_date; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $supervisor.'<br/><small>'.$updatedatetime.'</small>'; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $hodusername.'<br/><small>'.$hodupdatedatetime.'</small>'; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $hrusername.'<br/><small>'.$hrupdatedatetime.'</small>'; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $approvalstatus; ?></strong></td>

	</tr>
	<?php
	}
	}
	}
	?>
	
	</tbody>
	</table> 
	<?php
	
}
	
	?>	
	</td>
  	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

