<?php
session_start();

//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.

if (!isset($_SESSION["username"])) header ("location:index.php");

include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];

// Get company number from POST or set empty
$companyanum = isset($_POST["companyanum"]) ? $_POST["companyanum"] : "";

$errmsg = '';
$bgcolorcode = '';

// Handle form submission
if (isset($_POST["frmflag1"]) && $_POST["frmflag1"] == 'frmflag1') {
    // Sanitize input data
    $companycode = isset($_REQUEST["companycode"]) ? trim($_REQUEST["companycode"]) : '';
    $companyname = isset($_REQUEST["companyname"]) ? trim($_REQUEST["companyname"]) : '';
    $phonenumber1 = isset($_REQUEST["phonenumber1"]) ? trim($_REQUEST["phonenumber1"]) : '';
    $phonenumber2 = isset($_REQUEST["phonenumber2"]) ? trim($_REQUEST["phonenumber2"]) : '';
    $emailid1 = isset($_REQUEST["emailid1"]) ? trim($_REQUEST["emailid1"]) : '';
    $emailid2 = isset($_REQUEST["emailid2"]) ? trim($_REQUEST["emailid2"]) : '';
    $faxnumber1 = isset($_REQUEST["faxnumber1"]) ? trim($_REQUEST["faxnumber1"]) : '';
    $faxnumber2 = isset($_REQUEST["faxnumber2"]) ? trim($_REQUEST["faxnumber2"]) : '';
    $address1 = isset($_REQUEST["address1"]) ? trim($_REQUEST["address1"]) : '';
    $address2 = isset($_REQUEST["address2"]) ? trim($_REQUEST["address2"]) : '';
    $area = isset($_REQUEST["area"]) ? trim($_REQUEST["area"]) : '';
    $city = isset($_REQUEST["city"]) ? trim($_REQUEST["city"]) : '';
    $state = isset($_REQUEST["state"]) ? trim($_REQUEST["state"]) : '';
    $pincode = isset($_REQUEST["pincode"]) ? trim($_REQUEST["pincode"]) : '';
    $country = isset($_REQUEST["country"]) ? trim($_REQUEST["country"]) : '';
    $tinnumber = isset($_REQUEST["tinnumber"]) ? trim($_REQUEST["tinnumber"]) : '';
    $cstnumber = isset($_REQUEST["cstnumber"]) ? trim($_REQUEST["cstnumber"]) : '';
    $currencyname = isset($_REQUEST["currencyname"]) ? trim($_REQUEST["currencyname"]) : '';
    $currencydecimalname = isset($_REQUEST["currencydecimalname"]) ? trim($_REQUEST["currencydecimalname"]) : '';
    $currencycode = isset($_REQUEST["currencycode"]) ? trim($_REQUEST["currencycode"]) : '';
    $stockmanagement = isset($_REQUEST["stockmanagement"]) ? trim($_REQUEST["stockmanagement"]) : '';
    $patientcodeprefix = isset($_REQUEST["patientcodeprefix"]) ? strtoupper(trim($_REQUEST["patientcodeprefix"])) : '';
    $showlogo = isset($_REQUEST["showlogo"]) ? trim($_REQUEST["showlogo"]) : '';
    
    $companystatus = 'Active';
    $dateposted = $updatedatetime;

    // Check if company already exists
    $query2 = "select * from master_company where companyname = ?";
    $stmt2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query2);
    mysqli_stmt_bind_param($stmt2, "s", $companyname);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $res2 = mysqli_num_rows($result2);

    if ($res2 == 0) {
        // Insert new company
        $query1 = "insert into master_company (companycode, companyname, tinnumber, cstnumber, 
            phonenumber1, phonenumber2, emailid1, emailid2, faxnumber1, faxnumber2, address1, address2, 
            area, city, state, pincode, country, companystatus, dateposted, 
            currencyname, currencycode, stockmanagement, currencydecimalname, patientcodeprefix) 
            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt1 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query1);
        mysqli_stmt_bind_param($stmt1, "ssssssssssssssssssssssss", 
            $companycode, $companyname, $tinnumber, $cstnumber, 
            $phonenumber1, $phonenumber2, $emailid1, $emailid2, $faxnumber1, $faxnumber2, 
            $address1, $address2, $area, $city, $state, $pincode, $country, $companystatus, 
            $dateposted, $currencyname, $currencycode, $stockmanagement, $currencydecimalname, $patientcodeprefix);
        
        if (mysqli_stmt_execute($stmt1)) {
            // Get the new company ID
            $query2 = "select * from master_company where companycode = ? and dateposted = ?";
            $stmt2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query2);
            mysqli_stmt_bind_param($stmt2, "ss", $companycode, $dateposted);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);
            $res2 = mysqli_fetch_array($result2);
            $companyanum = $res2["auto_number"];

            // Copy settings from master_settings_primaryvalues
            $query3 = "select * from master_settings_primaryvalues order by auto_number";
            $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            while ($res3 = mysqli_fetch_array($exec3)) {
                $res3modulename = $res3["modulename"];
                $res3submodulename = $res3["submodulename"];
                $res3settingsname = $res3["settingsname"];
                $res3settingsvalue = $res3["settingsvalue"];

                // Check if setting already exists
                $query5 = "select * from master_settings where companyanum = ? and companycode = ? and 
                    settingsname = ? and modulename = ?";
                $stmt5 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query5);
                mysqli_stmt_bind_param($stmt5, "isss", $companyanum, $companycode, $res3settingsname, $res3modulename);
                mysqli_stmt_execute($stmt5);
                $result5 = mysqli_stmt_get_result($stmt5);
                $rowcount5 = mysqli_num_rows($result5);

                if ($rowcount5 == 0) {
                    // Insert setting
                    $query4 = "insert into master_settings (companyanum, companycode, modulename, submodulename, settingsname, settingsvalue) 
                        values (?, ?, ?, ?, ?, ?)";
                    $stmt4 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query4);
                    mysqli_stmt_bind_param($stmt4, "isssss", $companyanum, $companycode, $res3modulename, $res3submodulename, $res3settingsname, $res3settingsvalue);
                    mysqli_stmt_execute($stmt4);
                }
            }

            // Clear form variables
            $companyname = $title1 = $title2 = $contactperson1 = $contactperson2 = $designation1 = $designation2 = '';
            $phonenumber1 = $phonenumber2 = $emailid1 = $emailid2 = $faxnumber1 = $faxnumber2 = '';
            $address1 = $address2 = $area = $location = $city = $state = $pincode = $country = '';
            $tinnumber = $cstnumber = $companystatus = $patientcodeprefix = $showlogo = '';
            $dateposted = $updatedatetime;

            header("location:setactivecompany1.php");
        } else {
            $errmsg = "Failed to create company. Please try again.";
            $bgcolorcode = 'error';
        }
    } else {
        $errmsg = "Company with this name already exists.";
        $bgcolorcode = 'error';
    }
} else {
    // Initialize form variables
    $companyname = isset($_REQUEST["companyname"]) ? $_REQUEST["companyname"] : '';
    $title1 = isset($_REQUEST["title1"]) ? $_REQUEST["title1"] : '';
    $title2 = isset($_REQUEST["title2"]) ? $_REQUEST["title2"] : '';
    $contactperson1 = isset($_REQUEST["contactperson1"]) ? $_REQUEST["contactperson1"] : '';
    $contactperson2 = isset($_REQUEST["contactperson2"]) ? $_REQUEST["contactperson2"] : '';
    $designation1 = isset($_REQUEST["designation1"]) ? $_REQUEST["designation1"] : '';
    $designation2 = isset($_REQUEST["designation2"]) ? $_REQUEST["designation2"] : '';
    $phonenumber1 = isset($_REQUEST["phonenumber1"]) ? $_REQUEST["phonenumber1"] : '';
    $phonenumber2 = isset($_REQUEST["phonenumber2"]) ? $_REQUEST["phonenumber2"] : '';
    $emailid1 = isset($_REQUEST["emailid1"]) ? $_REQUEST["emailid1"] : '';
    $emailid2 = isset($_REQUEST["emailid2"]) ? $_REQUEST["emailid2"] : '';
    $faxnumber1 = isset($_REQUEST["faxnumber1"]) ? $_REQUEST["faxnumber1"] : '';
    $faxnumber2 = isset($_REQUEST["faxnumber2"]) ? $_REQUEST["faxnumber2"] : '';
    $address1 = isset($_REQUEST["address1"]) ? $_REQUEST["address1"] : '';
    $address2 = isset($_REQUEST["address2"]) ? $_REQUEST["address2"] : '';
    $area = isset($_REQUEST["area"]) ? $_REQUEST["area"] : '';
    $location = isset($_REQUEST["location"]) ? $_REQUEST["location"] : '';
    $city = isset($_REQUEST["city"]) ? $_REQUEST["city"] : '';
    $pincode = isset($_REQUEST["pincode"]) ? $_REQUEST["pincode"] : '';
    $country = isset($_REQUEST["country"]) ? $_REQUEST["country"] : '';
    $state = isset($_REQUEST["state"]) ? $_REQUEST["state"] : '';
    $tinnumber = isset($_REQUEST["tinnumber"]) ? $_REQUEST["tinnumber"] : '';
    $cstnumber = isset($_REQUEST["cstnumber"]) ? $_REQUEST["cstnumber"] : '';
    $companystatus = isset($_REQUEST["companystatus"]) ? $_REQUEST["companystatus"] : '';
    $currencyname = isset($_REQUEST["currencyname"]) ? $_REQUEST["currencyname"] : '';
    $currencydecimalname = isset($_REQUEST["currencydecimalname"]) ? $_REQUEST["currencydecimalname"] : '';
    $currencycode = isset($_REQUEST["currencycode"]) ? $_REQUEST["currencycode"] : '';
    $patientcodeprefix = isset($_REQUEST["patientcodeprefix"]) ? $_REQUEST["patientcodeprefix"] : '';
    $f9color = '#000000';
    $f10color = '#000000';
    $f25color = '#000000';
    $dateposted = $updatedatetime;
    $showcity = $city;
    $showlogo = isset($_REQUEST["showlogo"]) ? $_REQUEST["showlogo"] : '';
}

// Handle status messages
if (isset($_REQUEST["st"])) {
    $st = $_REQUEST["st"];
    if ($st == 'success') {
        $errmsg = "Success. New Company Updated.";
        $bgcolorcode = 'success';
        $cpynum = isset($_REQUEST["cpynum"]) ? $_REQUEST["cpynum"] : '';
        if ($cpynum == 1) {
            $errmsg = "Success. New Company Updated. Please Logout & Login Again To Proceed.";
        }
    } else if ($st == 'failed') {
        $errmsg = "Failed. Company Already Exists.";
        $bgcolorcode = 'error';
    }
}

$cpycount = isset($_REQUEST["cpycount"]) ? $_REQUEST["cpycount"] : '';
if ($cpycount == 'firstcompany') {
    $errmsg = "Welcome. You Need To Add Your Company Details Here.";
    $bgcolorcode = 'info';
}

// Generate company code
$query1 = "select * from master_company order by auto_number desc limit 0, 1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);

if ($rowcount1 == 0) {
    $companycode = 'HSP00000001';
} else {
    $res1 = mysqli_fetch_array($exec1);
    $res1companycode = $res1["companycode"];
    $companycode = substr($res1companycode, 3, 8);
    $companycode = intval($companycode);
    $companycode = $companycode + 1;

    $maxanum = $companycode;
    if (strlen($maxanum) == 1) {
        $maxanum1 = '0000000'.$maxanum;
    } else if (strlen($maxanum) == 2) {
        $maxanum1 = '000000'.$maxanum;
    } else if (strlen($maxanum) == 3) {
        $maxanum1 = '00000'.$maxanum;
    } else if (strlen($maxanum) == 4) {
        $maxanum1 = '0000'.$maxanum;
    } else if (strlen($maxanum) == 5) {
        $maxanum1 = '000'.$maxanum;
    } else if (strlen($maxanum) == 6) {
        $maxanum1 = '00'.$maxanum;
    } else if (strlen($maxanum) == 7) {
        $maxanum1 = '0'.$maxanum;
    } else if (strlen($maxanum) == 8) {
        $maxanum1 = $maxanum;
    }

    $companycode = 'HSP'.$maxanum1;
}

// Set default currency values
if ($currencyname == '') $currencyname = 'Rupees';
if ($currencydecimalname == '') $currencydecimalname = 'Paise';
if ($currencycode == '') $currencycode = 'INR';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Company - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addcompany1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- JavaScript files -->
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
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
            <span class="location-info">📍 Company Management</span>
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
        <a href="company.php">🏢 Company</a>
        <span>→</span>
        <span>Add New Company</span>
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
                        <a href="company.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Company</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="addcompany1.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Company</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="settings.php" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode; ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Add New Company</h2>
                    <p>Create a new company profile with complete business information and settings.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="company.php" class="btn btn-outline">
                        <i class="fas fa-building"></i> Company List
                    </a>
                </div>
            </div>

            <!-- Existing Companies List -->
            <?php if ($cpycount != 'firstcompany'): ?>
            <div class="companies-section">
                <div class="section-header">
                    <i class="fas fa-building section-icon"></i>
                    <h3 class="section-title">Existing Companies</h3>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th width="7%">Action</th>
                                <th width="30%">Company Name</th>
                                <th width="41%">Address</th>
                                <th width="12%">Phone</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colorloopcount = 0;
                            $query100 = "select * from master_company order by companyname";
                            $exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while ($res100 = mysqli_fetch_array($exec100)) {
                                $res100companyname = $res100["companyname"];
                                $res100address = $res100["address1"];
                                $res100phonenumber1 = $res100["phonenumber1"];
                                $res100companystatus = $res100["companystatus"];
                                $res100auto_number = $res100["auto_number"];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1);
                                $rowClass = $showcolor == 0 ? 'even-row' : 'odd-row';
                                ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td class="action-cell">
                                        <a href="editcompany1.php?anum=<?php echo $res100auto_number; ?>" class="btn btn-sm btn-outline">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                    <td class="name-cell"><?php echo htmlspecialchars($res100companyname); ?></td>
                                    <td class="address-cell"><?php echo htmlspecialchars($res100address); ?></td>
                                    <td class="phone-cell"><?php echo htmlspecialchars($res100phonenumber1); ?></td>
                                    <td class="status-cell">
                                        <span class="status-badge status-<?php echo strtolower($res100companystatus); ?>">
                                            <?php echo htmlspecialchars($res100companystatus); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Add Company Form -->
            <div class="form-section">
                <div class="form-header">
                    <i class="fas fa-plus-circle form-icon"></i>
                    <h3 class="form-title">Company Information</h3>
                    <p class="form-subtitle">Fill in the details to create a new company profile</p>
                </div>
                
                <form name="form1" id="form1" method="post" action="addcompany1.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()" class="company-form">
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    
                    <!-- Basic Information -->
                    <div class="form-group-section">
                        <h4 class="section-title">Basic Information</h4>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="companyname" class="form-label required">Company Name</label>
                                <input name="companyname" id="companyname" value="<?php echo htmlspecialchars($companyname); ?>" 
                                       class="form-input" placeholder="Enter company name" required />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="address1" class="form-label">Address Line 1</label>
                                <input name="address1" id="address1" value="<?php echo htmlspecialchars($address1); ?>" 
                                       class="form-input" placeholder="Street address" />
                            </div>
                            <div class="form-group">
                                <label for="address2" class="form-label">Address Line 2</label>
                                <input name="address2" id="address2" value="<?php echo htmlspecialchars($address2); ?>" 
                                       class="form-input" placeholder="Apartment, suite, etc." />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="area" class="form-label">Area / Location</label>
                                <input name="area" id="area" value="<?php echo htmlspecialchars($area); ?>" 
                                       class="form-input" placeholder="Area or location" />
                            </div>
                            <div class="form-group">
                                <label for="state" class="form-label required">State</label>
                                <input name="state" id="state" value="<?php echo htmlspecialchars($state); ?>" 
                                       class="form-input" placeholder="State" required />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city" class="form-label required">City</label>
                                <input name="city" id="city" value="<?php echo htmlspecialchars($city); ?>" 
                                       class="form-input" placeholder="City" required />
                            </div>
                            <div class="form-group">
                                <label for="country" class="form-label">Country</label>
                                <input name="country" id="country" value="<?php echo htmlspecialchars($country); ?>" 
                                       class="form-input" placeholder="Country" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pincode" class="form-label">Pincode / ZIP</label>
                                <input name="pincode" id="pincode" value="<?php echo htmlspecialchars($pincode); ?>" 
                                       class="form-input" placeholder="Postal code" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="form-group-section">
                        <h4 class="section-title">Contact Information</h4>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phonenumber1" class="form-label">Primary Phone</label>
                                <input name="phonenumber1" id="phonenumber1" value="<?php echo htmlspecialchars($phonenumber1); ?>" 
                                       class="form-input" placeholder="Primary phone number" />
                            </div>
                            <div class="form-group">
                                <label for="phonenumber2" class="form-label">Secondary Phone</label>
                                <input name="phonenumber2" id="phonenumber2" value="<?php echo htmlspecialchars($phonenumber2); ?>" 
                                       class="form-input" placeholder="Secondary phone number" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="faxnumber1" class="form-label">Primary Fax</label>
                                <input name="faxnumber1" id="faxnumber1" value="<?php echo htmlspecialchars($faxnumber1); ?>" 
                                       class="form-input" placeholder="Primary fax number" />
                            </div>
                            <div class="form-group">
                                <label for="faxnumber2" class="form-label">Secondary Fax</label>
                                <input name="faxnumber2" id="faxnumber2" value="<?php echo htmlspecialchars($faxnumber2); ?>" 
                                       class="form-input" placeholder="Secondary fax number" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="emailid1" class="form-label">Primary Email</label>
                                <input name="emailid1" id="emailid1" value="<?php echo htmlspecialchars($emailid1); ?>" 
                                       class="form-input" placeholder="Primary email address" type="email" />
                            </div>
                            <div class="form-group">
                                <label for="emailid2" class="form-label">Secondary Email</label>
                                <input name="emailid2" id="emailid2" value="<?php echo htmlspecialchars($emailid2); ?>" 
                                       class="form-input" placeholder="Secondary email address" type="email" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tax Information -->
                    <div class="form-group-section">
                        <h4 class="section-title">Tax Information</h4>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="tinnumber" class="form-label">TIN Number</label>
                                <input name="tinnumber" id="tinnumber" value="<?php echo htmlspecialchars($tinnumber); ?>" 
                                       class="form-input" placeholder="Tax Identification Number" style="text-transform: uppercase;" />
                            </div>
                            <div class="form-group">
                                <label for="cstnumber" class="form-label">CST Number</label>
                                <input name="cstnumber" id="cstnumber" value="<?php echo htmlspecialchars($cstnumber); ?>" 
                                       class="form-input" placeholder="Central Sales Tax Number" style="text-transform: uppercase;" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Currency Settings -->
                    <div class="form-group-section">
                        <h4 class="section-title">Currency Settings</h4>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="currencyname" class="form-label">Currency Name</label>
                                <input name="currencyname" id="currencyname" value="<?php echo htmlspecialchars($currencyname); ?>" 
                                       class="form-input" placeholder="e.g., Rupees, Dollar" />
                                <small class="form-help">* Ex: Rupees / Dollar</small>
                            </div>
                            <div class="form-group">
                                <label for="currencydecimalname" class="form-label">Currency Decimal Name</label>
                                <input name="currencydecimalname" id="currencydecimalname" value="<?php echo htmlspecialchars($currencydecimalname); ?>" 
                                       class="form-input" placeholder="e.g., Paise, Cent" />
                                <small class="form-help">* Ex: Paise / Cent</small>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="currencycode" class="form-label">Currency Code</label>
                                <input name="currencycode" id="currencycode" value="<?php echo htmlspecialchars($currencycode); ?>" 
                                       class="form-input" placeholder="e.g., INR, USD" />
                                <small class="form-help">* Ex: INR / USD</small>
                            </div>
                            <div class="form-group">
                                <label for="patientcodeprefix" class="form-label">Patient Code Prefix</label>
                                <input name="patientcodeprefix" id="patientcodeprefix" value="<?php echo htmlspecialchars($patientcodeprefix); ?>" 
                                       class="form-input" placeholder="e.g., ABC" style="text-transform: uppercase;" />
                                <small class="form-help">* Ex: ABC</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- System Information -->
                    <div class="form-group-section">
                        <h4 class="section-title">System Information</h4>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dateposted" class="form-label">Date Created</label>
                                <input name="dateposted" id="dateposted" value="<?php echo htmlspecialchars($dateposted); ?>" 
                                       class="form-input" readonly style="background-color: #f8f9fa;" />
                            </div>
                            <div class="form-group">
                                <label for="companycode" class="form-label">Company Code</label>
                                <input name="companycode" id="companycode" value="<?php echo htmlspecialchars($companycode); ?>" 
                                       class="form-input" readonly style="background-color: #f8f9fa; text-transform: uppercase;" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="showlogo" class="form-label">Logo Display</label>
                                <select name="showlogo" id="showlogo" class="form-select">
                                    <option value="HIDE LOGO" <?php echo ($showlogo == 'HIDE LOGO' || $showlogo == '') ? 'selected' : ''; ?>>Hide Logo</option>
                                    <option value="SHOW LOGO" <?php echo ($showlogo == 'SHOW LOGO') ? 'selected' : ''; ?>>Show Logo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Company
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset Form
                        </button>
                        <a href="company.php" class="btn btn-outline">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addcompany1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>


