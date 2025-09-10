<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/admissionlist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

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
                        <a href="admissionlist.php" class="nav-link active">
                            <i class="fas fa-user-plus"></i>
                            <span>Admission List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipbeddiscountlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Bed Discount</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbed.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Bed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancysummary.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Bed Occupancy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedtransferlist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Bed Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
<?php
?>
<!-- Modern page content structure -->
<div class="page-header">
    <h1 class="page-title">Admission List</h1>
    <p class="page-subtitle">Search and manage patient admissions</p>
</div>

<div class="filter-container">
    <h2 class="filter-header">Search Filters</h2>
    <form name="cbform1" method="post" action="admissionlist.php">
        <div class="filter-row">
            <div class="filter-group">
                <label for="ADate1">Date From:</label>
                <input type="date" name="ADate1" id="ADate1" class="form-control" value="<?php echo $transactiondatefrom; ?>">
            </div>
            <div class="filter-group">
                <label for="ADate2">Date To:</label>
                <input type="date" name="ADate2" id="ADate2" class="form-control" value="<?php echo $transactiondateto; ?>">
            </div>
            <div class="filter-group">
                <label for="location">Location:</label>
                <select name="location" id="location" class="form-control">
                    <option value="">All Locations</option>
                    <?php
                    $query4 = "select locationname, locationcode from master_location where status = ''";
                    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res4 = mysqli_fetch_array($exec4)) {
                        $res4locname = $res4['locationname'];
                        $res4loccode = $res4['locationcode'];
                        $selected = ($location == $res4loccode) ? 'selected' : '';
                        echo "<option value='$res4loccode' $selected>$res4locname</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="btn-group">
            <button type="submit" name="frmflag1" value="frmflag1" class="btn btn-primary">
                <i class="fas fa-search"></i> Search
            </button>
            <button type="reset" class="btn btn-secondary">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
    </form>
</div>
<!-- Results will be displayed here -->
<div class="table-container">
    <div class="search-container">
        <h3>Search Results</h3>
        <p>Use the filters above to search for admissions.</p>
    </div>
</div>
<?php
// Handle form submission and display results
if (isset($_POST["frmflag1"]) && $_POST["frmflag1"] == "frmflag1") {
    $fromdate = $_POST["ADate1"];
    $todate = $_POST["ADate2"];
    $location = $_POST["location"];
				
    // Query for admissions
    $query = "SELECT * FROM master_admission WHERE admissiondate BETWEEN '$fromdate' AND '$todate'";
    if ($location != '') {
        $query .= " AND locationcode = '$location'";
    }
    $query .= " ORDER BY admissiondate DESC";
    
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
    $num_rows = mysqli_num_rows($exec);
				
    if ($num_rows > 0) {
        echo '<div class="table-container">';
        echo '<table class="modern-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Admission ID</th>';
        echo '<th>Patient Name</th>';
        echo '<th>Admission Date</th>';
        echo '<th>Location</th>';
        echo '<th>Status</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        while ($res = mysqli_fetch_array($exec)) {
            echo '<tr>';
            echo '<td>' . $res['admissionid'] . '</td>';
            echo '<td>' . $res['patientname'] . '</td>';
            echo '<td>' . $res['admissiondate'] . '</td>';
            echo '<td>' . $res['locationname'] . '</td>';
            echo '<td><span class="status-badge status-active">Active</span></td>';
            echo '<td>';
            echo '<a href="#" class="action-btn view">View</a>';
            echo '<a href="#" class="action-btn edit">Edit</a>';
            echo '<a href="#" class="action-btn discharge">Discharge</a>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<div class="table-container">';
        echo '<div class="search-container">';
        echo '<h3>No Results Found</h3>';
        echo '<p>No admissions found for the selected criteria.</p>';
        echo '</div>';
        echo '</div>';
    }
}
?>
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed --> 
<!-- Old table structure removed --> 
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed --> 
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed -->
<!-- Old table structure removed --> 
<!-- Old table structure removed --> 
<!-- Old table structure removed -->
<!-- Old table structure removed --> 
<!-- Old table structure removed -->
<!-- Old table structure removed -->

        </main>
    </div>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 MedStar Hospital Management System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modern JavaScript -->
    <script src="js/admissionlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>