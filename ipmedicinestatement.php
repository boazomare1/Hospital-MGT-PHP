<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$docno = $_SESSION['docno'];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if($location != '') {
    $locationcode = $location;
}

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

if ($frmflag2 == 'frmflag2') {
    $itemname = $_REQUEST['itemname'];
    $itemcode = $_REQUEST['itemcode'];
    $adjustmentdate = date('Y-m-d');
    
    foreach($_POST['batch'] as $key => $value) {
        $batchnumber = $_POST['batch'][$key];
        $addstock = $_POST['addstock'][$key];
        $minusstock = $_POST['minusstock'][$key];
        
        $query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
        $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res40 = mysqli_fetch_array($exec40);
        $itemmrp = $res40['rateperunit'];
        
        $itemsubtotal = $itemmrp * $addstock;
        
        if($addstock != '') {
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
            transactionparticular, billautonumber, billnumber, quantity, remarks, 
            username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber, locationcode)
            values ('$itemcode', '$itemname', '$adjustmentdate', 'IP Drug Intake', 
            'IP Drug Intake', '0', '0', '$addstock', 'IP Drug Intake', 
            '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber', '$locationcode')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die ("Error in Query65".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
        
        if($minusstock != '') {
            $query66 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
            transactionparticular, billautonumber, billnumber, quantity, remarks, 
            username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber, locationcode)
            values ('$itemcode', '$itemname', '$adjustmentdate', 'IP Drug Intake', 
            'IP Drug Intake', '0', '0', '-$minusstock', 'IP Drug Intake', 
            '$username', '$ipaddress', '$itemmrp', '-$itemsubtotal', '$companyanum', '$companyname', '$batchnumber', '$locationcode')";
            $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    
    $errmsg = "Drug intake updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Medicine Statement - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipmedicinestatement-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <script language="javascript">
    function cbsuppliername1() {
        document.cbform1.submit();
    }

    function disableEnterKey(varPassed) {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
        
        var key;
        if(window.event) {
            key = window.event.keyCode;     //IE
        } else {
            key = e.which;     //firefox
        }
        
        if(key == 13) // if enter key press
        {
            return false;
        } else {
            return true;
        }
    }

    function process1backkeypress1() {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
    }
    </script>
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
        <span>IP Medicine Statement</span>
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
                        <a href="ipdischargelist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargerequestlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Discharge Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargelist_tat.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Discharge TAT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>% Discount List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Discount Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdocs.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>IP Documents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdrugconsumptionreport.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Drug Consumption Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdrugintake.php" class="nav-link">
                            <i class="fas fa-capsules"></i>
                            <span>Drug Intake</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipmedicinestatement.php" class="nav-link active">
                            <i class="fas fa-prescription"></i>
                            <span>Medicine Statement</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div class="alert-container">
                <?php include ("includes/alertmessages1.php"); ?>
                <?php if ($errmsg != "") { ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $errmsg; ?>
                </div>
                <?php } ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-prescription"></i> IP Medicine Statement</h2>
                    <p>Generate and manage medicine statements for inpatients</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Statement
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="ipmedicinestatement.php" class="search-form">
                    <div class="form-header">
                        <h3><i class="fas fa-search"></i> Search Parameters</h3>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchpatientname">Patient Name</label>
                            <input type="text" name="searchpatientname" id="searchpatientname" class="form-control" placeholder="Search by patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchitemname">Item Name</label>
                            <input type="text" name="searchitemname" id="searchitemname" class="form-control" placeholder="Search by item name">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1">Date From</label>
                            <input type="text" name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" class="form-control date-picker" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2">Date To</label>
                            <input type="text" name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" class="form-control date-picker" readonly>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag2" value="cbfrmflag2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Table -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <h3><i class="fas fa-table"></i> Medicine Statement Records</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem;">
                                    <i class="fas fa-search" style="font-size: 2rem; color: #ccc; margin-bottom: 1rem;"></i>
                                    <p>Search for medicine statement records using the form above</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipmedicinestatement-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
