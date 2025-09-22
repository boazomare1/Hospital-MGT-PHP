<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$companycode = $_SESSION["companycode"];
$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";

// Location details
$query03 = "select * from login_locationdetails where docno = '".$docno."' and username = '$username' order by locationname";
$exec03 = mysqli_query($GLOBALS["___mysqli_ston"], $query03) or die ("Error in Query03".mysqli_error($GLOBALS["___mysqli_ston"]));
$res03 = mysqli_fetch_array($exec03);
$locationcode03 = $res03['locationcode'];
$locationname03 = $res03['locationname'];

// Handle form submission
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1') {
    // Process all form fields
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
    $employmenttype = 'Regular';
    $department = $_REQUEST['department'];
    $departmentanum = 0;
    $departmentname = $department;
    $category = $_REQUEST['category'];
    $designation = $_REQUEST['designation'];
    $supervisor = $_REQUEST['supervisor'];
    if(isset($_REQUEST['firstjob'])) { $firstjob = $_REQUEST['firstjob']; } else { $firstjob = 'No'; }
    if(isset($_REQUEST['overtime'])) { $overtime = $_REQUEST['overtime']; } else { $overtime = 'No'; }
    if(isset($_REQUEST['user'])) { $user = $_REQUEST['user']; } else { $user = 'No'; }
    if(isset($_REQUEST['prorata'])) { $prorata = $_REQUEST['prorata']; } else { $prorata = 'No'; }
    if($prorata == 'Yes'){ $payrollstatus = 'Prorata'; } else { $payrollstatus = 'Active'; }
    $nextofkin = $_REQUEST['nextofkin'];
    $pinno = $_REQUEST['pinno'];
    $kinemail = $_REQUEST['kinemail'];
    $kinmob = $_REQUEST['kinmob'];
    $spouseemail = $_REQUEST['spouseemail'];
    $spousemob = $_REQUEST['spousemob'];
    $spousename = $_REQUEST['spousename'];
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
    $locationcode = $_REQUEST['locationcode03'];
    $locationname = $_REQUEST['locationname03'];
    $appraisal_date = $_REQUEST['empaprldate'];
    $end_date = $_REQUEST['empend'];
    $from_date = $_REQUEST['empfrom'];
    $employeestart_date = $_REQUEST['empstartdate'];
    $employment_status = $_REQUEST['employmentstatus'];
    $employee_type = $_REQUEST['employeetype'];
    $job_group = $_REQUEST['employeegroup'];
    $allowed_leave_days = $_REQUEST['allowed_leavedays'];
    $retirement_date = $_REQUEST['rdate'];
    $payrollno = $_REQUEST['payrollno'];
    
    // Exclude checkboxes
    if(isset($_REQUEST['excludenssf'])) { $excludenssf = $_REQUEST['excludenssf']; } else { $excludenssf = ''; }
    if(isset($_REQUEST['excludenhif'])) { $excludenhif = $_REQUEST['excludenhif']; } else { $excludenhif = ''; }
    if(isset($_REQUEST['excludepaye'])) { $excludepaye = $_REQUEST['excludepaye']; } else { $excludepaye = ''; }
    if(isset($_REQUEST['excluderelief'])) { $excluderelief = $_REQUEST['excluderelief']; } else { $excluderelief = ''; }
    if(isset($_REQUEST['govt_employee'])) { $govt_employee = $_REQUEST['govt_employee']; } else { $govt_employee = ''; }
    
    // Additional fields
    if(isset($_REQUEST['freetravel'])) { $freetravel = $_REQUEST['freetravel']; } else { $freetravel = 'No'; }
    if(isset($_REQUEST['companycar'])) { $companycar = $_REQUEST['companycar']; } else { $companycar = 'No'; }
    $vehicleno = $_REQUEST['vehicleno'];
    $dol = $_REQUEST['dol'];
    if(isset($_REQUEST['blacklisted'])) { $blacklisted = $_REQUEST['blacklisted']; } else { $blacklisted = 'No'; }
    $reasonforleaving = $_REQUEST['reasonforleaving'];
    $doh = $_REQUEST['doh'];
    if(isset($_REQUEST['lastjobforexpatriate'])) { $lastjobforexpatriate = $_REQUEST['lastjobforexpatriate']; } else { $lastjobforexpatriate = 'No'; }
    if(isset($_REQUEST['hold'])) { $hold = $_REQUEST['hold']; } else { $hold = 'No'; }
    $deptunit = $_REQUEST['deptunit'];
    $job_title = $_REQUEST['job_title'];
    
    // Leave days
    $annualleave = $_REQUEST['annualleave'];
    $maternityleave = $_REQUEST['maternityleave'];
    $paternityleave = $_REQUEST['paternityleave'];
    $compassionateleave = $_REQUEST['compassionateleave'];
    $absence = $_REQUEST['absence'];
    $sickleave = $_REQUEST['sickleave'];
    $unpaidleave = $_REQUEST['unpaidleave'];
    $studyleave = $_REQUEST['studyleave'];
    
    // Check if employee already exists
    $query10 = "select * from master_employee where (employeename = '$employeename' or employeecode = '$employeecode')";
    $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res10 = mysqli_fetch_array($exec10);
    $res10employeename = $res10['employeename'];
    
    if($res10employeename == '') {
        // Insert into master_employee table
        $query11 = "insert into master_employee(employeecode, employeename, dateofjoining, firstjob, overtime, is_user, prorata, hold, dateofholding, employmenttype, departmentanum, departmentname, category, designation, supervisor, status, lastupdateusername, lastupdateipaddress, lastupdate,payrollstatus,locationname,locationcode,job_title,allowed_leavedays, excludenssf, excludenhif, excludepaye,annualleave,maternityleave,paternityleave,compassionateleave,absence, sickleave, unpaidleave, studyleave, govt_employee, excluderelief)
        values('$employeecode', '$employeename', '$doj', '$firstjob', '$overtime', '$user', '$prorata', '$hold', '$doh', '$employmenttype', '$departmentanum', '$departmentname', '$category', '$designation', '$supervisor', 'Active', '$username', '$ipaddress', '$updatedatetime','$payrollstatus','$locationname','$locationcode','$job_title','$allowed_leave_days','$excludenssf','$excludenhif','$excludepaye','$annualleave','$maternityleave','$paternityleave','$compassionateleave','$absence','$sickleave','$unpaidleave','$studyleave','$govt_employee','$excluderelief')"; 
        $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        // Insert into master_employeeinfo table
        $query12 = "insert into master_employeeinfo(employeecode, employeename, fathername, nationality, gender, dateofbirth, maritalstatus, religion, bloodgroup, height, weight, address, city, state, phone, mobile, email, university, univregno, disabledperson, nextofkin, pinno,spouseemail,spousemob, spousename, hosp, nssf, nhif, passportnumber, passportcountry, sacconumber, costcenter, bankname, 
        bankbranch, accountnumber, bankcode, insurancename, insurancecity, policytype, policynumber, policyfrom, policyto, qualificationbasic, qualificationadditional, employername, employeraddress, promotiondue, incrementdue, freetravel, companycar, vehicleno, dateofleaving, blacklisted, reasonforleaving, lastjobforexpatriate, status,locationname,locationcode, username, ipaddress, updatedatetime,photo,kinemail,kinmob,payrollno,departmentunit,departmentname,employeestart_date, retirement_date, allowed_leavedays, employee_type, employment_status, appraisal_date, from_date, end_date, job_group)
        values('$employeecode', '$employeename', '$fathername', '$nationality', '$gender', '$dob', '$maritalstatus', '$religion', '$bloodgroup', '$height', '$weight', '$address', '$city', '$state', '$phone', '$mobile', '$email', '$university', '$univregno', '$disabledperson', '$nextofkin', '$pinno','$spouseemail','$spousemob', '$spousename', '$hosp', '$nssf', '$nhif', '$passportnumber', '$passportcountry', '$sacconumber', '$costcenter', '$bankname', 
        '$bankbranch', '$accountnumber', '$bankcode', '$insurancename', '$insurancecity', '$policytype', '$policynumber', '$policyfrom', '$policyto', '$qualificationbasic', '$qualificationadditional', '$employername', '$employeraddress', '$promotiondue', '$incrementdue', '$freetravel', '$companycar', '$vehicleno', '$dol', '$blacklisted', '$reasonforleaving', '$lastjobforexpatriate', 'Active','$locationname','$locationcode', '$username', '$ipaddress', '$updatedatetime','0','$kinemail','$kinmob','$payrollno','$deptunit','$departmentname','$employeestart_date', '$retirement_date', '$allowed_leave_days', '$employee_type', '$employment_status', '$appraisal_date', '$from_date', '$end_date', '$job_group')";
        
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        header("location:addemployeeinfo.php?st=success");
    } else {
        header("location:addemployeeinfo.php?st=failed");
    }
}

// Handle status messages
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success') {
    $errmsg = "Success. New Employee Added.";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed. Employee Already Exists.";
    $bgcolorcode = 'failed';
}

// Generate employee code
$query1 = "select * from master_employee where employeecode LIKE '%EMP%' order by auto_number desc limit 0, 1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);
if ($rowcount1 == 0) {
    $employeecode = 'EMP00000001';
    $payrollno = '0001';
} else {
    $res1 = mysqli_fetch_array($exec1);
    $res1employeecode = $res1['employeecode'];
    $employeecode = substr($res1employeecode, 4, 8);
    $employeecode = intval($employeecode);
    $employeecode = $employeecode + 1;
    
    $maxanum = $employeecode;
    if (strlen($maxanum) == 1) {
        $maxanum1 = '0000000'.$maxanum;
        $payrollno = '000'.$maxanum;
    } else if (strlen($maxanum) == 2) {
        $maxanum1 = '000000'.$maxanum;
        $payrollno = '00'.$maxanum;
    } else if (strlen($maxanum) == 3) {
        $maxanum1 = '00000'.$maxanum;
        $payrollno = '0'.$maxanum;
    } else if (strlen($maxanum) == 4) {
        $maxanum1 = '0000'.$maxanum;
        $payrollno = $maxanum;
    } else if (strlen($maxanum) == 5) {
        $maxanum1 = '000'.$maxanum;
        $payrollno = $maxanum;
    } else if (strlen($maxanum) == 6) {
        $maxanum1 = '00'.$maxanum;
        $payrollno = $maxanum;
    } else if (strlen($maxanum) == 7) {
        $maxanum1 = '0'.$maxanum;
        $payrollno = $maxanum;
    } else if (strlen($maxanum) == 8) {
        $maxanum1 = $maxanum;
        $payrollno = $maxanum;
    }
    
    $employeecode = 'EMP'.$maxanum1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee Information - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/add-employee-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker -->
    <script src="js/datetimepicker_css.js"></script>
</head>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>
    
    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <a href="employee_master.php">Employee Master</a>
        <span>→</span>
        <span>Add Employee Information</span>
    </nav>
    
    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employee_master.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employee Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="addemployeeinfo.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="editemployee_type.php" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Employee Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeeaccessdetails.php" class="nav-link">
                            <i class="fas fa-user-shield"></i>
                            <span>Employee Access Details</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Add Employee Information</h2>
                    <p>Complete employee registration with personal, job, and reference details.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset Form
                    </button>
                    <a href="employee_master.php" class="btn btn-outline">
                        <i class="fas fa-list"></i> View All Employees
                    </a>
                </div>
            </div>
            
            <!-- Employee Form -->
            <form name="form1" id="form1" method="post" action="addemployeeinfo.php" onSubmit="return process1()" enctype="multipart/form-data" class="employee-form">
                <input type="hidden" name="frmflag1" value="frmflag1">
                <input type="hidden" name="locationname03" value="<?php echo htmlspecialchars($locationname03); ?>">
                <input type="hidden" name="locationcode03" value="<?php echo htmlspecialchars($locationcode03); ?>">
                
                <!-- Employee Basic Information -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-user"></i>
                        <h3>Employee Basic Information</h3>
                        <span class="required-note">* Indicates mandatory fields</span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="employeename" class="form-label required">Employee Name</label>
                            <input type="text" name="employeename" id="employeename" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="employeecode" class="form-label">Employee Code</label>
                            <input type="text" name="employeecode" id="employeecode" value="<?php echo htmlspecialchars($employeecode); ?>" class="form-input readonly" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="payrollno" class="form-label">Payroll Number</label>
                            <input type="text" name="payrollno" id="payrollno" value="<?php echo htmlspecialchars($payrollno); ?>" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="gender" class="form-label required">Gender</label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Personal Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-id-card"></i>
                        <h3>Personal Details</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="fathername" class="form-label">Father's Name</label>
                            <input type="text" name="fathername" id="fathername" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" name="nationality" id="nationality" class="form-input" value="KENYAN">
                        </div>
                        
                        <div class="form-group">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="text" name="dob" id="dob" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('dob','','','','','','past')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="maritalstatus" class="form-label">Marital Status</label>
                            <select name="maritalstatus" id="maritalstatus" class="form-select">
                                <option value="">Select Status</option>
                                <option value="Unmarried">Unmarried</option>
                                <option value="Married">Married</option>
                                <option value="Widow/Widower">Widow/Widower</option>
                                <option value="Divorcee">Divorcee</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="religion" class="form-label">Religion</label>
                            <input type="text" name="religion" id="religion" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="bloodgroup" class="form-label">Blood Group</label>
                            <select name="bloodgroup" id="bloodgroup" class="form-select">
                                <option value="">Select Blood Group</option>
                                <?php
                                $query7 = "select * from master_bloodgroup where recordstatus <> 'deleted' order by bloodgroup";
                                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res7 = mysqli_fetch_array($exec7)) {
                                    $bloodgroup = $res7['bloodgroup'];
                                    echo '<option value="'.htmlspecialchars($bloodgroup).'">'.htmlspecialchars($bloodgroup).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="height" class="form-label">Height</label>
                            <input type="text" name="height" id="height" class="form-input" placeholder="cm">
                        </div>
                        
                        <div class="form-group">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="text" name="weight" id="weight" class="form-input" placeholder="kg">
                        </div>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-address-book"></i>
                        <h3>Contact Information</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" id="city" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="state" class="form-label">State</label>
                            <input type="text" name="state" id="state" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Landline</label>
                            <input type="text" name="phone" id="phone" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="mobile" class="form-label required">Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-input" required>
                        </div>
                    </div>
                </div>
                
                <!-- Education Information -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Education Information</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="university" class="form-label">University Name</label>
                            <input type="text" name="university" id="university" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="univregno" class="form-label">University Reg No</label>
                            <input type="text" name="univregno" id="univregno" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="qualificationbasic" class="form-label">Basic Qualification</label>
                            <input type="text" name="qualificationbasic" id="qualificationbasic" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="qualificationadditional" class="form-label">Additional Qualification</label>
                            <input type="text" name="qualificationadditional" id="qualificationadditional" class="form-input">
                        </div>
                    </div>
                </div>
                
                <!-- Job Profile Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-briefcase"></i>
                        <h3>Job Profile</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="doj" class="form-label">Date of Joining</label>
                            <input type="text" name="doj" id="doj" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('doj','','','','','','past')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="department" class="form-label required">Department</label>
                            <select name="department" id="department" class="form-select" onChange="return DeptUnitBuild()" required>
                                <option value="">Select Department</option>
                                <?php
                                $query5 = "select * from master_payrolldepartment where recordstatus <> 'deleted' group by department order by department";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res5 = mysqli_fetch_array($exec5)) {
                                    $departmentname = $res5['department'];
                                    echo '<option value="'.htmlspecialchars($departmentname).'">'.htmlspecialchars($departmentname).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="deptunit" class="form-label">Department Unit</label>
                            <select name="deptunit" id="deptunit" class="form-select">
                                <option value="">Select Unit</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Select Category</option>
                                <?php
                                $query6 = "select * from master_employeecategory where status <> 'deleted' order by category";
                                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res6 = mysqli_fetch_array($exec6)) {
                                    $category = $res6['category'];
                                    echo '<option value="'.htmlspecialchars($category).'">'.htmlspecialchars($category).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="job_title" class="form-label">Job Title</label>
                            <select name="job_title" id="job_title" class="form-select">
                                <option value="">Select Job Title</option>
                                <?php
                                $query6 = "select * from master_jobtitle where recordstatus <> 'deleted' order by jobtitle";
                                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res6 = mysqli_fetch_array($exec6)) {
                                    $jobtitle = $res6['jobtitle'];
                                    echo '<option value="'.htmlspecialchars($jobtitle).'">'.htmlspecialchars($jobtitle).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="designation" class="form-label">Designation</label>
                            <select name="designation" id="designation" class="form-select">
                                <option value="">Select Designation</option>
                                <?php
                                $query6 = "select * from master_employeedesignation where status <> 'deleted' order by designation";
                                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res6 = mysqli_fetch_array($exec6)) {
                                    $designation = $res6['designation'];
                                    echo '<option value="'.htmlspecialchars($designation).'">'.htmlspecialchars($designation).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="supervisor" class="form-label">Supervisor</label>
                            <select name="supervisor" id="supervisor" class="form-select">
                                <option value="">Select Supervisor</option>
                                <?php
                                $query6 = "select * from master_supervisor where status <> 'deleted' order by supervisor";
                                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res6 = mysqli_fetch_array($exec6)) {
                                    $supervisor = $res6['supervisor'];
                                    echo '<option value="'.htmlspecialchars($supervisor).'">'.htmlspecialchars($supervisor).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="employeegroup" class="form-label">Job Group</label>
                            <select name="employeegroup" id="employeegroup" class="form-select">
                                <option value="">Select Job Group</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="employeetype" class="form-label">Employee Type</label>
                            <select name="employeetype" id="employeetype" class="form-select" onChange="return fncemptype()">
                                <option value="">Select Employee Type</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="employmentstatus" class="form-label">Employment Status</label>
                            <select name="employmentstatus" id="employmentstatus" class="form-select" onChange="return fncempemploymentstatus()">
                                <option value="">Select Status</option>
                                <option value="Alive">Active</option>
                                <option value="Terminated">Terminated</option>
                                <option value="Resigned">Resigned</option>
                                <option value="Retired">Retired</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="allowed_leavedays" class="form-label">Allowed Leave Days</label>
                            <input type="text" name="allowed_leavedays" id="allowed_leavedays" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="rdate" class="form-label">Retirement Age</label>
                            <input type="text" name="rdate" id="rdate" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('rdate','','','','','','future')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="empaprldate" class="form-label">Appraisal Date</label>
                            <input type="text" name="empaprldate" id="empaprldate" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('empaprldate','','','','','','future')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Employee Type Date Range (Hidden by default) -->
                    <div id="onemptype" style="display:none" class="form-grid">
                        <div class="form-group">
                            <label for="empfrom" class="form-label required">From Date</label>
                            <input type="text" name="empfrom" id="empfrom" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('empfrom','','','','','','future')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="empend" class="form-label required">End Date</label>
                            <input type="text" name="empend" id="empend" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('empend','','','','','','future')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Employment Status Date (Hidden by default) -->
                    <div id="onempstatus" style="display:none" class="form-grid">
                        <div class="form-group">
                            <label for="empstartdate" class="form-label">Employee Status Date</label>
                            <input type="text" name="empstartdate" id="empstartdate" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('empstartdate','','','','','','future')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Employee Options -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-cog"></i>
                        <h3>Employee Options</h3>
                    </div>
                    
                    <div class="form-grid checkbox-grid">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="firstjob" id="firstjob" value="Yes">
                                <span class="checkmark"></span>
                                First Job in Kenya
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="overtime" id="overtime" value="Yes">
                                <span class="checkmark"></span>
                                Overtime Applicable
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="user" id="user" value="Yes">
                                <span class="checkmark"></span>
                                Is User?
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="prorata" id="prorata" value="Yes">
                                <span class="checkmark"></span>
                                Prorata
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="disabledperson" id="disabledperson" value="Yes">
                                <span class="checkmark"></span>
                                Is Disabled Employee?
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="govt_employee" id="govt_employee" value="Yes">
                                <span class="checkmark"></span>
                                Is Secondary Employee?
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="freetravel" id="freetravel" value="Yes">
                                <span class="checkmark"></span>
                                Free Travel Allowance
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="companycar" id="companycar" value="Yes">
                                <span class="checkmark"></span>
                                Company Car
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="blacklisted" id="blacklisted" value="Yes">
                                <span class="checkmark"></span>
                                Is Blacklisted?
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="lastjobforexpatriate" id="lastjobforexpatriate" value="Yes">
                                <span class="checkmark"></span>
                                Last Job in Kenya for Expatriate
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="hold" id="hold" value="Yes">
                                <span class="checkmark"></span>
                                Employee Status on HOLD
                            </label>
                        </div>
                    </div>
                    
                    <!-- Exclude Options -->
                    <div class="exclude-section">
                        <h4>Exclude from Deductions</h4>
                        <div class="checkbox-grid">
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="excludenssf" id="excludenssf" value="Yes">
                                    <span class="checkmark"></span>
                                    NSSF
                                </label>
                            </div>
                            
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="excludenhif" id="excludenhif" value="Yes">
                                    <span class="checkmark"></span>
                                    NHIF
                                </label>
                            </div>
                            
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="excludepaye" id="excludepaye" value="Yes">
                                    <span class="checkmark"></span>
                                    PAYE
                                </label>
                            </div>
                            
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="excluderelief" id="excluderelief" value="Yes">
                                    <span class="checkmark"></span>
                                    Relief
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Fields -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="vehicleno" class="form-label">Vehicle Number</label>
                            <input type="text" name="vehicleno" id="vehicleno" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="doh" class="form-label">Date of Holding</label>
                            <input type="text" name="doh" id="doh" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('doh')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="employeeimg" class="form-label">Upload Photo</label>
                            <input type="file" name="employeeimg" id="employeeimg" accept="image/*" class="form-file">
                        </div>
                    </div>
                </div>
                
                <!-- Leave Days Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-calendar-times"></i>
                        <h3>Leave Days</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="annualleave" class="form-label">Annual Leave</label>
                            <input type="text" name="annualleave" id="annualleave" class="form-input" value="22" onKeyPress="return validatenumerics(event)">
                        </div>
                        
                        <div class="form-group">
                            <label for="maternityleave" class="form-label">Maternity Leave</label>
                            <input type="text" name="maternityleave" id="maternityleave" class="form-input" value="90" onKeyPress="return validatenumerics(event)">
                        </div>
                        
                        <div class="form-group">
                            <label for="paternityleave" class="form-label">Paternity Leave</label>
                            <input type="text" name="paternityleave" id="paternityleave" class="form-input" value="14" onKeyPress="return validatenumerics(event)">
                        </div>
                        
                        <div class="form-group">
                            <label for="compassionateleave" class="form-label">Compassionate Leave</label>
                            <input type="text" name="compassionateleave" id="compassionateleave" class="form-input" value="7" onKeyPress="return validatenumerics(event)">
                        </div>
                        
                        <div class="form-group">
                            <label for="absence" class="form-label">Absence</label>
                            <input type="text" name="absence" id="absence" class="form-input" onKeyPress="return validatenumerics(event)">
                        </div>
                        
                        <div class="form-group">
                            <label for="sickleave" class="form-label">Sick Leave</label>
                            <input type="text" name="sickleave" id="sickleave" class="form-input" value="28" onKeyPress="return validatenumerics(event)">
                        </div>
                        
                        <div class="form-group">
                            <label for="unpaidleave" class="form-label">Unpaid Leave</label>
                            <input type="text" name="unpaidleave" id="unpaidleave" class="form-input" onKeyPress="return validatenumerics(event)">
                        </div>
                        
                        <div class="form-group">
                            <label for="studyleave" class="form-label">Study Leave</label>
                            <input type="text" name="studyleave" id="studyleave" class="form-input" onKeyPress="return validatenumerics(event)">
                        </div>
                    </div>
                </div>
                
                <!-- References Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-users"></i>
                        <h3>References</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nextofkin" class="form-label">Next of Kin</label>
                            <input type="text" name="nextofkin" id="nextofkin" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="kinemail" class="form-label">Kin Email</label>
                            <input type="email" name="kinemail" id="kinemail" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="kinmob" class="form-label">Kin Mobile No</label>
                            <input type="text" name="kinmob" id="kinmob" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="spousename" class="form-label">Name of Spouse</label>
                            <input type="text" name="spousename" id="spousename" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="spouseemail" class="form-label">Spouse Email</label>
                            <input type="email" name="spouseemail" id="spouseemail" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="spousemob" class="form-label">Spouse Mobile No</label>
                            <input type="text" name="spousemob" id="spousemob" class="form-input">
                        </div>
                    </div>
                </div>
                
                <!-- Official Documents Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-id-card"></i>
                        <h3>Official Documents</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pinno" class="form-label required">PIN No</label>
                            <input type="text" name="pinno" id="pinno" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="nssf" class="form-label required">NSSF No</label>
                            <input type="text" name="nssf" id="nssf" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="nhif" class="form-label required">NHIF No</label>
                            <input type="text" name="nhif" id="nhif" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="passportnumber" class="form-label required">National ID / Passport No</label>
                            <input type="text" name="passportnumber" id="passportnumber" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="passportcountry" class="form-label">National ID / Passport Country</label>
                            <input type="text" name="passportcountry" id="passportcountry" class="form-input" value="KENYA">
                        </div>
                        
                        <div class="form-group">
                            <label for="sacconumber" class="form-label">SACCO No</label>
                            <input type="text" name="sacconumber" id="sacconumber" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="costcenter" class="form-label">Cost Center Name</label>
                            <input type="text" name="costcenter" id="costcenter" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="hosp" class="form-label">HOSP No</label>
                            <input type="text" name="hosp" id="hosp" class="form-input">
                        </div>
                    </div>
                </div>
                
                <!-- Bank Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-university"></i>
                        <h3>Bank Details</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="bankname" class="form-label required">Bank Name</label>
                            <input type="text" name="bankname" id="bankname" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="bankbranch" class="form-label">Branch</label>
                            <input type="text" name="bankbranch" id="bankbranch" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="accountnumber" class="form-label required">Account No</label>
                            <input type="text" name="accountnumber" id="accountnumber" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="bankcode" class="form-label">Bank Code</label>
                            <input type="text" name="bankcode" id="bankcode" class="form-input">
                        </div>
                    </div>
                </div>
                
                <!-- Insurance Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Insurance Details</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="insurancename" class="form-label">Company Name</label>
                            <input type="text" name="insurancename" id="insurancename" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="insurancecity" class="form-label">City</label>
                            <input type="text" name="insurancecity" id="insurancecity" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="policytype" class="form-label">Policy Type</label>
                            <input type="text" name="policytype" id="policytype" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="policynumber" class="form-label">Policy No</label>
                            <input type="text" name="policynumber" id="policynumber" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="policyfrom" class="form-label">Valid From</label>
                            <input type="text" name="policyfrom" id="policyfrom" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('policyfrom')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="policyto" class="form-label">Valid To</label>
                            <input type="text" name="policyto" id="policyto" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('policyto')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Previous Employer Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-building"></i>
                        <h3>Previous Employer</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="employername" class="form-label">Name</label>
                            <input type="text" name="employername" id="employername" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="employeraddress" class="form-label">Address</label>
                            <input type="text" name="employeraddress" id="employeraddress" class="form-input">
                        </div>
                    </div>
                </div>
                
                <!-- Others Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-info-circle"></i>
                        <h3>Other Information</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="promotiondue" class="form-label">Promotion Due on</label>
                            <input type="text" name="promotiondue" id="promotiondue" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('promotiondue')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="incrementdue" class="form-label">Increment Due on</label>
                            <input type="text" name="incrementdue" id="incrementdue" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('incrementdue')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="dol" class="form-label">Date of Leaving</label>
                            <input type="text" name="dol" id="dol" class="form-input date-picker" readonly>
                            <button type="button" class="date-picker-btn" onclick="NewCssCal('dol','','','','','','future')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label for="reasonforleaving" class="form-label">Reason for Leaving</label>
                            <input type="text" name="reasonforleaving" id="reasonforleaving" class="form-input">
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" name="Submit222" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Employee
                    </button>
                    
                    <button type="reset" name="reset" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo"></i>
                        Reset Form
                    </button>
                    
                    <a href="employee_master.php" class="btn btn-outline">
                        <i class="fas fa-list"></i>
                        View All Employees
                    </a>
                </div>
            </form>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/add-employee-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Bank autocomplete -->
    <script>
    $(function() {
        $('#bankname').autocomplete({
            source: 'bankcodeajax.php',
            minLength: 2,
            delay: 0,
            html: true,
            select: function(event,ui){
                var bankcode = ui.item.bankcode;
                $('#bankcode').val(bankcode);
            }
        });
    });
    </script>
</body>
</html>
