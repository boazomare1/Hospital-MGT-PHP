<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$companycode = $_SESSION["companycode"];
$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";

$registrationdate = date('Y-m-d');
$registrationtime = date('H:i:s');

$searchpaymenttype= '';

// Handle form submission
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    // Process form submission here
    $errmsg = "Patient registered successfully!";
    $bgcolorcode = "success";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Emergency Patient - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/modern-emergency-form.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <span>Emergency Patient</span>
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
                        <a href="searchpatient.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Search Patient</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="addemergencypatient1.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Emergency Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="emergencyindent.php" class="nav-link">
                            <i class="fas fa-file-medical"></i>
                            <span>Emergency Indent</span>
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
                    <h2>Add Emergency Patient</h2>
                    <p>Register a new emergency patient with complete medical information.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
            
            <!-- Modern Form -->
            <form name="form1" id="form1" method="post" action="addemergencypatient1.php" class="modern-emergency-form">
                
                <!-- Form Header -->
                <div class="form-header">
                    <h2>🏥 New Patient Registration</h2>
                    <p>Complete patient information for emergency admission</p>
                </div>

                <!-- Location Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3>📍 Location</h3>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location" class="form-label">Hospital Location</label>
                            <select name="location" id="location" class="form-select">
                                <?php
                                $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res1 = mysqli_fetch_array($exec1);
                                $res1location = $res1["locationname"];
                                ?>
                                <option value="">Select Location</option>
                                <option value="<?php echo $res1location; ?>" selected><?php echo $res1location; ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Patient Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3>👤 Patient Information</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="searchpaymenttype" class="form-label">Type</label>
                            <input type="text" name="searchpaymenttype" id="searchpaymenttype" value="EMERGENCY" class="form-input" readonly>
                            <input type="hidden" name="searchpaymentcode" id="searchpaymentcode" value="7">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchsubtype" class="form-label">Sub Type</label>
                            <input type="text" name="searchsubtype" id="searchsubtype" value="EMERGENCY" class="form-input" readonly>
                            <input type="hidden" name="searchsubcode" id="searchsubcode" value="27">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchaccountname" class="form-label">Account</label>
                            <input type="text" name="searchaccountname" id="searchaccountname" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="accountexpirydate" class="form-label">Validity</label>
                            <input type="text" name="accountexpirydate" id="accountexpirydate" value="" class="form-input" readonly>
                        </div>
                    </div>
                </div>

                <!-- Medical Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3>🏥 Medical Details</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="planname" class="form-label">Plan</label>
                            <select name="planname" id="planname" class="form-select">
                                <option value="">Select Plan</option>
                                <option value="Emergency">Emergency</option>
                                <option value="General">General</option>
                                <option value="VIP">VIP</option>
                                <option value="Insurance">Insurance</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="planfixedamount" class="form-label">Copay</label>
                            <input type="text" name="planfixedamount" id="planfixedamount" value="" class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="overalllimit" class="form-label">Limit</label>
                            <input type="text" name="overalllimit" id="overalllimit" value="" class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="billtype" class="form-label">Bill Type</label>
                            <input type="text" name="billtype" id="billtype" value="PAY LATER" class="form-input" readonly>
                        </div>
                    </div>
                    
                    <!-- Hidden fields for plan details -->
                    <input type="hidden" name="planvaliditystart" id="planvaliditystart" value="<?php echo $registrationdate; ?>" readonly>
                    <input type="hidden" name="insuranceid" id="insuranceid" value="<?php echo isset($insuranceid) ? $insuranceid : ''; ?>" readonly>
                    <input type="hidden" name="planpercentage" id="planpercentage" readonly>
                    <input type="hidden" name="visitlimit" id="visitlimit" value="" readonly>
                    <input type="hidden" name="ipvisitlimit" id="ipvisitlimit" value="">
                    <input type="hidden" name="ipoveralllimit" id="ipoveralllimit" value="">
                    <input type="hidden" name="planexpirydate" id="planexpirydate" value="<?php echo isset($planexpirydate) ? $planexpirydate : ''; ?>" readonly>
                </div>

                <!-- Personal Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3>👨‍👩‍👧‍👦 Personal Details</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="salutation" class="form-label">Salutation</label>
                            <select name="salutation" id="salutation" class="form-select">
                                <option value="">Select Salutation</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="gender" class="form-label">Sex</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="emer_patienttype" class="form-label">Patient Type</label>
                            <select name="emer_patienttype" id="emer_patienttype" class="form-select">
                                <option value="ADULT">ADULT</option>
                                <option value="CHILD">CHILD</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="customername" class="form-label">First Name</label>
                            <input name="customername" id="customername" value="EMERGENCY" readonly class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="customermiddlename" class="form-label">Middle Name</label>
                            <input name="customermiddlename" id="customermiddlename" value="<?php echo date('Y-m-d'); ?>" readonly class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="customerlastname" class="form-label">Last Name</label>
                            <input name="customerlastname" id="customerlastname" value="<?php echo date('H:i:s'); ?>" readonly class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="nationalidnumber" class="form-label">National ID</label>
                            <input name="nationalidnumber" id="nationalidnumber" value="" class="form-input" onBlur="return funcNationalIDValidation1()">
                        </div>
                        
                        <div class="form-group">
                            <label for="mothername" class="form-label">Guardian</label>
                            <input name="mothername" id="mothername" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="maritalstatus" class="form-label">Status</label>
                            <select name="maritalstatus" id="maritalstatus" class="form-select">
                                <option value="">Select Marital Status</option>
                                <option value="SINGLE">SINGLE</option>
                                <option value="MARRIED">MARRIED</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="bloodgroup" class="form-label">Blood Group</label>
                            <select name="bloodgroup" id="bloodgroup" class="form-select">
                                <option value="">Select Blood Group</option>
                                <?php
                                $query55 = "select * from master_bloodgroup where recordstatus = '' order by bloodgroup";
                                $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res55 = mysqli_fetch_array($exec55)) {
                                    $res5bloodgroup = $res55["bloodgroup"];
                                    ?>
                                    <option value="<?php echo $res5bloodgroup; ?>"><?php echo $res5bloodgroup; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="occupation" class="form-label">Occupation</label>
                            <input name="occupation" id="occupation" value="" class="form-input">
                        </div>
                    </div>
                    
                    <!-- Hidden fields for age calculation -->
                    <input type="hidden" name="dateofbirth" id="dateofbirth" value="" onChange="return GetDifference1()" readonly>
                    <input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="age" id="age" value="" onKeyUp="return dobcalc();" onBlur="return idhide();" onKeyPress="return validatenumerics(event);">
                    <input type="hidden" name="ageduration" id="ageduration" value="" readonly>
                    <input type="hidden" name="nameofrelative" id="nameofrelative" value="">
                </div>

                <!-- Contact Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3>📞 Contact Details</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="mobilenumber" class="form-label">Mobile No</label>
                            <input name="mobilenumber" id="mobilenumber" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="emailid1" class="form-label">Email Id 1</label>
                            <input name="emailid1" id="emailid1" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="kinname" class="form-label">Next Kin</label>
                            <input name="kinname" id="kinname" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="kincontactnumber" class="form-label">Kin Tel#</label>
                            <input name="kincontactnumber" id="kincontactnumber" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="address2" class="form-label">Address 2</label>
                            <input name="address2" id="address2" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="state" class="form-label">State</label>
                            <input name="state" id="state" value="" class="form-input">
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3>🏠 Address Information</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="address1" class="form-label">Address 1</label>
                            <input name="address1" id="address1" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="address2" class="form-label">Address 2</label>
                            <input name="address2" id="address2" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="city" class="form-label">City</label>
                            <input name="city" id="city" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="state" class="form-label">State</label>
                            <input name="state" id="state" value="" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="country" class="form-label">Country</label>
                            <input name="country" id="country" value="KENYA" class="form-input" readonly>
                        </div>
                    </div>
                </div>

                <!-- Registration Details Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3>📋 Registration Details</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="customercode" class="form-label">Reg Code</label>
                            <input name="customercode" id="customercode" value="EMER-419-25" class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="registrationdate" class="form-label">Reg Date</label>
                            <input name="registrationdate" id="registrationdate" value="<?php echo date('Y-m-d'); ?>" class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="registrationtime" class="form-label">Reg Time</label>
                            <input name="registrationtime" id="registrationtime" value="<?php echo date('H:i:s'); ?>" class="form-input" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="patientphoto" class="form-label">Photo</label>
                            <input type="file" name="patientphoto" id="patientphoto" class="form-file" accept="image/jpeg,image/jpg">
                            <small class="form-help">Only JPG or JPEG Files</small>
                        </div>
                    </div>
                        </div>

                        <!-- Additional Hidden Fields -->
                        <input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" value="">
                        <input type="hidden" name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="">
                        <input type="hidden" name="tpacompany" id="tpacompany" value="">

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <?php 
                            // Check for OP Visit rights
                            $query1 = "select * from master_employeerights where username = '$username' and submenuid = 'SM010'";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $rowcount1 = mysqli_num_rows($exec1);
                            
                            if ($rowcount1 != 0) {
                            ?>
                            <button type="submit" name="Submit222" id="submit1" accesskey="o" class="btn btn-primary">
                                <i class="fas fa-user-md"></i>
                                Save & Go OP Visit (Alt+O)
                            </button>
                            <?php } ?>
                            
                            <?php 
                            // Check for IP Visit rights
                            $query1 = "select * from master_employeerights where username = '$username' and submenuid = 'SM011'";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $rowcount1 = mysqli_num_rows($exec1);
                            
                            if ($rowcount1 != 0) {
                            ?>
                            <button type="submit" name="Submit222" id="submit2" accesskey="i" class="btn btn-primary">
                                <i class="fas fa-bed"></i>
                                Save & Go IP Visit (Alt+I)
                            </button>
                            <?php } ?>
                            
                            <button type="submit" name="Submit222" id="submit" accesskey="s" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Save Registration (Alt+S)
                            </button>
                            
                            <button type="reset" name="Submit2223" accesskey="r" class="btn btn-secondary">
                                <i class="fas fa-undo"></i>
                                Reset (Alt+R)
                            </button>
                        </div>

                        <input type="hidden" name="frmflag1" value="frmflag1">
                    </form>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/emergency-patient-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
