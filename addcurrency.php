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

if (isset($_REQUEST["ledger"])) { 
    $ledger = $_REQUEST["ledger"]; 
} else { 
    $ledger = ""; 
}

if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

// Handle form submission
if ($frmflag1 == 'frmflag1') {
    $currency = strtoupper($_REQUEST['currency']);
    $rate = $_REQUEST['rate'];
    $ledgercode = $_REQUEST['ledgerid']; 
    $symbol = $_REQUEST["symbol"];
    $ledgername = $_REQUEST["ledger"];

    $length = strlen($rate);

    if ($length <= 100) {
        $query1 = "INSERT INTO master_currency (currency, rate, symbol, ledgername, ledgercode, ipaddress, recorddate, username) 
                   VALUES ('$currency', '$rate', '$symbol', '$ledgername', '$ledgercode', '$ipaddress', '$updatedatetime', '$username')"; 

        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));

        $errmsg = "Success. New Currency Added.";
        $bgcolorcode = 'success';
    } else {
        $errmsg = "Failed. Only 100 Characters Are Allowed.";
        $bgcolorcode = 'failed';
    }
}

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query99 = "UPDATE master_currency SET recordstatus = 'deleted' WHERE auto_number = '$delanum'";
    $exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die("Error in Query03: " . mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query37 = "UPDATE master_currency SET recordstatus = '' WHERE auto_number = '$delanum'";
    $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die("Error in Query3: " . mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'default') {
    $delanum = $_REQUEST["anum"];
    $query46 = "UPDATE master_subcurrency SET defaultstatus = '' WHERE cstid='$custid' AND cstname='$custname'";
    $exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die("Error in Query4: " . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $query47 = "UPDATE master_currency SET defaultstatus = 'default' WHERE auto_number = '$delanum'";
    $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die("Error in Query5: " . mysqli_error($GLOBALS["___mysqli_ston"]));
}

// Get existing currencies
$query101 = "SELECT * FROM master_currency WHERE recordstatus != 'deleted' ORDER BY currency";
$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));

// Get deleted currencies
$query11 = "SELECT * FROM master_currency WHERE recordstatus = 'deleted' ORDER BY currency";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query11: " . mysqli_error($GLOBALS["___mysqli_ston"]));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Currency - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addcurrency-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Add Currency</span>
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
                        <a href="supplier1.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Suppliers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="purchase1.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Purchases</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payment1.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payments</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="addcurrency.php" class="nav-link">
                            <i class="fas fa-coins"></i>
                            <span>Currency Management</span>
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
                    <h2>Currency Management</h2>
                    <p>Add and manage currencies for your healthcare system with exchange rates and ledger integration.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportCurrencies()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Add Currency Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <i class="fas fa-plus-circle form-icon"></i>
                    <h3 class="form-title">Add New Currency</h3>
                </div>
                
                <form id="currencyForm" name="form1" method="post" action="addcurrency.php" class="form">
                    <div class="form-group">
                        <label class="form-label">Currency Name</label>
                        <input name="currency" id="currency" class="form-input uppercase" 
                               placeholder="e.g., USD, EUR, GBP" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Exchange Rate</label>
                        <input name="rate" id="rate" class="form-input" 
                               placeholder="e.g., 1.00" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Currency Symbol</label>
                        <input name="symbol" id="symbol" class="form-input uppercase" 
                               placeholder="e.g., $, €, £" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ledger Name</label>
                        <input type="text" name="ledger" id="ledger" class="form-input" 
                               placeholder="Select ledger account" autocomplete="off" required>
                        <input type="hidden" name="autobuildledger" id="autobuildledger">
                        <input type="hidden" name="ledgerid" id="ledgerid">
                        <input type="hidden" name="ledgeranum" id="ledgeranum">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Currency
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag" value="addnew" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                </form>
            </div>

            <!-- Active Currencies Section -->
            <div class="currency-list-section">
                <div class="currency-list-header">
                    <div class="currency-list-title">
                        <i class="fas fa-coins"></i>
                        Active Currencies
                        <span class="results-count"><?php echo mysqli_num_rows($exec101); ?></span>
                    </div>
                    <div class="currency-list-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="printCurrencies()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <div class="data-table-container">
                    <table id="dataTable" class="data-table">
                        <thead>
                            <tr>
                                <th data-sortable="true" data-column="no">No.</th>
                                <th data-sortable="true" data-column="currency">Currency</th>
                                <th data-sortable="true" data-column="symbol">Symbol</th>
                                <th data-sortable="true" data-column="rate">Exchange Rate</th>
                                <th data-sortable="true" data-column="ledger">Ledger</th>
                                <th data-sortable="true" data-column="status">Status</th>
                                <th data-sortable="true" data-column="date">Added Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($exec101 && mysqli_num_rows($exec101) > 0) {
                                $counter = 1;
                                while ($res101 = mysqli_fetch_array($exec101)) {
                                    $currency = $res101['currency'];
                                    $symbol = $res101['symbol'];
                                    $rate = $res101['rate'];
                                    $ledgername = $res101['ledgername'];
                                    $recorddate = date('d-m-Y', strtotime($res101['recorddate']));
                                    $recordstatus = $res101['recordstatus'];
                                    $auto_number = $res101['auto_number'];
                                    
                                    $statusClass = $recordstatus == 'default' ? 'status-default' : 'status-active';
                                    $statusText = $recordstatus == 'default' ? 'Default' : 'Active';
                                    ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td>
                                            <span class="currency-symbol"><?php echo htmlspecialchars($currency); ?></span>
                                        </td>
                                        <td>
                                            <span class="currency-symbol"><?php echo htmlspecialchars($symbol); ?></span>
                                        </td>
                                        <td>
                                            <span class="currency-rate"><?php echo number_format($rate, 4); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($ledgername); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $statusClass; ?>">
                                                <?php echo $statusText; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $recorddate; ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn delete" onclick="deleteCurrency('<?php echo $auto_number; ?>')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <?php if ($recordstatus != 'default'): ?>
                                                <button class="action-btn default" onclick="setDefaultCurrency('<?php echo $auto_number; ?>')" title="Set as Default">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8" class="no-data">
                                        <div class="no-data-icon">
                                            <i class="fas fa-coins"></i>
                                        </div>
                                        <h3>No Active Currencies</h3>
                                        <p>No active currencies found. Add your first currency above.</p>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Deleted Currencies Section -->
            <?php if (mysqli_num_rows($exec11) > 0): ?>
            <div class="currency-list-section">
                <div class="currency-list-header">
                    <div class="currency-list-title">
                        <i class="fas fa-trash"></i>
                        Deleted Currencies
                        <span class="results-count"><?php echo mysqli_num_rows($exec11); ?></span>
                    </div>
                </div>

                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Currency</th>
                                <th>Symbol</th>
                                <th>Exchange Rate</th>
                                <th>Ledger</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            while ($res11 = mysqli_fetch_array($exec11)) {
                                $currency = $res11['currency'];
                                $symbol = $res11['symbol'];
                                $rate = $res11['rate'];
                                $ledgername = $res11['ledgername'];
                                $auto_number = $res11['auto_number'];
                                ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td>
                                        <span class="currency-symbol"><?php echo htmlspecialchars($currency); ?></span>
                                    </td>
                                    <td>
                                        <span class="currency-symbol"><?php echo htmlspecialchars($symbol); ?></span>
                                    </td>
                                    <td>
                                        <span class="currency-rate"><?php echo number_format($rate, 4); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($ledgername); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn activate" onclick="activateCurrency('<?php echo $auto_number; ?>')" title="Activate">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </div>
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
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addcurrency-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for autocomplete -->
    <script>
        $(document).ready(function() {
            $('#ledger').autocomplete({
                source: "ajaxledger.php",
                matchContains: true,
                minLength: 1,
                html: true,
                select: function(event, ui) {
                    var ledgername = ui.item.ledgername;
                    var ledgercode = ui.item.ledgercode;
                    var ledgeranum = ui.item.auto_number;
                    
                    $("#ledger").val(ledgername);
                    $("#ledgerid").val(ledgercode);
                    $("#ledgeranum").val(ledgeranum);
                }
            });
        });
    </script>
    
    <!-- Additional JavaScript Functions -->
    <script type="text/javascript">
        function setDefaultCurrency(anum) {
            if (confirm('Are you sure you want to set this as the default currency?')) {
                window.location.href = `addcurrency.php?st=default&anum=${anum}`;
            }
        }

        function exportCurrencies() {
            console.log('Exporting currencies');
        }

        function printCurrencies() {
            window.print();
        }
    </script>
</body>
</html>
