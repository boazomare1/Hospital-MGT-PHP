<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
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

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
    $bgcolorcode = 'success';
}
if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
    $bgcolorcode = 'error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Entry List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/doctorentrylist-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Doctor Entry List</span>
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
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="advancedeposit.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Advance Deposit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addalertmessage1.php" class="nav-link">
                            <i class="fas fa-bell"></i>
                            <span>Alert Messages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ar_allocatedreport.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>AR Allocated Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amendallocations.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Amend Allocations</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="doctorentrylist.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Entry List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="newpatient.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>New Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientlist.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Patient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="visitentry.php" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Visit Entry</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'error' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Doctor Entry List</h2>
                    <p>View and manage doctor payment transactions and entries.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Criteria</h3>
                </div>
                
                <form name="cbform1" method="post" action="doctorentrylist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Doctor Name</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" 
                                   value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                                   class="form-input" placeholder="Enter doctor name..." autocomplete="off">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="">
                        </div>
                        
                        <div class="form-group">
                            <label for="docno" class="form-label">Document Number</label>
                            <input name="docno" type="text" id="docno" 
                                   class="form-input" placeholder="Enter document number..." autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" type="date" 
                                   value="<?php echo htmlspecialchars($transactiondatefrom); ?>" 
                                   class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" type="date" 
                                   value="<?php echo htmlspecialchars($transactiondateto); ?>" 
                                   class="form-input">
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetSearchForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1'): ?>
            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">Doctor Payment Transactions</h3>
                </div>

                <div class="table-container">
                    <table class="data-table" id="doctorEntryTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Doc No</th>
                                <th>Mode</th>
                                <th>Bill Number</th>
                                <th>Doctor Name</th>
                                <th>Bank Code</th>
                                <th>Bank Name</th>
                                <th>Account Name</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="doctorEntryTableBody">
                            <?php 
                            $colorloopcount = 0;
                            $sno = 0;
                            
                            if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                                $searchsuppliername1 = $_POST['searchsuppliername'];
                                $searchsuppliercode1 = $_POST['searchsuppliercode'];
                                $searchdocno = $_POST['docno'];
                                $fromdate = $_POST['ADate1'];
                                $todate = $_POST['ADate2'];
                                $searchsuppliername = "";		
                                $arraysuppliercode = "";

                                $query2 = "SELECT *, SUM(transactionamount) as amount FROM master_transactiondoctor WHERE doctorcode LIKE '%$searchsuppliercode1%' AND docno LIKE '%$searchdocno%' AND transactionmodule = 'PAYMENT' AND transactiondate BETWEEN '$fromdate' AND '$todate' GROUP BY docno ORDER BY auto_number DESC";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num2 = mysqli_num_rows($exec2);
                                
                                while ($res2 = mysqli_fetch_array($exec2)) {
                                    $totalamount = 0;
                                    $transactiondate = $res2['transactiondate'];
                                    $docno = $res2['docno'];
                                    $mode = $res2['transactionmode'];
                                    $billnumber = $res2['billnumber'];
                                    $doctorname = $res2['doctorname'];				  
                                    $bankcode = $res2['bankcode'];
                                    $bankname = $res2['bankname'];
                                    $accountname = $res2['accountname'];
                                    $amount = $res2['amount'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    $colorcode = '';
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }  
                                    
                                    if($amount > 0) {
                                        $sno++;
                            ?>
                            <tr class="<?php echo ($sno % 2 == 0) ? 'even-row' : 'odd-row'; ?>" id="idTR<?php echo $colorloopcount; ?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo htmlspecialchars($transactiondate); ?></td>
                                <td>
                                    <span class="doc-number"><?php echo htmlspecialchars($docno); ?></span>
                                </td>
                                <td>
                                    <span class="mode-badge mode-<?php echo strtolower($mode); ?>">
                                        <?php echo htmlspecialchars($mode); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($billnumber); ?></td>
                                <td>
                                    <div class="doctor-info">
                                        <span class="doctor-name"><?php echo htmlspecialchars($doctorname); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="bank-code"><?php echo htmlspecialchars($bankcode); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($bankname); ?></td>
                                <td><?php echo htmlspecialchars($accountname); ?></td>
                                <td class="amount-cell">
                                    <?php echo number_format($amount, 2, '.', ','); ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="funcDeleteVoucher('<?php echo htmlspecialchars($docno); ?>', '<?php echo $colorloopcount; ?>', '<?php echo htmlspecialchars($mode); ?>')"
                                                title="Delete Entry">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="action-btn view" 
                                                onclick="viewEntry('<?php echo htmlspecialchars($docno); ?>')"
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($sno == 0): ?>
                <div class="no-data-message">
                    <i class="fas fa-info-circle"></i>
                    <p>No doctor payment transactions found for the selected criteria.</p>
                    <p>Try adjusting your search parameters or date range.</p>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/doctorentrylist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Autocomplete Scripts -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#searchsuppliername').autocomplete({
                source: "ajaxdoctorname_nm.php",
                matchContains: true,
                minLength: 1,
                html: true, 
                select: function(event, ui) {
                    var accountname = ui.item.value;
                    var accountid = ui.item.id;
                    $("#searchsuppliercode").val(accountid);
                },
            });	
        });
    </script>
</body>
</html>



