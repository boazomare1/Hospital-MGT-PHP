<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$colorloopcount = '';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="EmployeeDetailsReport.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchjob"])) { $searchjob = $_REQUEST["searchjob"]; } else { $searchjob = ""; }
if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
if (isset($_REQUEST["employeetype"])) { $employeetype = $_REQUEST["employeetype"]; } else { $employeetype = ""; }
if (isset($_REQUEST["departmentunit"])) { $departmentunit = $_REQUEST["departmentunit"]; } else { $departmentunit = ""; }
if (isset($_REQUEST["employmentstatus"])) { $employmentstatus = $_REQUEST["employmentstatus"]; } else { $employmentstatus = ""; }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.num {
  mso-number-format:General;
}
.text{
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma;
  mso-number-format:"\@";/*force text*/
}
-->
</style>

	<?php
	$totalamount = '0.00';
	if($frmflag1 == 'frmflag1')
	{	
	    
	?>
	<table  border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="14" align="left" class="bodytext3"><strong>Employees Details Report</strong></td>
    
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
	<tr>
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
	?>	
