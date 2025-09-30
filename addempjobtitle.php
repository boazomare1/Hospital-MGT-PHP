<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$docno = $_SESSION['docno'];

$query = "select * from master_location where  status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if($location!='') {
    $locationcode=$location;
}

//location get end here

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $jobtitle = $_REQUEST["jobtitle"];
    $jobtitle = strtoupper($jobtitle);
    $jobtitle = trim($jobtitle);
    $length=strlen($jobtitle);

    $query1 = "select locationname from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);

    $locationname = $res1["locationname"];	
    $serunit = $_REQUEST['serunit'];				

    $query1 = "insert into master_jobtitle (jobtitle, ipaddress, recorddate, username,locationcode,locationname) 
    values ('$jobtitle', '$ipaddress', '$updatedatetime', '$username','".$locationcode."','".$locationname."')";

    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

    $errmsg = "Success. New Department Updated.";
    $bgcolorcode = 'success';

    header('location:addempjobtitle.php');
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_jobtitle set recordstatus = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_jobtitle set recordstatus = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry') {
    $errmsg = "Please Add Department To Proceed For Billing.";
    $bgcolorcode = 'failed';
}

// Pagination logic
$records_per_page = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page); // Ensure page is at least 1

// Calculate offset
$offset = ($current_page - 1) * $records_per_page;

// Get total count for active records
$count_query = "select count(*) as total from master_jobtitle where recordstatus <> 'deleted'";
$count_exec = mysqli_query($GLOBALS["___mysqli_ston"], $count_query) or die ("Error in Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));
$count_res = mysqli_fetch_array($count_exec);
$total_records = $count_res['total'];
$total_pages = ceil($total_records / $records_per_page);

// Get total count for deleted records
$count_query_deleted = "select count(*) as total from master_jobtitle where recordstatus = 'deleted'";
$count_exec_deleted = mysqli_query($GLOBALS["___mysqli_ston"], $count_query_deleted) or die ("Error in Count Query Deleted".mysqli_error($GLOBALS["___mysqli_ston"]));
$count_res_deleted = mysqli_fetch_array($count_exec_deleted);
$total_records_deleted = $count_res_deleted['total'];
$total_pages_deleted = ceil($total_records_deleted / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee Job Title - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/addempjobtitle-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
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
    
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Add Employee Job Title</span>
    </nav>
    
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="main-container-with-sidebar">
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
                        <a href="addempjobtitle.php" class="nav-link active">
                            <i class="fas fa-user-tag"></i>
                            <span>Job Titles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addempdepartment.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Departments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployee.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemprole.php" class="nav-link">
                            <i class="fas fa-user-shield"></i>
                            <span>Roles</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="alert-container">
                <?php if($errmsg != "") { ?>
                <div class="alert alert-<?php echo ($bgcolorcode == 'success') ? 'success' : (($bgcolorcode == 'failed') ? 'error' : 'info'); ?>">
                    <i class="fas fa-<?php echo ($bgcolorcode == 'success') ? 'check-circle' : (($bgcolorcode == 'failed') ? 'exclamation-circle' : 'info-circle'); ?>"></i>
                    <?php echo $errmsg; ?>
                </div>
                <?php } ?>
            </div>
            
            <div class="page-header">
                <div class="page-header-content">
                    <h2>👔 Employee Job Title Master</h2>
                    <p>Manage employee job titles and designations</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-success" onclick="addNewJobTitle()">
                        <i class="fas fa-plus"></i> Add New
                    </button>
                </div>
            </div>
            
            <div class="form-container">
                <div class="form-header">
                    <h3><i class="fas fa-plus-circle"></i> Add New Job Title</h3>
                </div>
                <form name="form1" id="form1" method="post" action="addempjobtitle.php" onSubmit="return addward1process1()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jobtitle">Job Title *</label>
                            <input type="text" name="jobtitle" id="jobtitle" class="form-control" style="text-transform:uppercase;" placeholder="Enter job title" required>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <div class="form-control" style="background: #f8fafc; font-weight: 600; color: #1e40af;" id="ajaxlocation">
                                <strong>Location: </strong>
                                <?php
                                if ($location!='') { 
                                    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res12 = mysqli_fetch_array($exec12);
                                    echo $res1location = $res12["locationname"];
                                } else {
                                    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res1 = mysqli_fetch_array($exec1);
                                    echo $res1location = $res1["locationname"];
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="serunit" id="serunit" value="1">
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-outline">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">Action</th>
                            <th>Job Title</th>
                            <th width="10%">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "select * from master_jobtitle where recordstatus <> 'deleted' order by jobtitle LIMIT $records_per_page OFFSET $offset";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $jobtitle = $res1["jobtitle"];
                            $auto_number = $res1["auto_number"];
                            $locationname = $res1['locationname'];

                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                            if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                            } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                            }
                        ?>
                        <tr <?php echo $colorcode; ?>>
                            <td align="center">
                                <button class="btn btn-danger btn-sm" onclick="deleteJobTitle('<?php echo $auto_number; ?>', '<?php echo htmlspecialchars($jobtitle); ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            <td><?php echo htmlspecialchars($jobtitle); ?></td>
                            <td>
                                <button class="btn btn-outline btn-sm" onclick="editJobTitle('<?php echo $auto_number; ?>')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination for Active Records -->
            <?php if ($total_pages > 1) { ?>
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing <?php echo min($offset + 1, $total_records); ?>-<?php echo min($offset + $records_per_page, $total_records); ?> of <?php echo $total_records; ?> active records
                </div>
                <div class="pagination-controls">
                    <?php if ($current_page > 1) { ?>
                    <a href="?page=<?php echo $current_page - 1; ?>" class="pagination-btn">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                    <?php } else { ?>
                    <span class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </span>
                    <?php } ?>
                    
                    <?php
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);
                    
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        if ($i == $current_page) {
                            echo '<span class="pagination-btn active">' . $i . '</span>';
                        } else {
                            echo '<a href="?page=' . $i . '" class="pagination-btn">' . $i . '</a>';
                        }
                    }
                    ?>
                    
                    <?php if ($current_page < $total_pages) { ?>
                    <a href="?page=<?php echo $current_page + 1; ?>" class="pagination-btn">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                    <?php } else { ?>
                    <span class="pagination-btn" disabled>
                        Next <i class="fas fa-chevron-right"></i>
                    </span>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="15%">Action</th>
                            <th>Job Title (Deleted)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "select * from master_jobtitle where recordstatus = 'deleted' order by jobtitle LIMIT $records_per_page OFFSET $offset";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $jobtitle = $res1["jobtitle"];
                            $auto_number = $res1["auto_number"];

                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                            if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                            } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                            }
                        ?>
                        <tr <?php echo $colorcode; ?>>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="activateJobTitle('<?php echo $auto_number; ?>')">
                                    <i class="fas fa-check"></i> Activate
                                </button>
                            </td>
                            <td><?php echo htmlspecialchars($jobtitle); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination for Deleted Records -->
            <?php if ($total_pages_deleted > 1) { ?>
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing <?php echo min($offset + 1, $total_records_deleted); ?>-<?php echo min($offset + $records_per_page, $total_records_deleted); ?> of <?php echo $total_records_deleted; ?> deleted records
                </div>
                <div class="pagination-controls">
                    <?php if ($current_page > 1) { ?>
                    <a href="?page=<?php echo $current_page - 1; ?>" class="pagination-btn">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                    <?php } else { ?>
                    <span class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </span>
                    <?php } ?>
                    
                    <?php
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages_deleted, $current_page + 2);
                    
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        if ($i == $current_page) {
                            echo '<span class="pagination-btn active">' . $i . '</span>';
                        } else {
                            echo '<a href="?page=' . $i . '" class="pagination-btn">' . $i . '</a>';
                        }
                    }
                    ?>
                    
                    <?php if ($current_page < $total_pages_deleted) { ?>
                    <a href="?page=<?php echo $current_page + 1; ?>" class="pagination-btn">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                    <?php } else { ?>
                    <span class="pagination-btn" disabled>
                        Next <i class="fas fa-chevron-right"></i>
                    </span>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>
    
    <script src="js/addempjobtitle-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>