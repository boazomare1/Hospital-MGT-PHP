<?php
session_start();  
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$query03 = "select * from login_locationdetails where docno = '".$docno."' and username = '$username' order by locationname";
$exec03 = mysqli_query($GLOBALS["___mysqli_ston"], $query03) or die ("Error in Query03".mysqli_error($GLOBALS["___mysqli_ston"]));
$res03 = mysqli_fetch_array($exec03);
 $locationcode03 = $res03['locationcode'];
 $locationname03=$res03['locationname'];

$employeecode = '';
	$employeename = '';
	$fathername = '';
	$nationality = '';
	$gender = '';
	$dob = '';
	$maritalstatus = '';
	$religion = '';
	$bloodgroup = '';
	$height = '';
	$weight = '';
	$address = '';
	$city = '';
	$state = '';
	$phone = '';
	$mobile = '';
	$email = '';
	$university = '';
	$univregno = '';
	$disabledperson = '';
	$nextofkin = '';
	$kinemail = '';
	$kinmob = '';
	$pinno = '';
	$spouseemail = '';
	$spousemob = '';
	$spousename = '';
	
	$hosp = '';
	$nssf = '';
	$nhif = '';
	$passportnumber = '';
	$passportcountry = '';
	$sacconumber = '';
	$costcenter = '';
	$bankname = '';
	$bankbranch = '';
	$accountnumber = '';
	$bankcode = '';
	$insurancename = '';
	$insurancecity = '';
	$policytype = '';
	$policynumber = '';
	$policyfrom = '';
	$policyto = '';
	$qualificationbasic = '';
	$qualificationadditional = '';
	$employername = '';
	$employeraddress = '';
	$promotiondue = '';
	$incrementdue = '';
	$freetravel = '';
	$companycar = '';
	$vehicleno = '';
	$dol = '';
	$blacklisted = '';
	$reasonforleaving = '';
	$lastjobforexpatriate = '';
	$doj = '';
	$employmenttype = '';
	$departmentanum = '';
	$departmentname = '';
	$category = '';
	$designation = '';
	$supervisor = '';
	$firstjob = '';
	$overtime = '';
	$user = '';
	$prorata = '';
	$hold = '';
	$doh = '';
	$status = '';
	
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["frmflag12"])) { $frmflag12 = $_REQUEST["frmflag12"]; } else { $frmflag12 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if ($frmflag1 == 'frmflag1')
{
	$employeecode = $_REQUEST['employeecode'];
	$employeename = $_REQUEST['employeename'];
	$employeename = strtoupper($employeename);
	$fathername = $_REQUEST['fathername'];
	$nationality = $_REQUEST['nationality'];
	$gender = $_REQUEST['gender'];
	$dob = $_REQUEST['dob'];
	$maritalstatus = $_REQUEST['maritalstatus'];
	$religion = $_REQUEST['religion'];
	$bloodgroup = $_REQUEST['bloodgroup'];
	$height = $_REQUEST['height'];
	$weight = $_REQUEST['weight'];
	$address = $_REQUEST['address'];
	$city = $_REQUEST['city'];
	$state = $_REQUEST['state'];
	$phone = $_REQUEST['phone'];
	$mobile = $_REQUEST['mobile'];
	$email = $_REQUEST['email'];
	$university = $_REQUEST['university'];
	$univregno = $_REQUEST['univregno'];
	if(isset($_REQUEST['disabledperson'])) { $disabledperson = $_REQUEST['disabledperson']; } else { $disabledperson = 'No'; }
	$doj = $_REQUEST['doj'];
	$employmenttype = $_REQUEST['employmenttype'];
	$department = $_REQUEST['department'];
	//$departmentsplit = explode('||',$department);
	$departmentanum = 0;
	$departmentname = $department;
	$category = $_REQUEST['category'];
	$designation = $_REQUEST['designation'];
	$supervisor = $_REQUEST['supervisor'];
	if(isset($_REQUEST['firstjob'])) { $firstjob = $_REQUEST['firstjob']; } else { $firstjob = 'No'; }
	if(isset($_REQUEST['overtime'])) { $overtime = $_REQUEST['overtime']; } else { $overtime = 'No'; }
	if(isset($_REQUEST['user'])) { $user = $_REQUEST['user']; } else { $user = 'No'; }
	if(isset($_REQUEST['prorata'])) { $prorata = $_REQUEST['prorata']; } else { $prorata = 'No'; }
	$nextofkin = $_REQUEST['nextofkin'];
	$pinno = $_REQUEST['pinno'];
	$spouseemail = $_REQUEST['spouseemail'];
	$spousemob = $_REQUEST['spousemob'];
	$spousename = $_REQUEST['spousename'];
	$kinemail = $_REQUEST['kinemail'];
	$kinmob = $_REQUEST['kinmob'];
	$hosp = $_REQUEST['hosp'];
	$nssf = $_REQUEST['nssf'];
	$nhif = $_REQUEST['nhif'];
	$passportnumber = $_REQUEST['passportnumber'];
	$passportcountry = $_REQUEST['passportcountry'];
	$sacconumber = $_REQUEST['sacconumber'];
	$costcenter = $_REQUEST['costcenter'];
	$bankname = $_REQUEST['bankname'];
	$bankbranch = $_REQUEST['bankbranch'];
	$accountnumber = $_REQUEST['accountnumber'];
	$bankcode = $_REQUEST['bankcode'];
	$insurancename = $_REQUEST['insurancename'];
	$insurancecity = $_REQUEST['insurancecity'];
	$policytype = $_REQUEST['policytype'];
	$policynumber = $_REQUEST['policynumber'];
	$policyfrom = $_REQUEST['policyfrom'];
	$policyto = $_REQUEST['policyto'];
	$qualificationbasic = $_REQUEST['qualificationbasic'];
	$qualificationadditional = $_REQUEST['qualificationadditional'];
	$employername = $_REQUEST['employername'];
	$employeraddress = $_REQUEST['employeraddress'];
	$promotiondue = $_REQUEST['promotiondue'];
	$incrementdue = $_REQUEST['incrementdue'];
	$locationcode=$_REQUEST['locationcode03'];
	 $locationname=$_REQUEST['locationname03']; 
	if(isset($_REQUEST['freetravel'])) { $freetravel = $_REQUEST['freetravel']; } else { $freetravel = 'No'; }
	if(isset($_REQUEST['companycar'])) { $companycar = $_REQUEST['companycar']; } else { $companycar = 'No'; }
	$vehicleno = $_REQUEST['vehicleno'];
	$dol = $_REQUEST['dol'];
	if(isset($_REQUEST['blacklisted'])) { $blacklisted = $_REQUEST['blacklisted']; } else { $blacklisted = 'No'; }
	$reasonforleaving = $_REQUEST['reasonforleaving'];
	$doh = $_REQUEST['doh'];
	if(isset($_REQUEST['lastjobforexpatriate'])) { $lastjobforexpatriate = $_REQUEST['lastjobforexpatriate']; } else { $lastjobforexpatriate = 'No'; }
	if(isset($_REQUEST['hold'])) { $hold = $_REQUEST['hold']; } else { $hold = 'No'; }
	$status = $_REQUEST['status'];
	if($prorata == 'Yes'){ $payrollstatus = 'Prorata'; } else { $payrollstatus = $status; }
	$payrollno = $_REQUEST['payrollno'];
	$deptunit = $_REQUEST['deptunit'];
	$job_title = $_REQUEST['job_title'];
	
	$target_file =$_FILES["employeeimg"]["name"];
	$dsc_file =$_FILES["digitalsignature"]["name"];

	$target_dir = "employeephoto/";
	$dsc_dir = "digitalsignatures/";

 	$uploadOk = 1;

 	$dscuploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$target_file = $target_dir . $employeecode.".jpg";
   $check = getimagesize($_FILES["employeeimg"]["tmp_name"]);
	
	$dsc_file = $dsc_dir . $employeecode."DSC.jpg";
	$dsccheck = getimagesize($_FILES["digitalsignature"]["tmp_name"]);

	$query10 = "select * from master_employee where employeecode = '$employeecode'";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res10 = mysqli_fetch_array($exec10);
	$res10employeecode = $res10['employeecode'];
	if($res10employeecode != '')
	{	
		 $query11 = "update master_employee set employeename = '$employeename', dateofjoining = '$doj', firstjob = '$firstjob', overtime = '$overtime', is_user = '$user', prorata = '$prorata', hold = '$hold', dateofholding = '$doh', employmenttype = '$employmenttype', departmentanum = '$departmentanum', departmentname = '$departmentname', category = '$category', designation = '$designation', supervisor = '$supervisor', status = '$status', payrollstatus = '$payrollstatus', lastupdateusername = '$username', lastupdateipaddress = '$ipaddress', lastupdate = '$updatedatetime',locationname='$locationname',locationcode='$locationcode',job_title='$job_title' where employeecode = '$employeecode'"; 
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
				 if($check !== false) {
				 if (move_uploaded_file($_FILES["employeeimg"]["tmp_name"], $target_file))
					  { $uploadOk = 1; } 
					else 
					{ $uploadOk = 0;	}
					  
					}
			 	else { $uploadOk = 0;	}

			 	if($dsccheck !== false) 
			 	{
					 if (move_uploaded_file($_FILES["digitalsignature"]["tmp_name"], $dsc_file))
					 { 
						$dscuploadOk = 1; 
					 } 
					 else 
					 { 
						$dscuploadOk = 0;	
					 }
					  
				}
			 	else 
			 	{ 
			 		$dscuploadOk = 0;	
			 	}
				
	 	$query12 = "update master_employeeinfo set employeename = '$employeename', fathername = '$fathername', nationality = '$nationality', gender = '$gender', dateofbirth = '$dob', maritalstatus = '$maritalstatus', religion = '$religion', bloodgroup = '$bloodgroup', height = '$height', weight = '$weight', address = '$address', city = '$city', state = '$state', phone = '$phone', mobile = '$mobile', email = '$email', university = '$university', univregno = '$univregno', disabledperson = '$disabledperson', nextofkin = '$nextofkin', pinno = '$pinno', spouseemail = '$spouseemail', spousemob = '$spousemob', kinemail = '$kinemail', kinmob = '$kinmob', spousename = '$spousename', hosp = '$hosp', nssf = '$nssf', nhif = '$nhif', passportnumber = '$passportnumber', passportcountry = '$passportcountry', sacconumber = '$sacconumber', costcenter = '$costcenter', bankname = '$bankname', 
		bankbranch = '$bankbranch', accountnumber = '$accountnumber', bankcode = '$bankcode', insurancename = '$insurancename', insurancecity = '$insurancecity', policytype = '$policytype', policynumber = '$policynumber', policyfrom = '$policyfrom', policyto = '$policyto', qualificationbasic = '$qualificationbasic', qualificationadditional = '$qualificationadditional', employername = '$employername', employeraddress = '$employeraddress', promotiondue = '$promotiondue', incrementdue = '$incrementdue', freetravel = '$freetravel', companycar = '$companycar', vehicleno = '$vehicleno', dateofleaving = '$dol', blacklisted = '$blacklisted', reasonforleaving = '$reasonforleaving', lastjobforexpatriate = '$lastjobforexpatriate', status = '$status', username = '$username', ipaddress = '$ipaddress', updatedatetime = '$updatedatetime',
		photo='$uploadOk',locationname='$locationname',locationcode='$locationcode',payrollno = '$payrollno',departmentunit = '$deptunit',departmentname = '$departmentname', dscphoto='$dscuploadOk' where employeecode = '$employeecode'"; 
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		header("location:editemployeeinfo1.php?st=success");
	}
	else
	{
		header("location:editemployeeinfo1.php?st=failed");
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
	$errmsg = "Success. New Employee Updated.";
}
else if ($st == 'failed')
{
	$errmsg = "Failed. Employee Not Updated.";
}

if($frmflag12 == 'frmflag12')
{
	$query45 = "select * from master_employeeinfo where employeecode = '$searchemployeecode'";
	$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res45 = mysqli_fetch_array($exec45);
	
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
	
	$query46 = "select * from master_employee where employeecode = '$searchemployeecode'";
	$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die ("Error in Query46".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res46 = mysqli_fetch_array($exec46);
	
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
.ui-menu .ui-menu-item{ zoom:1 !important; }
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<!--<script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>-->
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script language="javascript">

$(function() {
	
$('#searchemployee').autocomplete({
		
	source:'ajaxemployeenewsearch.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var employeecode = ui.item.employeecode;
			var employeename = ui.item.employeename;
			$('#searchemployeecode').val(employeecode);
			$('#searchemployee').val(employeename);
			
			},
    });
});

/*window.onload = function () 
{
	//var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
}*/

function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function WindowRedirect()
{
	window.location = "editemployeeinfo1.php";
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->

#userphoto{
background-image:url('employeephoto/default.gif');
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
.ui-menu .ui-menu-item{ zoom:1.3 !important; }
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #FF0000; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>
</head>

<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
  <script>

$(function() {

$('#bankname').autocomplete({
		
	source:'bankcodeajax.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var bankcode=ui.item.bankcode;
				$('#bankcode').val(bankcode);	
			}
    });
});
</script>

<script language="javascript">

function process1()
{
	if(document.getElementById("employeename").value == "")
	{
		alert("Please Enter Employeename");
		document.getElementById("employeename").focus();
		return false;
	}
	if(document.getElementById("employeecode").value == "")
	{
		alert("Please Select Employeename");
		//document.getElementById("employeename").focus();
		return false;
	}
	if(document.getElementById("payrollno").value == "")
	{
		alert("Enter Payrollno");
		document.getElementById("payrollno").focus();
		return false;
	}
	if(document.getElementById("gender").value == "")
	{
		alert("Select Gender");
		document.getElementById("gender").focus();
		return false;
	}
	if(document.getElementById("dob").value == "0000-00-00")
	{
		alert("Select Date of Birth");
		document.getElementById("dob").focus();
		return false;
	}
	if(document.getElementById("doj").value == "0000-00-00")
	{
		alert("Select Date of Joining");
		document.getElementById("doj").focus();
		return false;
	}
	if(document.getElementById("nssf").value == "")
	{
		alert("Enter NSSF");
		document.getElementById("nssf").focus();
		return false;
	}
	if(document.getElementById("bankname").value == "")
	{
		alert("Enter Bankname");
		document.getElementById("bankname").focus();
		return false;
	}
	if(document.getElementById("accountnumber").value == "")
	{
		alert("Enter Account Number");
		document.getElementById("accountnumber").focus();
		return false;
	}
	if(document.getElementById("mobile").value == "")
	{
		alert("Enter Mobile Number");
		document.getElementById("mobile").focus();
		return false;
	}
	if(document.getElementById("employmenttype").value == "")
	{
		alert("Enter Employmenttype");
		document.getElementById("employmenttype").focus();
		return false;
	}
	if(document.getElementById("category").value == "")
	{
		alert("Enter Category");
		document.getElementById("category").focus();
		return false;
	}
	if(document.getElementById("department").value == "")
	{
		alert("Enter Department");
		document.getElementById("department").focus();
		return false;
	}
	if(document.getElementById("deptunit").value == "")
	{
		alert("Enter Dept unit");
		document.getElementById("deptunit").focus();
		return false;
	}
	if(document.getElementById("job_title").value == "")
	{
		alert("Enter Job title");
		document.getElementById("job_title").focus();
		return false;
	}
	if(document.getElementById("supervisor").value == "")
	{
		alert("Enter Supervisor");
		document.getElementById("supervisor").focus();
		return false;
	}
	if(document.getElementById("nextofkin").value == "")
	{
		alert("Enter Next of kin");
		document.getElementById("nextofkin").focus();
		return false;
	}
	if(document.getElementById("kinmob").value == "")
	{
		alert("Enter Kin mobile");
		document.getElementById("kinmob").focus();
		return false;
	}
}

function from1submit1()
{
	if(document.getElementById("searchemployee").value == "")
	{
		alert("Please Select Employee");
		document.getElementById("searchemployee").focus();
		return false;		
	}
}

function changeImage(org) {
	var original=org;
    var image = document.getElementById('userphoto');
    if (image.src.match("default.gif")) {
        image.src =org;
    }
}

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
		document.getElementById("deptunit").options.length=null; 
		var combo = document.getElementById('deptunit'); 
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
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); 	//	include ("includes/menu2.php"); ?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
		 <form name="form2" id="form2" method="post" onKeyDown="return disableEnterKey()" action="editemployeeinfo1.php" onSubmit="return from1submit1()" >
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search Employee</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
	<td width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag12" id="frmflag12" value="frmflag12">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
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
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
  <?php
  if($frmflag12 == 'frmflag12')
  {
  ?>
      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="editemployeeinfo1.php" onSubmit="return process1()" enctype="multipart/form-data">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Employee - Edit </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">* Indicated Mandatory Fields. </td>
              </tr>
			  <?php
			  if($errmsg != ''){ ?>
              <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
			  <?php } ?>
              <tr>
			  <td width="155" align="left" class="bodytext3 style2">*Employee Name</td>
			  <td width="261" align="left" class="bodytext3"><input type="text" name="employeename" id="employeename" value="<?php echo $employeename; ?>" size="35" style="border:solid 1px #001E6A;"></td>
			  <td width="140" align="left" class="bodytext3">Employee Code</td>
			  <td width="302" align="left" class="bodytext3"><input type="text" name="employeecode" id="employeecode" value="<?php echo $employeecode; ?>" readonly size="20" style="background-color:#ecf0f5;"></td>
			  </tr>
			  <tr>
			  <td width="155" align="left" class="bodytext3">&nbsp;</td>
			  <td width="261" align="left" class="bodytext3">&nbsp;</td>
			  <td width="140" align="left" class="bodytext3 style2">*Payroll No</td>
			  <td width="302" align="left" class="bodytext3"><input type="text" name="payrollno" id="payrollno" value="<?php echo $payrollno; ?>" size="20" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td colspan="4" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Personal Details</strong></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Father Name</td>
			  <td align="left" class="bodytext3"><input type="text" name="fathername" id="fathername" size="25" value="<?php echo $fathername; ?>" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">Nationality</td>
			  <td align="left" class="bodytext3"><input type="text" name="nationality" id="nationality" size="20" value="<?php echo $nationality; ?>" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3 style2">*Gender</td>
			  <td align="left" class="bodytext3"><select name="gender" id="gender" style="border:solid 1px #001E6A;">
				  <?php
				  if($gender != '') { ?>
					  <option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
					  <?php } ?>
			  <option value="">Select</option>
			  <option value="Male">Male</option>
			  <option value="Female">Female</option></select></td>
			  <td align="left" class="bodytext3 style2">*Date of Birth</td>
			  <td align="left" class="bodytext3"><input type="text" name="dob" id="dob" readonly value="<?php echo $dob; ?>" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('dob','','','','','','past')" style="cursor:pointer"/>	</td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Marital Status</td>
			  <td align="left" class="bodytext3"><select name="maritalstatus" id="maritalstatus" style="border:solid 1px #001E6A;">
			<?php 
			if($maritalstatus != '') { ?>
			<option value = "<?php echo $maritalstatus;?>"><?php echo $maritalstatus; ?></option>
			<?php } ?>		  
			  <option value="">Select</option>
			  <option value="Unmarried">Unmarried</option>
			  <option value="Married">Married</option>
			  <option value="Widow/Widower">Widow/Widower</option>
			  <option value="Divorcee">Divorcee</option></select></td>
			  <td align="left" class="bodytext3">Religion</td>
			  <td align="left" class="bodytext3"><input type="text" name="religion" id="religion" size="20" value="<?php echo $religion; ?>" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Blood Group</td>
			  <td align="left" class="bodytext3"><select name="bloodgroup" id="bloodgroup" style="border:solid 1px #001E6A;">
			<?php 
			if($bloodgroup != '') { ?>
			<option value = "<?php echo $bloodgroup;?>"><?php echo $bloodgroup; ?></option>
			<?php } ?>	
			  <option value="">Select</option>
			  <?php
			  $query7 = "select * from master_bloodgroup where recordstatus <> 'deleted' order by bloodgroup";
			  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res7 = mysqli_fetch_array($exec7))
			  {
			  $bloodgroup = $res7['bloodgroup'];
			  ?>
			  <option value="<?php echo $bloodgroup; ?>"><?php echo $bloodgroup; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  <td align="left" class="bodytext3">Height</td>
			  <td align="left" class="bodytext3"><input type="text" name="height" id="height" size="10" value="<?php echo $height; ?>" style="border:solid 1px #001E6A;">
			  <span class="bodytext3">Weight</span>&nbsp;&nbsp;<input type="text" name="weight" id="weight" value="<?php echo $weight; ?>" size="10" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Address</td>
			  <td align="left" class="bodytext3"><input type="text" name="address" id="address" size="25" value="<?php echo $address; ?>" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">City</td>
			  <td align="left" class="bodytext3"><input type="text" name="city" id="city" value="<?php echo $city; ?>" size="20" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">State</td>
			  <td align="left" class="bodytext3"><input type="text" name="state" id="state" size="20" value="<?php echo $state; ?>" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">Landline </td>
			  <td align="left" class="bodytext3"><input type="text" name="phone" id="phone" size="20" value="<?php echo $phone; ?>" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Email</td>
			  <td align="left" class="bodytext3"><input type="text" name="email" id="email" size="25" value="<?php echo $email; ?>" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3 style2">*Mobile </td>
			  <td align="left" class="bodytext3"><input type="text" name="mobile" id="mobile" size="20" value="<?php echo $mobile; ?>" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">University Name</td>
			  <td align="left" class="bodytext3"><input type="text" name="university" id="university" size="25" value="<?php echo $university; ?>" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">University Reg No </td>
			  <td align="left" class="bodytext3"><input type="text" name="univregno" id="univregno" size="20" value="<?php echo $univregno; ?>" style="border:solid 1px #001E6A;"></td>
			  </tr>
			   <tr>
			  <td align="left" class="bodytext3">Is Disabled Employee ?</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="disabledperson" id="disabledperson" value="Yes" <?php if($disabledperson == 'Yes') { echo 'checked=\"checked\"'; } ?>></td>
              <?php
			  if($photo=="1")
			  {
				  $sentphoto="employeephoto/".$employeecode.".jpg"
				  ?>
			  <td align="left" class="bodytext3">Photo</td>
			  <td align="left" class="bodytext3"><img style="width:170px;height:150px;" id="userphoto" src="employeephoto/default.gif" /> <br>
               <input type="button" onClick="changeImage('<?= $sentphoto; ?>')" value="Show Image" />
              <br>
             Change image <input type="file" name="employeeimg" accept="image/*"></td>
			  <?php
              }
			  else
			  {
				  ?>
			  <td align="left" class="bodytext3"></td>
			  <td align="left" class="bodytext3"> Upload image <input type="file" name="employeeimg" accept="image/*"></td>
                  <?php
			  }
              ?>
              </tr>

              <tr>
              	<td align="left" class="bodytext3"></td>
			  	<td align="left" class="bodytext3">Upload Digital Signature<input type="file" name="digitalsignature" id="digitalsignature" accept="image/*"></td>
			  </tr>
			  <tr>
			  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Job Profile</strong></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3 style2">*Date of Joining</td>
			  <td align="left" class="bodytext3"><input type="text" name="doj" id="doj" readonly size="10" value="<?php echo $doj; ?>" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('doj')" style="cursor:pointer"/>	</td>
			  <td align="left" class="bodytext3 style2">*Employment Type</td>
			  <td align="left" class="bodytext3"><select name="employmenttype" id="employmenttype" style="border:solid 1px #001E6A;">
				  <?php 
			if($employmenttype != '') { ?>
			<option value = "<?php echo $employmenttype;?>"><?php echo $employmenttype; ?></option>
			<?php } ?>	
			  <option value="">Select</option>
			  <option value="Regular">Regular</option>
			  <option value="Casual">Casual</option>
			  </select></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3 style2">*Department</td>
			  <td align="left" class="bodytext3"><select name="department" id="department" style="border:solid 1px #001E6A;" onChange="return DeptUnitBuild()">
				  <?php 
			if($departmentname != '') { ?>
			<option value = "<?php echo $departmentname;?>"><?php echo $departmentname; ?></option>
			<?php } ?>	
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
			  <td align="left" class="bodytext3 style2">*Category</td>
			  <td align="left" class="bodytext3"><select name="category" id="category" style="border:solid 1px #001E6A;">
				  <?php 
			if($category != '') { ?>
			<option value = "<?php echo $category;?>"><?php echo $category; ?></option>
			<?php } ?>	
			  <option value="">Select</option>
			   <?php
			  $query6 = "select * from master_employeecategory where status <> 'deleted' order by category";
			  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res6 = mysqli_fetch_array($exec6))
			  {
			  $categoryanum = $res6['auto_number'];
			  $category = $res6['category'];
			  ?>
			  <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3 style2">*Dept Unit</td>
			  <td align="left" class="bodytext3"><select name="deptunit" id="deptunit" style="border:solid 1px #001E6A;">
				  <?php 
			if($deptunit != '') { ?>
			<option value = "<?php echo $deptunit;?>"><?php echo $deptunit; ?></option>
			<?php } ?>	
			  <option value="">Select</option>
			  </select></td>
			  <td align="left" class="bodytext3 style2">*Job Title</td>
			  <td align="left" class="bodytext3"><select name="job_title" id="job_title" style="border:solid 1px #001E6A;">
			  <?php 
				if($job_title != '') { ?>
				<option value = "<?php echo $job_title;?>"><?php echo $job_title; ?></option>
				<?php } ?>	
			  <option value="">Select</option>
			   <?php
			  $query6 = "select * from master_jobtitle where recordstatus <> 'deleted' order by jobtitle";
			  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res6 = mysqli_fetch_array($exec6))
			  {
			  $jobtitleanum = $res6['auto_number'];
			  $jobtitle = $res6['jobtitle'];
			  ?>
			  <option value="<?php echo $jobtitle; ?>"><?php echo $jobtitle; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Designation</td>
			  <td align="left" class="bodytext3"><select name="designation" id="designation" style="border:solid 1px #001E6A;">
				  <?php 
			if($designation != '') { ?>
			<option value = "<?php echo $designation;?>"><?php echo $designation; ?></option>
			<?php } ?>	
			  <option value="">Select</option>
			   <?php
			  $query6 = "select * from master_employeedesignation where status <> 'deleted' order by designation";
			  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res6 = mysqli_fetch_array($exec6))
			  {
			  $designationanum = $res6['auto_number'];
			  $designation = $res6['designation'];
			  ?>
			  <option value="<?php echo $designation; ?>"><?php echo $designation; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  <td align="left" class="bodytext3 style2">*Supervisor</td>
			  <td align="left" class="bodytext3"><select name="supervisor" id="supervisor" style="border:solid 1px #001E6A;">
				  <?php 
			if($supervisor != '') { ?>
			<option value = "<?php echo $supervisor;?>"><?php echo $supervisor; ?></option>
			<?php } ?>	
			  <option value="">Select</option>
			  <?php
			  $query6 = "select * from master_supervisor where status <> 'deleted' order by supervisor";
			  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res6 = mysqli_fetch_array($exec6))
			  {
			  $supervisoranum = $res6['auto_number'];
			  $supervisor = $res6['supervisor'];
			  ?>
			  <option value="<?php echo $supervisor; ?>"><?php echo $supervisor; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">First Job in Uganda</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="firstjob" id="firstjob" value="Yes" <?php if($firstjob == 'Yes') { echo 'checked=\"checked\"'; } ?>></td>
			  <td align="left" class="bodytext3">Overtime Applicable</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="overtime" id="overtime" value="Yes" <?php if($overtime == 'Yes') { echo 'checked=\"checked\"'; } ?>></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Is User ?</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="user" id="user" value="Yes" <?php if($user == 'Yes') { echo 'checked=\"checked\"'; } ?>></td>
			  <td align="left" class="bodytext3">Prorata</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="prorata" id="prorata" value="Yes" <?php if($prorata == 'Yes') { echo 'checked=\"checked\"'; } ?>></td>
			  </tr>
			 <tr>
			 <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>References</strong></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3 style2">*Next of Kin</td>
			 <td align="left" class="bodytext3"><input type="text" name="nextofkin" id="nextofkin" size="30" value="<?php echo $nextofkin; ?>" style="border:solid 1px #001E6A;"></td>
             	 <td align="left" class="bodytext3">Kin Email</td>
			 <td align="left" class="bodytext3"><input type="text" name="kinemail" id="kinemail" size="30" value="<?php echo $kinemail; ?>" style="border:solid 1px #001E6A;"></td>
		
			
			 </tr>

			 <tr>
			 <td align="left" class="bodytext3 style2">*Kin Mobile No</td>
			 <td align="left" class="bodytext3"><input type="text" name="kinmob" id="kinmob" size="20" value="<?php echo $kinmob; ?>" style="border:solid 1px #001E6A;"></td>
          
			  <td align="left" class="bodytext3">PIN</td>
			 <td align="left" class="bodytext3"><input type="text" name="pinno" id="pinno" size="20" value="<?php echo $pinno; ?>" style="border:solid 1px #001E6A;"></td>
             
			 </tr>
             <tr>
             
			 <tr>
			 <td align="left" class="bodytext3">Name of Spouse</td>
			 <td align="left" class="bodytext3"><input type="text" name="spousename" id="spousename" size="30" value="<?php echo $spousename; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Spouse Email</td>
			 <td align="left" class="bodytext3"><input type="text" name="spouseemail" id="spouseemail" size="30" value="<?php echo $spouseemail; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
             <tr>

			 <td align="left" class="bodytext3">Spouse Mobile No</td>
			 <td align="left" class="bodytext3"><input type="text" name="spousemob" id="spousemob" size="20" value="<?php echo $spousemob; ?>" style="border:solid 1px #001E6A;"></td>
              <td align="left" class="bodytext3">HOSP No</td>
			 <td align="left" class="bodytext3"><input type="text" name="hosp" id="hosp" size="20" value="<?php echo $hosp; ?>" style="border:solid 1px #001E6A;"></td>
			
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3 style2">*NSSF No</td>
			 <td align="left" class="bodytext3"><input type="text" name="nssf" id="nssf" value="<?php echo $nssf; ?>" size="20" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">NHIF No</td>
			 <td align="left" class="bodytext3"><input type="text" name="nhif" id="nhif" size="20" value="<?php echo $nhif; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">National ID / Passport No</td>
			 <td align="left" class="bodytext3"><input type="text" name="passportnumber" id="passportnumber" size="20" value="<?php echo $passportnumber; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Passport Country</td>
			 <td align="left" class="bodytext3"><input type="text" name="passportcountry" id="passportcountry" size="20" value="<?php echo $passportcountry; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">SACCO No</td>
			 <td align="left" class="bodytext3"><input type="text" name="sacconumber" id="sacconumber" size="20" value="<?php echo $sacconumber; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Cost Center Name</td>
			 <td align="left" class="bodytext3"><input type="text" name="costcenter" id="costcenter" size="20" value="<?php echo $costcenter; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bank Details</strong></td>
			</tr>
			<tr>
			 <td align="left" class="bodytext3 style2">*Bank Name</td>
			 <td align="left" class="bodytext3"><input type="text" name="bankname" id="bankname" size="30" value="<?php echo $bankname; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Branch</td>
			 <td align="left" class="bodytext3"><input type="text" name="bankbranch" id="bankbranch" size="20" value="<?php echo $bankbranch; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3 style2">*Account No</td>
			 <td align="left" class="bodytext3"><input type="text" name="accountnumber" id="accountnumber" size="30" value="<?php echo $accountnumber; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3 style2">*Bank Code</td>
			 <td align="left" class="bodytext3"><input type="text" name="bankcode" id="bankcode" size="20" value="<?php echo $bankcode; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Insurance Details</strong></td>
			</tr>
			<tr>
			 <td align="left" class="bodytext3">Company Name</td>
			 <td align="left" class="bodytext3"><input type="text" name="insurancename" id="insurancename" size="30" value="<?php echo $insurancename; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">City</td>
			 <td align="left" class="bodytext3"><input type="text" name="insurancecity" id="insurancecity" size="20" value="<?php echo $insurancecity; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">Policy Type</td>
			 <td align="left" class="bodytext3"><input type="text" name="policytype" id="policytype" size="20" value="<?php echo $policytype; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Policy No</td>
			 <td align="left" class="bodytext3"><input type="text" name="policynumber" id="policynumber" value="<?php echo $policynumber; ?>" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			  <tr>
			  <td align="left" class="bodytext3">Valid From</td>
			  <td align="left" class="bodytext3"><input type="text" name="policyfrom" id="policyfrom" readonly value="<?php echo $policyfrom; ?>" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('policyfrom')" style="cursor:pointer"/>	</td>
			  <td align="left" class="bodytext3">Valid To</td>
			  <td align="left" class="bodytext3"><input type="text" name="policyto" id="policyto" readonly size="10" value="<?php echo $policyto; ?>" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('policyto')" style="cursor:pointer"/>	</td>
			  </tr>
			  <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Qualification</strong></td>
			</tr>
			<tr>
			 <td align="left" class="bodytext3">Basic</td>
			 <td align="left" class="bodytext3"><input type="text" name="qualificationbasic" id="qualificationbasic" size="30" value="<?php echo $qualificationbasic; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Additional</td>
			 <td align="left" class="bodytext3"><input type="text" name="qualificationadditional" id="qualificationadditional" size="30" value="<?php echo $qualificationadditional; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
			  <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Previous Employer</strong></td>
			</tr>
			<tr>
			 <td align="left" class="bodytext3">Name</td>
			 <td align="left" class="bodytext3"><input type="text" name="employername" id="employername" size="30" value="<?php echo $employername; ?>" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Address</td>
			 <td align="left" class="bodytext3"><input type="text" name="employeraddress" id="employeraddress" size="30" value="<?php echo $employeraddress; ?>" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Others</strong></td>
			</tr>
			  <tr>
			  <td align="left" class="bodytext3">Promotion Due on</td>
			  <td align="left" class="bodytext3"><input type="text" name="promotiondue" id="promotiondue" readonly size="10" value="<?php echo $promotiondue; ?>" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('promotiondue')" style="cursor:pointer"/>	</td>
			  <td align="left" class="bodytext3">Increment Due on</td>
			  <td align="left" class="bodytext3"><input type="text" name="incrementdue" id="incrementdue" readonly size="10" value="<?php echo $incrementdue; ?>" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('incrementdue')" style="cursor:pointer"/>	</td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">Free Travel allowance</td>
			 <td align="left" class="bodytext3"><input type="checkbox" name="freetravel" id="freetravel" value="Yes" <?php if($freetravel == 'Yes'){ echo 'checked=\"checked\"'; } ?>></td>
			 <td align="left" class="bodytext3">Company Car</td>
			 <td align="left" class="bodytext3"><input type="checkbox" name="companycar" id="companycar" value="Yes" <?php if($companycar == 'Yes'){ echo 'checked=\"checked\"'; } ?>>
			 <span class="bodytext3">Vehicle No</span>&nbsp;&nbsp;<input type="text" name="vehicleno" id="vehicleno" value="<?php echo $vehicleno; ?>" size="15" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Leaving</strong></td>
			</tr>
			  <tr>
			  <td align="left" class="bodytext3">Date of Leaving</td>
			  <td align="left" class="bodytext3"><input type="text" name="dol" id="dol" readonly size="10" value="<?php echo $dol; ?>" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('dol','','','','','','future')" style="cursor:pointer"/>	</td>
			  <td align="left" class="bodytext3">Is Black Listed ?</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="blacklisted" id="blacklisted" value="Yes" <?php if($blacklisted == 'Yes'){ echo 'checked=\"checked\"'; } ?>></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Reason for Leaving</td>
			  <td align="left" class="bodytext3"><input type="text" name="reasonforleaving" id="reasonforleaving" size="35" value="<?php echo $reasonforleaving; ?>" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">Last Job in Kenya for Expatriate</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="lastjobforexpatriate" id="lastjobforexpatriate" value="Yes" <?php if($lastjobforexpatriate == 'Yes'){ echo 'checked=\"checked\"'; } ?>></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Employee Status on HOLD</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="hold" id="hold" value="Yes" <?php if($hold == 'Yes'){ echo 'checked=\"checked\"'; } ?>></td>
			  <td align="left" class="bodytext3">Date of Holding</td>
			  <td align="left" class="bodytext3"><input type="text" name="doh" id="doh" readonly size="10" value="<?php echo $doh; ?>" style="border:solid 1px #001E6A;">
			    <img src="images2/cal.gif" onClick="javascript:NewCssCal('doh')" style="cursor:pointer"/></td>
			  </tr>
			 <tr>
			 <td align="left" class="bodytext3">Status</td>
			 <td colspan="3" align="left" valign="middle" class="bodytext3">
			 <select name="status" id="status">	 
			 <?php if($status !='') { ?>
		     <option value="<?php echo $status; ?>"><?php echo $status; ?></option>	
		     <?php } ?>	 
		     <option value="Active">Active</option>
		     <option value="Inactive">In Active</option>
		     </select>
			 </td>
			 </tr>
			 <tr>
			 <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			 </tr>
                 <tr>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5"><div align="left">
                <input type="hidden" name="locationname03" id="locationname03" value="<?php echo $locationname03 ?>" >
                <input type="hidden" name="locationcode03" id="locationcode03" value="<?php echo $locationcode03 ?>" >
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Employee" class="button" style="border: 1px solid #001E6A"/>
				  <input type="reset" name="reset" value="Reset" onClick="return WindowRedirect()" style="border: 1px solid #001E6A">
                </div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
    <?php
	}
	?>
	</form>
<script language="javascript">


</script>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

