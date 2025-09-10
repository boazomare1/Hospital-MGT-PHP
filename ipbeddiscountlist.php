<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Bed Discount List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipbeddiscountlist-modern.css?v=<?php echo time(); ?>">
    
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
                        <a href="admissionlist.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Admission List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipbeddiscountlist.php" class="nav-link active">
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
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')
{
    
	$snos=$_REQUEST['sno'];
	for($key=0;$key<$snos;$key++) {

		$bedallocationid=$_REQUEST['bedallocationid'][$key];
		$visitcode=$_REQUEST['visitcode'][$key];
		$discount=$_REQUEST['discount'][$key];
		$newrate=$_REQUEST['newrate'][$key];
		$notes=$_REQUEST['notes'][$key];
		$types=$_REQUEST['frmtable'][$key];

		$updatedatetime = date ("Y-m-d H:i:s");
        if($discount>0) {
          if($types=='allcation'){
			$query21 = "select visitcode,auto_number from ip_bedallocation where  auto_number='$bedallocationid' and visitcode='$visitcode'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num21 = mysqli_num_rows($exec21);
			if($num21>0) {
			
			$query64 = "update ip_bedallocation set discount_amt='$discount',discount_notes='$notes',discount_approved_user='$username',discount_date='$updatedatetime' where auto_number='$bedallocationid' and visitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   }
			
		  }else{
            $query21 = "select visitcode,auto_number from ip_bedtransfer where  auto_number='$bedallocationid' and visitcode='$visitcode'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num21 = mysqli_num_rows($exec21);
			if($num21>0) {
			
			$query64 = "update ip_bedtransfer set discount_amt='$discount',discount_notes='$notes',discount_approved_user='$username',discount_date='$updatedatetime' where auto_number='$bedallocationid' and visitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   }
		
		  }
		
		
	}
	}
	
	//	header("location:ipbeddiscountlist.php?st=1");
	//	exit;

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
$errmsg ='';
if ($st == '1')
{
	$errmsg = "Success.  Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Not Completed.";
}

include ("autocompletebuild_customeripbilling.php");
?>
<!-- Inline styles moved to external CSS file -->

<!-- External JavaScript files moved to head section -->

<!-- Inline JavaScript moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->




<!-- JavaScript functions moved to external JS file -->

<!-- JavaScript functions moved to external JS file -->



<!-- Inline JavaScript moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->


<!-- JavaScript functions moved to external JS file -->

<!-- JavaScript functions moved to external JS file -->

<!-- JavaScript functions moved to external JS file -->
<!-- Inline JavaScript moved to external JS file -->

<!-- Inline JavaScript moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->

<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->

<!-- Modern page content structure -->
<div class="page-header">
    <h1 class="page-title">IP Bed Discount List</h1>
    <p class="page-subtitle">Manage bed discount rates and patient billing</p>
</div>

<div class="filter-container">
    <h2 class="filter-header">Search Filters</h2>
    <form name="cbform1" method="post" action="ipbeddiscountlist.php">
        <div class="filter-row">
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
            <div class="filter-group">
                <label for="patientsearch">Patient Search:</label>
                <input type="text" name="patientsearch" id="patientsearch" class="form-control" placeholder="Enter patient name or ID">
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
        <h3>Bed Discount Results</h3>
        <p>Use the filters above to search for bed discount information.</p>
    </div>
</div>
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
    <script src="js/ipbeddiscountlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>


