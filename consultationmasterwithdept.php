<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";  
$subtype = "";
$paymenttype = "";
$recorddate = "";

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }

if (isset($_REQUEST["searchdepartmentname"])) { $searchdepartmentname = $_REQUEST["searchdepartmentname"]; } else { $searchdepartmentname = ""; }
if (isset($_REQUEST["searchdepartmentcode"])) { $searchdepartmentcode = $_REQUEST["searchdepartmentcode"]; } else { $searchdepartmentcode = ""; }
if (isset($_REQUEST["searchdepartmentanum"])) { $searchdepartmentanum = $_REQUEST["searchdepartmentanum"]; } else { $searchdepartmentanum = ""; }

// Also get search parameters from GET for pagination
if (isset($_GET["searchsuppliername"])) { $searchsuppliername = $_GET["searchsuppliername"]; }
if (isset($_GET["searchsupplieranum"])) { $searchsupplieranum = $_GET["searchsupplieranum"]; }
if (isset($_GET["searchdepartmentname"])) { $searchdepartmentname = $_GET["searchdepartmentname"]; }
if (isset($_GET["searchdepartmentanum"])) { $searchdepartmentanum = $_GET["searchdepartmentanum"]; }

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $consultationtype = $_REQUEST["consultationtype"];
    $doctorcode = $_REQUEST["consultationdoctorcode"];
    $doctorname = $_REQUEST["consultationdoctorname"];
    $locationcode = $_REQUEST["location"];
    $department = $_REQUEST["department"];
    $consultationfees = $_REQUEST["consultationfees"];
    $default = isset($_REQUEST['default'])?$_REQUEST['default']:'';
    $paymenttype = $_REQUEST['paymenttype'];
    $subtype = $_REQUEST['subtype'];

    $consultationtype = strtoupper($consultationtype);
    $consultationtype = trim($consultationtype);
    $length=strlen($consultationtype);
    $loccode= explode('-',$locationcode);
    $location = $loccode[1];

    if ($length<=100) {
        $query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$consultationtype', '$department','$doctorcode','$doctorname','$consultationfees','$ipaddress','$recorddate', '$username','$location','$locationcode','".$default."','$paymenttype','$subtype')"; 
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $errmsg = "Success. New Consultation Type Updated.";
        $bgcolorcode = 'success';
    } else {
        $errmsg = "Failed. Only 100 Characters Are Allowed.";
        $bgcolorcode = 'failed';
    }
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_consultationtype set recordstatus = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_consultationtype set recordstatus = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'default') {
    $delanum = $_REQUEST["anum"];
    $query4 = "update master_consultationtype set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $query5 = "update master_consultationtype set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'removedefault') {
    $delanum = $_REQUEST["anum"];
    $query6 = "update master_consultationtype set defaultstatus = '' where auto_number = '$delanum'";
    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry') {
    $errmsg = "Please Add Consultation Type To Proceed For Billing.";
    $bgcolorcode = 'failed';
}

// Pagination variables
$records_per_page = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Debug pagination variables
echo "<!-- PAGINATION DEBUG START -->";
echo "<!-- Records per page: $records_per_page -->";
echo "<!-- Current page: $current_page -->";
echo "<!-- Offset: $offset -->";
echo "<!-- GET parameters: " . print_r($_GET, true) . " -->";
echo "<!-- POST parameters: " . print_r($_POST, true) . " -->";
echo "<!-- PAGINATION DEBUG END -->";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/consultationmasterwithdept-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- jQuery UI for autocomplete -->
    <link href="js/jquery-ui.css" rel="stylesheet">
    <script src="js/jquery-ui.js" type="text/javascript"></script>
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
        <span>Consultation Master</span>
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
                        <a href="addconsultationtype1.php" class="nav-link active">
                            <i class="fas fa-stethoscope"></i>
                            <span>Add Consultation Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationmasterwithdept.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Consultation List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="viewconsultationbills.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>View Consultation Bills</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if ($errmsg): ?>
                <div class="alert <?php echo $bgcolorcode == 'success' ? 'alert-success' : ($bgcolorcode == 'failed' ? 'alert-error' : ''); ?>">
                    <i class="fas fa-<?php echo $bgcolorcode == 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                    <?php echo $errmsg; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-stethoscope"></i> Consultation Master</h2>
                    <p>Create and manage consultation types with department-specific pricing and location-based fees.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Add New Consultation Type Form -->
            <div class="form-section">
                <div class="form-header">
                    <h3><i class="fas fa-plus-circle"></i> Add New Consultation Type</h3>
                    <div class="location-display" id="ajaxlocation">
                        <?php
                        $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res1 = mysqli_fetch_array($exec1);
                        echo $res1location = $res1["locationname"];
                        ?>
                    </div>
                </div>

                <form name="form1" id="form1" method="post" action="consultationmasterwithdept.php" onSubmit="return addward1process1()">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location">
                                <i class="fas fa-map-marker-alt"></i> Location
                            </label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-control" required>
                                <option value="" selected="selected">Select location</option>
                                <?php
                                $query6 = "select * from master_location where status = '' order by locationname";
                                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res6 = mysqli_fetch_array($exec6)) {
                                    $res6anum = $res6["auto_number"];
                                    $res6location = $res6["locationname"];
                                    $locationcode = $res6["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode; ?>"><?php echo $res6location; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="department">
                                <i class="fas fa-building"></i> Department
                            </label>
                            <select name="department" id="department" class="form-control" required>
                                <option value="" selected="selected">Select department</option>
                                <?php
                                $query5 = "select * from master_department where recordstatus = '' order by department";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res5 = mysqli_fetch_array($exec5)) {
                                    $res5anum = $res5["auto_number"];
                                    $res5department = $res5["department"];
                                ?>
                                <option value="<?php echo $res5anum; ?>"><?php echo $res5department; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="paymenttype">
                                <i class="fas fa-tag"></i> Main Type
                            </label>
                            <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();" class="form-control" required>
                                <option value="" selected="selected">Select Type</option>
                                <?php
                                $query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res5 = mysqli_fetch_array($exec5)) {
                                    $res5anum = $res5["auto_number"];
                                    $res5paymenttype = $res5["paymenttype"];
                                ?>
                                <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="subtype">
                                <i class="fas fa-list"></i> Sub Type
                            </label>
                            <select name="subtype" id="subtype" onChange="return funcSubTypeChange1()" class="form-control">
                                <?php
                                if ($subtype == '') {
                                    echo '<option value="" selected="selected">Select Subtype</option>';
                                } else {
                                    $query51 = "select * from master_subtype where recordstatus = ''";
                                    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res51 = mysqli_fetch_array($exec51);
                                    $res51subtype = $res51["subtype"];
                                    echo '<option value="'.$res51subtype.'" selected="selected">'.$res51subtype.'</option>';
                                }
                                
                                $query5 = "select * from master_subtype where recordstatus = '' order by subtype";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res5 = mysqli_fetch_array($exec5)) {
                                    $res5anum = $res5["auto_number"];
                                    $res5paymenttype = $res5["subtype"];
                                ?>
                                <option value="<?php echo $res5paymenttype; ?>"><?php echo $res5paymenttype; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="consultationtype">
                                <i class="fas fa-stethoscope"></i> Consultation Type
                            </label>
                            <input name="consultationtype" id="consultationtype" class="form-control" style="text-transform: uppercase;" placeholder="Enter consultation type" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="consultationdoctorname">
                                <i class="fas fa-user-md"></i> Consultation Doctor
                            </label>
                            <input type="text" name="consultationdoctorname" id="consultationdoctorname" class="form-control" autocomplete="off" placeholder="Enter doctor name" />
                            <input type="hidden" name="consultationdoctorcode" id="consultationdoctorcode" />
                        </div>

                        <div class="form-group">
                            <label for="consultationfees">
                                <i class="fas fa-dollar-sign"></i> Consultation Fees
                            </label>
                            <input name="consultationfees" type="text" id="consultationfees" class="form-control" placeholder="Enter fees" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="default">
                                <i class="fas fa-star"></i> Default
                            </label>
                            <div class="checkbox-wrapper">
                                <input name="default" type="checkbox" id="default" />
                                <label for="default" class="checkbox-label">Set as default consultation type</label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <input type="hidden" name="scrollfunc" id="scrollfunc" value="getdata">
                        <input type="hidden" name="serialno" id="serialno" value="50">
                        
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Submit
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-eraser"></i> Clear Form
                        </button>
                    </div>
                </form>
            </div>

            <!-- Search Form -->
            <div class="search-section">
                <div class="search-header">
                    <h3><i class="fas fa-search"></i> Search Consultation Types</h3>
                </div>
                
                <form name="form12" id="form12" method="post" action="consultationmasterwithdept.php">
                    <div class="search-grid">
                        <div class="form-group">
                            <label for="searchsuppliername">Subtype</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" class="form-control" autocomplete="off" onKeyUP="clearsubtypecode()" placeholder="Search by subtype">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" />
                            <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" />
                        </div>
                        
                        <div class="form-group">
                            <label for="searchdepartmentname">Department</label>
                            <input name="searchdepartmentname" type="text" id="searchdepartmentname" value="<?php echo $searchdepartmentname; ?>" class="form-control" onKeyUP="cleardepartmentcode()" autocomplete="off" placeholder="Search by department">
                            <input type="hidden" name="searchdepartmentcode" id="searchdepartmentcode" value="<?php echo $searchdepartmentcode; ?>" />
                            <input type="hidden" name="searchdepartmentanum" id="searchdepartmentanum" value="<?php echo $searchdepartmentanum; ?>" />
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" name="frmflag2" value="search" />
                            <input type="hidden" name="frmflag12" value="frmflag12" />
                            <button type="submit" name="search" class="btn btn-secondary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Table -->
            <div class="table-section">
                <div class="table-header">
                    <h3><i class="fas fa-list"></i> Consultation Types</h3>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Location</th>
                                <th>Consultation Type</th>
                                <th>Department</th>
                                <th>Main Type</th>
                                <th>Sub Type</th>
                                <th>Doctor Name</th>
                                <th>Doctor Code</th>
                                <th>Consultation Fees</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody id='insertplan'>
                            <?php
                            // Simplified base query - let's start simple
                            $base_query = "select * from master_consultationtype where recordstatus <> 'deleted'";
                            
                            // Add search filters if they exist
                            if($searchsupplieranum != '' || $searchdepartmentanum != '') {
                                if($searchdepartmentanum != '') {
                                    $base_query .= " and department = '$searchdepartmentanum'";
                                }
                                if($searchsupplieranum != '') {
                                    $base_query .= " and subtype = '$searchsupplieranum'";
                                }
                            }
                            
                            // Get total count for pagination
                            $count_query = str_replace("select *", "select COUNT(*) as total", $base_query);
                            echo "<!-- Count Query: $count_query -->";
                            
                            $count_exec = mysqli_query($GLOBALS["___mysqli_ston"], $count_query) or die ("Error in Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $count_result = mysqli_fetch_array($count_exec);
                            $total_records = $count_result['total'];
                            $total_pages = ceil($total_records / $records_per_page);

                            // Build the paginated query - FORCE LIMIT TO 5
                            $query1 = $base_query . " order by paymenttype LIMIT $offset, $records_per_page";
                            echo "<!-- Main Query: $query1 -->";
                            echo "<!-- FORCING LIMIT: $records_per_page records starting from offset: $offset -->";
                            
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            // Additional check - let's see if the query actually executed
                            if (!$exec1) {
                                echo "<!-- ERROR: Query failed to execute -->";
                            } else {
                                echo "<!-- SUCCESS: Query executed successfully -->";
                            }
                            
                            // Debug: Let's see what's happening
                            echo "<!-- Debug: Total records: $total_records, Current page: $current_page, Offset: $offset, Records per page: $records_per_page, Total pages: $total_pages -->";
                            echo "<!-- Debug: Search supplier anum: '$searchsupplieranum', Search department anum: '$searchdepartmentanum' -->";

                            $record_count = 0;
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $record_count++;
                                echo "<!-- Processing record $record_count -->";
                                $auto_number = $res1["auto_number"];  
                                $consultationtype = $res1["consultationtype"];
                                $departmentanum = $res1["department"];
                                $consultationfees = $res1["consultationfees"];
                                $res1paymenttype = $res1["paymenttype"];
                                $res1subtype = $res1['subtype'];
                                $res1location = $res1['locationname']; 
                                $res1doctorcode = $res1['doctorcode'];
                                $res1doctor = $res1['doctorname'];

                                $query = "select * from master_location where auto_number='$res1location'";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res = mysqli_fetch_array($exec);
                                $loc=$res['locationname'];

                                $query2 = "select * from master_department where auto_number = '$departmentanum'";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res2 = mysqli_fetch_array($exec2);
                                $department = $res2['department'];

                                $query3 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res3 = mysqli_fetch_array($exec3);
                                $res3paymenttype = $res3['paymenttype'];

                                $query4 = "select * from master_subtype where auto_number = '$res1subtype'";
                                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res4 = mysqli_fetch_array($exec4);
                                $res4subtype = $res4['subtype'];
                            ?>
                            <tr>
                                <td>
                                    <a href="consultationmasterwithdept.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteconsultationtype1('<?php echo $consultationtype;?>')" class="action-link delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                                <td><?php echo $loc; ?></td>
                                <td><?php echo $consultationtype; ?></td>
                                <td><?php echo $department; ?></td>
                                <td><?php echo $res3paymenttype; ?></td>
                                <td><?php echo $res4subtype; ?></td>
                                <td><?php echo $res1doctor; ?></td>
                                <td><?php echo $res1doctorcode; ?></td>
                                <td><?php echo $consultationfees; ?></td>
                                <td>
                                    <a href="editconsultationtype1.php?st=edit&&anum=<?php echo $auto_number; ?>" class="action-link">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php echo "<!-- Total records displayed: $record_count -->"; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Controls -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $records_per_page, $total_records); ?> of <?php echo $total_records; ?> records
                    </div>
                    
                    <div class="pagination-controls">
                        <?php if ($current_page > 1): ?>
                            <a href="?page=1<?php echo $searchsupplieranum ? '&searchsupplieranum=' . $searchsupplieranum : ''; ?><?php echo $searchdepartmentanum ? '&searchdepartmentanum=' . $searchdepartmentanum : ''; ?><?php echo $searchsuppliername ? '&searchsuppliername=' . urlencode($searchsuppliername) : ''; ?><?php echo $searchdepartmentname ? '&searchdepartmentname=' . urlencode($searchdepartmentname) : ''; ?>" class="btn btn-outline">
                                <i class="fas fa-angle-double-left"></i> First
                            </a>
                            <a href="?page=<?php echo $current_page - 1; ?><?php echo $searchsupplieranum ? '&searchsupplieranum=' . $searchsupplieranum : ''; ?><?php echo $searchdepartmentanum ? '&searchdepartmentanum=' . $searchdepartmentanum : ''; ?><?php echo $searchsuppliername ? '&searchsuppliername=' . urlencode($searchsuppliername) : ''; ?><?php echo $searchdepartmentname ? '&searchdepartmentname=' . urlencode($searchdepartmentname) : ''; ?>" class="btn btn-outline">
                                <i class="fas fa-angle-left"></i> Previous
                            </a>
                        <?php endif; ?>
                        
                        <div class="pagination-numbers">
                            <?php
                            $start_page = max(1, $current_page - 2);
                            $end_page = min($total_pages, $current_page + 2);
                            
                            for ($i = $start_page; $i <= $end_page; $i++):
                            ?>
                                <a href="?page=<?php echo $i; ?><?php echo $searchsupplieranum ? '&searchsupplieranum=' . $searchsupplieranum : ''; ?><?php echo $searchdepartmentanum ? '&searchdepartmentanum=' . $searchdepartmentanum : ''; ?><?php echo $searchsuppliername ? '&searchsuppliername=' . urlencode($searchsuppliername) : ''; ?><?php echo $searchdepartmentname ? '&searchdepartmentname=' . urlencode($searchdepartmentname) : ''; ?>" 
                                   class="pagination-number <?php echo $i == $current_page ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                        
                        <?php if ($current_page < $total_pages): ?>
                            <a href="?page=<?php echo $current_page + 1; ?><?php echo $searchsupplieranum ? '&searchsupplieranum=' . $searchsupplieranum : ''; ?><?php echo $searchdepartmentanum ? '&searchdepartmentanum=' . $searchdepartmentanum : ''; ?><?php echo $searchsuppliername ? '&searchsuppliername=' . urlencode($searchsuppliername) : ''; ?><?php echo $searchdepartmentname ? '&searchdepartmentname=' . urlencode($searchdepartmentname) : ''; ?>" class="btn btn-outline">
                                Next <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?page=<?php echo $total_pages; ?><?php echo $searchsupplieranum ? '&searchsupplieranum=' . $searchsupplieranum : ''; ?><?php echo $searchdepartmentanum ? '&searchdepartmentanum=' . $searchdepartmentanum : ''; ?><?php echo $searchsuppliername ? '&searchsuppliername=' . urlencode($searchsuppliername) : ''; ?><?php echo $searchdepartmentname ? '&searchdepartmentname=' . urlencode($searchdepartmentname) : ''; ?>" class="btn btn-outline">
                                Last <i class="fas fa-angle-double-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Deleted Items Section -->
            <?php
            $query1 = "select * from master_consultationtype where recordstatus = 'deleted' and department Like '%$searchdepartmentanum%' and subtype Like '%$searchsupplieranum%'  order by consultationtype ";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            if (mysqli_num_rows($exec1) > 0): ?>
            <div class="table-section">
                <div class="table-header">
                    <h3><i class="fas fa-archive"></i> Deleted Consultation Types</h3>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Consultation Type</th>
                                <th>Department</th>
                                <th>Consultation Fees</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $auto_number = $res1["auto_number"];
                                $consultationtype = $res1["consultationtype"];
                                $departmentanum = $res1["department"];
                                $consultationfees = $res1["consultationfees"];
                                
                                $query2 = "select * from master_department where auto_number = '$departmentanum'";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res2 = mysqli_fetch_array($exec2);
                                $department = $res2['department'];
                            ?>
                            <tr>
                                <td>
                                    <a href="consultationmasterwithdept.php?st=activate&&anum=<?php echo $auto_number; ?>" class="action-link">
                                        <i class="fas fa-undo"></i> Activate
                                    </a>
                                </td>
                                <td><?php echo $consultationtype; ?></td>
                                <td><?php echo $department; ?></td>
                                <td><?php echo $consultationfees; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
    // Sidebar toggle functionality
    document.getElementById('menuToggle').addEventListener('click', function() {
        const sidebar = document.getElementById('leftSidebar');
        const mainContent = document.querySelector('.main-content');
        
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    });

    document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.getElementById('leftSidebar');
        const mainContent = document.querySelector('.main-content');
        
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    });

    // Form validation
    function addward1process1() {
        if (document.form1.location.value == "") {
            alert("Please Select Location.");
            document.form1.location.focus();
            return false;
        }
        
        if (document.form1.department.value == "") {
            alert("Please Select Department.");
            document.form1.department.focus();
            return false;
        }
        
        if (document.form1.consultationtype.value == "") {
            alert("Please Enter Consultation Type Name.");
            document.form1.consultationtype.focus();
            return false;
        }
        
        if (document.form1.consultationfees.value == "") {
            alert("Please Enter Consultation Fees.");
            document.form1.consultationfees.focus();
            return false;
        }
    }

    function funcDeleteconsultationtype1(varConsultationTypeAutoNumber) {
        var fRet = confirm('Are you sure want to delete this Consultation Type '+varConsultationTypeAutoNumber+'?');
        if (fRet == true) {
            alert("Consultation Type Entry Delete Completed.");
        } else {
            alert("Consultation Type Entry Delete Not Completed.");
            return false;
        }
    }

    function clearForm() {
        document.getElementById('form1').reset();
    }

    function refreshPage() {
        window.location.reload();
    }

    // Clear functions for search fields
    function cleardepartmentcode() {
        document.getElementById("searchdepartmentanum").value = '';
    }

    function clearsubtypecode() {
        document.getElementById("searchsupplieranum").value = '';
    }

    // Autocomplete functionality
    $(function() {
        $('#consultationdoctorname').autocomplete({
            source:'ajaxdoctornamesearch.php', 
            html: true, 
            select: function(event,ui){
                var medicine = ui.item.value;
                var doctorcode = ui.item.doctorcode;
                $('#consultationdoctorcode').val(doctorcode);
                $('#consultationdoctorname').val(medicine);
            },
        });

        $('#searchsuppliername').autocomplete({
            source:"ajaxaccountsub_search.php",
            matchContains: true,
            minLength:1,
            html: true, 
            select: function(event,ui){
                var accountname=ui.item.value;
                var accountid=ui.item.id;
                var accountanum=ui.item.anum;
                $("#searchsuppliercode").val(accountid);
                $("#searchsupplieranum").val(accountanum);
                $('#searchsuppliername').val(accountname);
            },
        });

        $('#searchdepartmentname').autocomplete({
            source:"ajaxdepartment_search.php",
            matchContains: true,
            minLength:1,
            html: true, 
            select: function(event,ui){
                var accountname=ui.item.value;
                var accountid=ui.item.id;
                var accountanum=ui.item.anum;
                $("#searchdepartmentcode").val(accountid);
                $("#searchdepartmentanum").val(accountanum);
                $('#searchdepartmentname').val(accountname);
            },
        });
    });

    // Scroll loading functionality
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
            var hiddenplansearch = "";
            var scrollfunc = $("#scrollfunc").val();
            $("#scrollfunc").val('');
            var sortfiled = '';
            var sortfunc = '';
            
            if(sortfunc=='asc') {
                sortfunc='desc'
            } else {
                sortfunc='asc'
            }
            
            if(hiddenplansearch=='') {
                if(scrollfunc=='getdata') {
                    var serialno = $("#serialno").val();
                    var search_dept_anum = $("#searchdepartmentanum").val();
                    var search_supplr_anum = $("#searchsupplieranum").val();
                    var dataString = 'serialno='+serialno+'&&action=scrollplanfunction&&textid='+sortfiled+'&&sortfunc='+sortfunc+'&&searchdepartmentanum='+search_dept_anum+'&&searchsupplieranum='+search_supplr_anum;
                    
                    $.ajax({
                        type: "POST",
                        url: "ajax/consultationtypedata.php",
                        data: dataString,
                        cache: true,
                        success: function(html){
                            serialno = parseFloat(serialno)+50;
                            $("#insertplan").append(html);
                            $("#serialno").val(serialno);
                            $("#scrollfunc").val('getdata');
                        }
                    });
                }
            }
        }
    });
    </script>
</body>
</html>