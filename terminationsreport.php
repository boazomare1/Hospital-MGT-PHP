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

if (isset($_REQUEST["aprdate"])) { $aprdate = $_REQUEST["aprdate"]; } else { $aprdate = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $updatedate; }
if (isset($_REQUEST["status"])) { $status = $_REQUEST["status"]; } else { $status = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $updatedate; }

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
	<form name="form1" id="form1" method="post" action="terminationsreport.php">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search Employee Terminations Report</strong></td>
	</tr>
	
			 <tr>
								<td width="100" align="left" valign="center"  class="bodytext31"><strong> Date From </strong>
								</td>
								<td width="137" align="left" valign="center"  class="bodytext31">
								<input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
								<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			
								</td>
								<td width="68" align="left" valign="center"   class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
								<td width="263" align="left" valign="center"  ><span class="bodytext31">
								<input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
								<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
								</span></td>
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
	<td colspan="58" align="left" class="bodytext3"><strong>Terminations Report</strong></td>
	</tr>
	<tr>
	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
	<td width="105" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE CODE</strong></td>
	<td width="217" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Payroll No</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Father Name</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Nationality</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Gender</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Date of Birth</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Marital Status</strong></td>
    <td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Religion</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Blood Group</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Height</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Weight</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>City</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>State</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Landline</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Email</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Mobile</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>University Name</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>University Reg No</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Is Disabled Employee?</strong></td>
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Retirement Age</strong></td>	
	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Department</strong></td>
	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Dept Unit</strong></td>
	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Job Group</strong></td>
	
	<td width="67" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>STATUS</strong></td>



	</tr>
	
		
	
	<?php
	
	$totalamount = '0.00';
	
   
   
 


	$query2 = "select * from master_employee    order by employeecode";
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
	$empstatus = $res46['status'];
	$job_title = $res46['job_title'];
	
	
	
	  $query45 ="select * from master_employeeinfo where employeecode = '$res2employeecode'";

	  if($status=='Terminated'){
		   $query45= $query45."and (dateofleaving <> '0000-00-00')  and dateofleaving between '$ADate1' and '$ADate2'   group by employeecode";

	}
	else{
	   $query45= $query45."and dateofleaving between '$ADate1' and '$ADate2'    group by employeecode";
	}
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
	 $allowed_leave_days=$res45['allowed_leavedays']; 
	 $retirement_date=$res45['retirement_date']; 

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
	<td  align="left"  class="bodytext3"><strong><?php echo $fathername; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $nationality; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $gender; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $dob; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $maritalstatus; ?></strong></td>
    <td  align="left"  class="bodytext3"><strong><?php echo $religion; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $bloodgroup; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $height; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $weight; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $address; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $city; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $state; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $phone; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $email; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $mobile; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $university; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $univregno; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $disabledperson; ?></strong></td>
	<td  align="left"  class="bodytext3"><strong><?php echo $retirement_date; ?></strong></td>	
	
	<td  align="left"  class="bodytext3"><strong><?php echo $departmentname; ?></strong></td>
	
	<td  align="left"  class="bodytext3"><strong><?php echo $deptunit; ?></strong></td>
	
	<td  align="left"  class="bodytext3"><strong><?php echo $job_group; ?></strong></td>
	
	<td align="left"   class="bodytext3"><?php echo $status; ?></td>	
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
	</td>
  	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

