<?php
session_start();
ob_start();

include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

date_default_timezone_set('Asia/Calcutta');

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
if ($location != '') {
    $locationcode = $location;
}

// Handle form submission
if (isset($_REQUEST["cbfrmflag2"])) { 
    $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; 
} else { 
    $cbfrmflag2 = ""; 
}

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

if ($frmflag2 == 'frmflag2') {
    $itemname = $_REQUEST['itemname'];
    $itemcode = $_REQUEST['itemcode'];
    $adjustmentdate = date('Y-m-d');
    
    foreach($_POST['batch'] as $key => $value) {
        $batchnumber = $_POST['batch'][$key];
        $addstock = $_POST['addstock'][$key];
        $minusstock = $_POST['minusstock'][$key];
        
        $query40 = "SELECT * FROM master_itempharmacy WHERE itemcode = '$itemcode'";
        $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die("Error in Query40: " . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res40 = mysqli_fetch_array($exec40);
        $itemmrp = $res40['rateperunit'];
        $itemsubtotal = $itemmrp * $addstock;
        
        if($addstock != '') {
            $query65 = "INSERT INTO master_stock (itemcode, itemname, transactiondate, transactionmodule, 
                transactionparticular, billautonumber, billnumber, quantity, remarks, 
                username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber)
                VALUES ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
                'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
                '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        } else {
            $query65 = "INSERT INTO master_stock (itemcode, itemname, transactiondate, transactionmodule, 
                transactionparticular, billautonumber, billnumber, quantity, remarks, 
                username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber)
                VALUES ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
                'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
                '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    
    header("location:stockadjustment.php");
    exit;
}

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "Success. Credit Note Updated.";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed. Credit Note Already Exists.";
    $bgcolorcode = 'failed';
}

// Get existing credit note records count
$querynw1 = "SELECT COUNT(*) as total FROM billing_ipcreditapproved";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_fetch_array($execnw1);
$totalRecords = $resnw1['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Note List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/creditnotelist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
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
        <span>Credit Note List</span>
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
                        <a href="patient1.php" class="nav-link">
                            <i class="fas fa-user-injured"></i>
                            <span>Patient Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing1.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pharmacy1.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="creditnotelist.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Credit Notes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports1.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
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
                    <h2>Credit Note List</h2>
                    <p>Search and manage credit notes for patient billing and financial adjustments.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportResults()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Credit Notes</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="creditnotelist.php" class="search-form">
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <select name="location" id="location" class="form-select">
                            <?php
                            $query1 = "SELECT * FROM login_locationdetails WHERE username='$username' AND docno='$docno' GROUP BY locationname ORDER BY locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $res1location = $res1["locationname"];
                                $res1locationanum = $res1["locationcode"];
                                $selected = ($location != '' && $location == $res1locationanum) ? 'selected' : '';
                                echo "<option value=\"$res1locationanum\" $selected>$res1location</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Customer Name</label>
                        <input name="customer" type="text" id="customer" class="form-input" 
                               placeholder="Enter customer name" autocomplete="off">
                        <input type="hidden" name="customercode" id="customercode">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Account Name</label>
                        <input name="accountname" type="text" id="accountname" class="form-input" 
                               placeholder="Enter account name" autocomplete="off">
                        <input type="hidden" name="accountid" id="accountid">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date From</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                   class="form-input date-input" readonly="readonly" />
                            <i class="fas fa-calendar-alt calendar-icon" onclick="javascript:NewCssCal('ADate1')"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date To</label>
                        <div class="date-input-group">
                            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                   class="form-input date-input" readonly="readonly" />
                            <i class="fas fa-calendar-alt calendar-icon" onclick="javascript:NewCssCal('ADate2')"></i>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="cbfrmflag2" value="cbfrmflag2">
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <div class="results-title">
                        <i class="fas fa-list"></i>
                        Credit Note List
                        <span class="results-count"><?php echo $totalRecords; ?></span>
                    </div>
                    <div class="results-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="printResults()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <div class="data-table-container">
                    <table id="dataTable" class="data-table">
                        <thead>
                            <tr>
                                <th data-sortable="true" data-column="no">No.</th>
                                <th data-sortable="true" data-column="date">Date</th>
                                <th data-sortable="true" data-column="billno">Bill No</th>
                                <th data-sortable="true" data-column="patientcode">Patient Code</th>
                                <th data-sortable="true" data-column="patientname">Patient Name</th>
                                <th data-sortable="true" data-column="visitcode">Visit Code</th>
                                <th data-sortable="true" data-column="amount">Amount</th>
                                <th data-sortable="true" data-column="status">Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Get credit note records
                            $query = "SELECT * FROM billing_ipcreditapproved ORDER BY auto_number DESC LIMIT 50";
                            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if ($exec && mysqli_num_rows($exec) > 0) {
                                $counter = 1;
                                while ($res = mysqli_fetch_array($exec)) {
                                    $billno = $res['billno'];
                                    $patientcode = $res['patientcode'];
                                    $patientname = $res['patientname'];
                                    $visitcode = $res['visitcode'];
                                    $amount = $res['totalamount'];
                                    $billingdate = date('d-m-Y', strtotime($res['billingdatetime']));
                                    
                                    // Default status for credit notes
                                    $statusClass = 'status-credit';
                                    $statusText = 'Credit';
                                    ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo $billingdate; ?></td>
                                        <td><?php echo htmlspecialchars($billno); ?></td>
                                        <td><?php echo htmlspecialchars($patientcode); ?></td>
                                        <td><?php echo htmlspecialchars($patientname); ?></td>
                                        <td><?php echo htmlspecialchars($visitcode); ?></td>
                                        <td>₹<?php echo number_format($amount, 2); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $statusClass; ?>">
                                                <?php echo $statusText; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn view" onclick="viewCreditNote('<?php echo $billno; ?>', '<?php echo $visitcode; ?>', '<?php echo $patientcode; ?>')" title="View Credit Note">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="action-btn print" onclick="viewCreditNote('<?php echo $billno; ?>', '<?php echo $visitcode; ?>', '<?php echo $patientcode; ?>')" title="Print Credit Note">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="action-btn edit" onclick="editCreditNote('<?php echo $billno; ?>')" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="action-btn delete" onclick="deleteCreditNote('<?php echo $billno; ?>')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9" class="no-data">
                                        <div class="no-data-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <h3>No Credit Notes Found</h3>
                                        <p>No credit note records match your search criteria.</p>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/creditnotelist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for autocomplete -->
    <script>
        $(document).ready(function(e) {
            $('#accountname').autocomplete({
                source: "ajaxaccount.php",
                matchContains: true,
                minLength: 1,
                html: true,
                select: function(event, ui) {
                    var accountname = ui.item.value;
                    var accountid = ui.item.id;
                    $("#accountid").val(accountid);
                }
            });
        });

        $(document).ready(function() {
            $('#customer').autocomplete({
                source: "ajaxdebit.php",
                matchContains: true,
                minLength: 1,
                html: true,
                select: function(event, ui) {
                    var patientcode = ui.item.patientcode;
                    $("#customercode").val(patientcode);
                }
            });
        });
    </script>
    
    <!-- Additional JavaScript Functions -->
    <script type="text/javascript">
        function editCreditNote(billno) {
            console.log('Editing credit note:', billno);
        }

        function deleteCreditNote(billno) {
            if (confirm('Are you sure you want to delete this credit note?')) {
                console.log('Deleting credit note:', billno);
            }
        }

        function exportResults() {
            console.log('Exporting results');
        }

        function printResults() {
            window.print();
        }
    </script>
</body>
</html>
