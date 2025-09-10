<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d');

$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchjob"])) { $searchjob = $_REQUEST["searchjob"]; } else { $searchjob = ""; }
if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
if (isset($_REQUEST["employeetype"])) { $employeetype = $_REQUEST["employeetype"]; } else { $employeetype = ""; }


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="yearsofservicereport.xls"');
header('Cache-Control: max-age=80');


function get_time($g_datetime){
$from=date_create(date('Y-m-d H:i:s',strtotime($g_datetime)));
$to=date_create(date('Y-m-d H:i:s'));
$diff=date_diff($to,$from);
//print_r($diff);
$y = $diff->y > 0 ? $diff->y.' Years <br>' : '';
$m = $diff->m > 0 ? $diff->m.' Months <br>' : '';
$d = $diff->d > 0 ? $diff->d.' Days <br>' : '';
$h = $diff->h > 0 ? $diff->h.' Hrs <br>' : '';
$mm = $diff->i > 0 ? $diff->i.' Mins <br>' : '';
$ss = $diff->s > 0 ? $diff->s.' Secs <br>' : '';

echo $y.' '.$m.' '.$d.' '.$h.' '.$mm.' '.$ss.' ';
}

?>


	<?php
	
	
	if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

	
	if ($frmflag1 == 'frmflag1')
{
	
	
	?>
	<table width="1294"  border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#ffffff">
	<td colspan="36" align="left" class="bodytext3"><strong>Employees Years of Service Report</strong></td>
	</tr>
	<tr>
	<td width="24" align="center" bgcolor="#ffffff" class="bodytext3"><strong>S.No</strong></td>
	<td width="104" align="left" bgcolor="#ffffff" class="bodytext3"><strong>Payroll No</strong></td>
	<td width="194" align="left" bgcolor="#ffffff" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	
	<td width="136" align="left" bgcolor="#ffffff" class="bodytext3"><strong>Department</strong></td>
	
		<td width="136" align="left" bgcolor="#ffffff" class="bodytext3"><strong>Designation</strong></td>
	<td width="136" align="left" bgcolor="#ffffff" class="bodytext3"><strong>Age</strong></td>

	<td width="113" align="left" bgcolor="#ffffff" class="bodytext3"><strong>Date of Hire</strong></td>
	<td width="120" align="left" bgcolor="#ffffff" class="bodytext3"><strong>Date of Termination</strong></td>
	
	<td width="96" align="left" bgcolor="#ffffff" class="bodytext3"><strong>Year of Service</strong></td>



	</tr>
	<?php
	$totalamount = '0.00';
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
	
	
	 $query45 ="select * from master_employeeinfo where employeecode = '$res2employeecode' and departmentname like '%$department%' group by employeecode";
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
	$todate = date("Y-m-d");
	$diff = abs(strtotime($todate) - strtotime($dob));
	
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	if($years == 0 && $months == 0)
	{
	$age = $days.' '.'Days';
	}
	if($years == 0 && $months != 0)
	{
	$age = $months.' '.'Months';
	}
	else 
	{
	$age = $years.' '.'Years';
	}
	
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
	
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#ffffff"';
	}
	else

	{
		$colorcode = 'bgcolor="#ffffff"';
	}
	
$date_1 = new DateTime( $doj );

if($dol=='0000-00-00'){
$dol1=$updatedate;	
$dol='';
}
else{
	$dol1=$dol;	

}

	$todate = date("Y-m-d");
	$diff = abs(strtotime($dol1) - strtotime($doj));
	
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	if($years == 0 && $months == 0)
	{
	$serv = $days.' '.'Days';
	}
	if($years == 0 && $months != 0)
	{
	$serv = $months.' '.'Months';
	}
	else 
	{
	$serv = $years.' '.'Years';
	}
	//$diff=calculate_age($dol1,$doj); 

	?>
	<tr <?php echo $colorcode; ?>>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left"   class="bodytext3"><strong><?php echo $payrollno; ?></strong></td>
	<td align="left"   class="bodytext3"><?php echo $res2employeename; ?></td>

	<td  align="left"  class="bodytext3"><strong><?php echo $departmentname; ?></strong></td>
		<td  align="left"  class="bodytext3"><strong><?php echo $designation; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $age; ?></strong></td>
	
	<td  align="left"  class="bodytext3"><strong><?php echo $doj; ?></strong></td>	
	<td  align="left"  class="bodytext3"><strong><?php  echo $dol;  ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $serv; ?></strong></td>

	
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
	

