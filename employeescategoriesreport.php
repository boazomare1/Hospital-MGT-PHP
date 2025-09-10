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
if (isset($_REQUEST["departmentunit"])) { $departmentunit = $_REQUEST["departmentunit"]; } else { $departmentunit = ""; }
if (isset($_REQUEST["employmentstatus"])) { $employmentstatus = $_REQUEST["employmentstatus"]; } else { $employmentstatus = ""; }
if (isset($_REQUEST["statusdate"])) { $statusdate = $_REQUEST["statusdate"]; } else { $statusdate = date("Y-m-d"); }

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
	<form name="form1" id="form1" method="post" action="employeescategoriesreport.php">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search  Employees categories Report</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input name="searchemployee" id="searchemployee" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
						<input type="hidden" name="searchemployeecode" id="searchemployeecode" ></td>
	</tr>
	
	
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
	   <td align="left" class="bodytext3">Department Units</td>
			  <td align="left" class="bodytext3"><select name="departmentunit" id="departmentunit" style="border:solid 1px #001E6A;">
			  <option value="">Select</option>
			  </select></td>
	<td width="74" align="left" class="bodytext3">&nbsp;</td>
	</tr>
    <tr>
		<td width="100" align="left" valign="center"  class="bodytext31"><strong> Status Date </strong>
        </td>
        <td width="137" align="left" valign="center"  class="bodytext31">
        <input name="statusdate" id="statusdate" value="<?php echo $statusdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
        <img src="images2/cal.gif" onClick="javascript:NewCssCal('statusdate')" style="cursor:pointer"/>			
        </td>    
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
	<td colspan="13" align="left" class="bodytext3"><strong>Employees Details Report</strong></td>
	<td><a href="print_employeesreportexl.php?searchemployee=<?php echo $searchemployee; ?>&searchjob=<?php echo $searchjob; ?>&department=<?php echo $department; ?>&departmentunit=<?php echo $departmentunit; ?>&employmentstatus=<?php echo $employmentstatus; ?>&frmflag1=<?php echo $frmflag1; ?>"><img src="images/excel-xls-icon.png" height="40" width="40"></a></td>
    
	</tr>
	<tr>
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
	<td width="105" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE PIN</strong></td>
	<td width="217" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Payroll No</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>ID No</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>NSSF No</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>NHIF No</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank Branch</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank Account</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Gender</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Date of Birth</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Marital Status</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Blood Group</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Email</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Mobile</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Employment Type</strong></td>	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Department</strong></td>	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Department Unit</strong></td>	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Job Title</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Date of Employment</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Next of Kin</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Next of Kin Mobile</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query2 = "select * from master_employee where employeename like '%$searchemployee%' AND employeecode IN (select employeecode from payroll_assign) order by employeecode";
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
	
	if ( $statusdate < $doj&& $doj!='0000-00-00'){continue; }
	if ( $statusdate > $doh&& $doh!='0000-00-00'){continue; }
	//if ( $status !=''){continue; }
	$query45 ="select * from master_employeeinfo where employeecode = '$res2employeecode' and departmentname like '%$department%' and departmentunit like '%$departmentunit%' group by employeecode";
	$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res45 = mysqli_fetch_array($exec45);
		$res22 = mysqli_num_rows($exec45);
	if($res22 > 0)
	{
	$photo=$res45['photo'];
	$employeecode = $res45['employeecode'];
	$pinno = $res45['pinno'];
	
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
		 
	if ( $statusdate > $dol && $dol!='0000-00-00'){continue; }

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
	<td align="left"   class="bodytext3"><?php echo $pinno; ?></td>
	<td align="left"   class="bodytext3"><?php echo $res2employeename; ?></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $payrollno; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $passportnumber; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $nssf; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $nhif; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $bankname; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $bankbranch; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $accountnumber; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $gender; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $dob; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $maritalstatus; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $bloodgroup; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $email; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $mobile; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $employmenttype; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $departmentname; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $deptunit; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $job_title; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $doj; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $nextofkin; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $kinmob; ?></strong></td>
	</tr>
	<?php
	}
	}
	?>
	
	</tbody>
	</table> 
<?php
	
}
	
	?>		</td>
  	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
<script type="text/javascript">
function DeptUnitBuild()
{
	<?php
	$query4 = "select auto_number, department from master_payrolldepartment where recordstatus <> 'deleted'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res4 = mysqli_fetch_array($exec4))
	{
	
	$res4anum = $res4['auto_number'];
	$res4dept = $res4['department'];
	?>
		if(document.getElementById("department").value == "<?php echo $res4dept; ?>")
		{
		//alert(document.getElementById("department").value);
		document.getElementById("departmentunit").options.length=null; 
		var combo = document.getElementById('departmentunit'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select", ""); 
		<?php
		$query10 = "select unit from master_payrolldepartment where department = '$res4dept' and recordstatus <> 'deleted'";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		//if($loopcount == 1) {$loopcount = 0; }
		$loopcount = $loopcount+1;
		$res10unit = $res10["unit"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10unit;?>", "<?php echo $res10unit;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
}

</script>
</body>
</html>

