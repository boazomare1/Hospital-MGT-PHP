<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$consultationdate = '';

if(isset($_POST['ADate1'])) {
    $fromdate = $_POST['ADate1'];
} else {
    $fromdate = $transactiondatefrom;
}

if(isset($_POST['ADate2'])) {
    $todate = $_POST['ADate2'];
} else {
    $todate = $transactiondateto;
}

$var112 = 0;
$docno = $_SESSION['docno'];
$sno = 0;

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

if($location != '') {
    $locationcode = $location;
}

// Status messages
$matchfailed = isset($_REQUEST['st']) ? $_REQUEST['st'] : '';
$errmsg = "";
$bgcolorcode = "";

if($matchfailed == "matchfailed") {
    $errmsg = "Failed to update.";
    $bgcolorcode = 'error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OP Package Process List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/oppackageprocesslist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
        <a href="op.php">🏥 OP Management</a>
        <span>→</span>
        <span>Wellness Package Process List</span>
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
                        <a href="op.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>OP Management</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="oppackageprocesslist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Package Process List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pharmacy1.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pharmacy</span>
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
                        <i class="fas fa-<?php echo $bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'; ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Wellness Package Process List</h2>
                    <p>Manage and process wellness packages for patients.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="op.php" class="btn btn-outline">
                        <i class="fas fa-user-md"></i> OP Management
                    </a>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-search search-icon"></i>
                    <h3 class="search-title">Search Wellness Packages</h3>
                </div>
                
                <form name="cbform1" method="post" action="oppackageprocesslist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-select">
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($reslocationanum); ?>" 
                                            <?php if($location != '' && $location == $reslocationanum) echo "selected"; ?>>
                                        <?php echo htmlspecialchars($reslocation); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" 
                                   value="" placeholder="Enter patient name..." autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   value="" placeholder="Enter registration number..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" 
                                   value="" placeholder="Enter visit code..." autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                       class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="date-picker-icon" alt="Select Date" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                       class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="date-picker-icon" alt="Select Date" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <?php if (isset($_REQUEST["cbfrmflag1"])): 
                $cbfrmflag1 = $_REQUEST["cbfrmflag1"];
                if ($cbfrmflag1 == 'cbfrmflag1') {
                    $searchpatient = $_POST['patient'];
                    $searchpatientcode = $_POST['patientcode'];
                    $searchvisitcode = $_POST['visitcode'];
                    $fromdate = $_POST['ADate1'];
                    $todate = $_POST['ADate2'];
            ?>
            <div class="results-section">
                <div class="results-header">
                    <i class="fas fa-list results-icon"></i>
                    <h3 class="results-title">Wellness Package Results</h3>
                    <div class="location-display" id="ajaxlocation">
                        <strong>Location: </strong>
                        <?php
                        if ($location != '') {
                            $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                            $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res12 = mysqli_fetch_array($exec12);
                            echo htmlspecialchars($res1location = $res12["locationname"]);
                        } else {
                            $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res1 = mysqli_fetch_array($exec1);
                            echo htmlspecialchars($res1location = $res1["locationname"]);
                        }
                        ?>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>OP Date</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Patient</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Department</th>
                                <th>Account</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colorloopcount = '';
                            $sno = '0';
                            
                            // Query for PAY NOW completed packages
                            $query1 = "select * from consultation_services where locationcode = '".$locationcode."' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and (paymentstatus='completed' OR paymentstatus='paid') and billtype='PAY NOW' and process='pending' and servicerefund <> 'completed' and wellnessitem <> '1' and wellnesspkg ='1' and consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate desc";
                            
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $res1patientcode = $res1['patientcode'];
                                $res1visitcode = $res1['patientvisitcode'];
                                $res1patientfullname = $res1['patientname'];
                                $res1account = $res1['accountname'];
                                $res1consultationdate = $res1['consultationdate'];
                                $billnumber = $res1['billnumber'];
                                $sno = $sno + 1;
                                
                                $query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
                                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res11 = mysqli_fetch_array($exec11);
                                $res11age = $res11['age'];
                                $res11gender = $res11['gender'];
                                
                                $query111 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
                                $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res111 = mysqli_fetch_array($exec111);
                                $res111consultingdoctor = $res111['consultingdoctor'];
                                $res1111department = $res111['departmentname'];
                                
                                // Check if patient is external
                                if($res1patientcode == 'walkin') {
                                    $query11 = "select * from billing_external where billno='$billnumber'";
                                    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res11 = mysqli_fetch_array($exec11);
                                    $res11age = $res11['age'];
                                    $res11gender = $res11['gender'];
                                    $res1111department = 'External';
                                    $res1visitcode = $res1['billnumber'];
                                }
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1);
                                
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = 'bgcolor="#ecf0f5"';
                                }
                                
                                $query822 = "select * from transaction_stock where patientcode='$res1patientcode' and locationcode='$locationcode' and patientvisitcode='$res1visitcode' and description='Process' ";
                                $exec822 = mysqli_query($GLOBALS["___mysqli_ston"], $query822) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num822 = mysqli_num_rows($exec822);
                            ?>
                            <tr <?php echo $colorcode; ?> class="showdocument" id="<?php echo $sno; ?>">
                                <td class="sno-cell"><?php echo $sno; ?></td>
                                <td class="date-cell"><?php echo htmlspecialchars($res1consultationdate); ?></td>
                                <td class="code-cell"><?php echo htmlspecialchars($res1patientcode); ?></td>
                                <td class="code-cell"><?php echo htmlspecialchars($res1visitcode); ?></td>
                                <td class="name-cell"><?php echo htmlspecialchars($res1patientfullname); ?></td>
                                <td class="age-cell"><?php echo htmlspecialchars($res11age); ?></td>
                                <td class="gender-cell"><?php echo htmlspecialchars($res11gender); ?></td>
                                <td class="dept-cell"><?php echo htmlspecialchars($res1111department); ?></td>
                                <td class="account-cell"><?php echo htmlspecialchars($res1account); ?></td>
                                <td class="action-cell">
                                    <img id="toggleimg" src="images/plus1.gif" width="13" height="13" alt="Expand">
                                </td>
                            </tr>
                            
                            <!-- Expandable Service Details -->
                            <tr id='show<?php echo $sno; ?>' style="display: none;">
                                <td colspan="10">
                                    <div class="service-details">
                                        <h4>Service Details</h4>
                                        <table class="service-table">
                                            <thead>
                                                <tr>
                                                    <th>Service Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sno11 = '';
                                                $totalamount = 0;
                                                
                                                $query61 = "select * from consultation_services where paymentstatus='completed' and patientcode = '$res1patientcode' and patientvisitcode = '$res1visitcode' and process='pending' and servicerefund <> 'completed' and wellnessitem <> '1' and wellnesspkg ='1' and (billtype='PAY NOW' or (billtype='PAY LATER' ))";
                                                
                                                $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $numb = mysqli_num_rows($exec61);
                                                
                                                while($res61 = mysqli_fetch_array($exec61)) {
                                                    $serviceqty = $res61["serviceqty"];
                                                    $refnumber = $res61['refno'];
                                                    $service_item_code = $res61['servicesitemcode'];
                                                    $servicename = $res61["servicesitemname"];
                                                    $billtype = $res61["billtype"];
                                                    $refno = $res61['auto_number'];
                                                    
                                                    $query68 = "select * from master_services where itemname='$servicename'";
                                                    $exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68);
                                                    $res68 = mysqli_fetch_array($exec68);
                                                    $itemcode = $res68['itemcode'];
                                                    $sno11 = $sno11 + 1;
                                                ?>
                                                <tr>
                                                    <td class="service-name"><?php echo htmlspecialchars($servicename); ?></td>
                                                    <td class="service-action">
                                                        <?php if($res1patientcode != 'walkin'): ?>
                                                            <a class="executelink btn btn-primary btn-small" 
                                                               href="oppackageexecution.php?patientcode=<?php echo urlencode($res1patientcode); ?>&&visitcode=<?php echo urlencode($res1visitcode); ?>&&refnumber=<?php echo urlencode($refno); ?>&&servicesitemcode=<?php echo urlencode($service_item_code); ?>">
                                                                <i class="fas fa-play"></i> Execute
                                                            </a>
                                                        <?php else: ?>
                                                            <a class="executelink btn btn-primary btn-small" 
                                                               href="oppackageexecution.php?patientcode=<?php echo urlencode($res1patientcode); ?>&&visitcode=<?php echo urlencode($res1visitcode); ?>&&refnumber=<?php echo urlencode($refno); ?>&&servicesitemcode=<?php echo urlencode($service_item_code); ?>">
                                                                <i class="fas fa-play"></i> Execute
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                            
                            <!-- Similar queries for other payment types would go here -->
                            <!-- PAY LATER completed packages -->
                            <?php
                            $query2 = "select * from consultation_services where locationcode = '".$locationcode."' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and billtype='PAY LATER' and process='pending' and servicerefund <> 'completed' and consultationdate between '$fromdate' and '$todate' and wellnessitem <> '1' and wellnesspkg ='1' group by patientvisitcode order by consultationdate desc";
                            
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $res2patientcode = $res2['patientcode'];
                                $res2visitcode = $res2['patientvisitcode'];
                                $res2patientfullname = $res2['patientname'];
                                $res2account = $res2['accountname'];
                                $res2consultationdate = $res2['consultationdate'];
                                $sno = $sno + 1;
                                
                                $query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";
                                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res12 = mysqli_fetch_array($exec12);
                                $res12age = $res12['age'];
                                $res12gender = $res12['gender'];
                                
                                $query112 = "select * from master_visitentry where patientcode = '$res2patientcode' ";
                                $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res112 = mysqli_fetch_array($exec112);
                                $res1112department = $res112['departmentname'];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1);
                                
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = 'bgcolor="#ecf0f5"';
                                }
                                
                                $query822 = "select * from transaction_stock where patientcode='$res2patientcode' and locationcode='$locationcode' and patientvisitcode='$res2visitcode' and description='Process' ";
                                $exec822 = mysqli_query($GLOBALS["___mysqli_ston"], $query822) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num822 = mysqli_num_rows($exec822);
                            ?>
                            <tr <?php echo $colorcode; ?> class="showdocument" id="<?php echo $sno; ?>">
                                <td class="sno-cell"><?php echo $sno; ?></td>
                                <td class="date-cell"><?php echo htmlspecialchars($res2consultationdate); ?></td>
                                <td class="code-cell"><?php echo htmlspecialchars($res2patientcode); ?></td>
                                <td class="code-cell"><?php echo htmlspecialchars($res2visitcode); ?></td>
                                <td class="name-cell"><?php echo htmlspecialchars($res2patientfullname); ?></td>
                                <td class="age-cell"><?php echo htmlspecialchars($res12age); ?></td>
                                <td class="gender-cell"><?php echo htmlspecialchars($res12gender); ?></td>
                                <td class="dept-cell"><?php echo htmlspecialchars($res1112department); ?></td>
                                <td class="account-cell"><?php echo htmlspecialchars($res2account); ?></td>
                                <td class="action-cell">
                                    <img id="toggleimg" src="images/plus1.gif" width="13" height="13" alt="Expand">
                                </td>
                            </tr>
                            
                            <!-- Expandable Service Details for PAY LATER -->
                            <tr id='show<?php echo $sno; ?>' style="display: none;">
                                <td colspan="10">
                                    <div class="service-details">
                                        <h4>Service Details</h4>
                                        <table class="service-table">
                                            <thead>
                                                <tr>
                                                    <th>Service Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sno11 = '';
                                                $totalamount = 0;
                                                
                                                $query61 = "select * from consultation_services where paymentstatus='completed' and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and process='pending' and servicerefund <> 'completed' and wellnessitem <> '1' and wellnesspkg ='1' and (billtype='PAY NOW' or (billtype='PAY LATER' ))";
                                                
                                                $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $numb = mysqli_num_rows($exec61);
                                                
                                                while($res61 = mysqli_fetch_array($exec61)) {
                                                    $serviceqty = $res61["serviceqty"];
                                                    $refnumber = $res61['refno'];
                                                    $service_item_code = $res61['servicesitemcode'];
                                                    $servicename = $res61["servicesitemname"];
                                                    $billtype = $res61["billtype"];
                                                    $refno = $res61['auto_number'];
                                                    
                                                    $query68 = "select * from master_services where itemname='$servicename'";
                                                    $exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68);
                                                    $res68 = mysqli_fetch_array($exec68);
                                                    $itemcode = $res68['itemcode'];
                                                    $sno11 = $sno11 + 1;
                                                ?>
                                                <tr>
                                                    <td class="service-name"><?php echo htmlspecialchars($servicename); ?></td>
                                                    <td class="service-action">
                                                        <?php if($res2patientcode != 'walkin'): ?>
                                                            <a class="executelink btn btn-primary btn-small" 
                                                               href="oppackageexecution.php?patientcode=<?php echo urlencode($res2patientcode); ?>&&visitcode=<?php echo urlencode($res2visitcode); ?>&&refnumber=<?php echo urlencode($refno); ?>&&servicesitemcode=<?php echo urlencode($service_item_code); ?>">
                                                                <i class="fas fa-play"></i> Execute
                                                            </a>
                                                        <?php else: ?>
                                                            <a class="executelink btn btn-primary btn-small" 
                                                               href="oppackageexecution.php?patientcode=<?php echo urlencode($res2patientcode); ?>&&visitcode=<?php echo urlencode($res2visitcode); ?>&&refnumber=<?php echo urlencode($refno); ?>&&servicesitemcode=<?php echo urlencode($service_item_code); ?>">
                                                                <i class="fas fa-play"></i> Execute
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/oppackageprocesslist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
