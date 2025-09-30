<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$fromdate = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$todate = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : date("Y-m-d");

$fromdate_actual = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date("Y-m-d");
$todate_actual = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : date("Y-m-d");
$time = strtotime($todaydate);
$month = date("m", $time);
$year = date("Y", $time);

$thismonth = $year."-".$month."___";

$todaydate = date("Y-m-d");

// Set ledger_id request
$ledger_id = isset($_REQUEST['ledgerid']) ? $_REQUEST['ledgerid'] : "";
$ledger_name = isset($_REQUEST['ledgername']) ? $_REQUEST['ledgername'] : "";
$searchpaymentcode = isset($_REQUEST['searchpaymentcode']) ? $_REQUEST['searchpaymentcode'] : "";
$viewtype = isset($_REQUEST['viewtype']) ? $_REQUEST['viewtype'] : "";
$accountsmaintype = isset($_REQUEST['accountsmaintype']) ? $_REQUEST['accountsmaintype'] : "";
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : "";
$accountssub = isset($_REQUEST['accountssub']) ? $_REQUEST['accountssub'] : "";
$skipzeroballeg = isset($_POST["skipzeroballeg"]) ? 1 : 0;

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if($location != '') {
    $locationcode = $location;
}

// Initialize report data
$reportData = [];
$summaryData = [
    'total_ledgers' => 0,
    'total_debit' => 0,
    'total_credit' => 0,
    'total_balance' => 0
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Ledger View - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/general-ledger-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    
    <!-- External JavaScript -->
    <script src="js/general-ledger-modern.js?v=<?php echo time(); ?>"></script>
</head>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">General Ledger View Report</p>
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
        <span>General Ledger View</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountsmain1.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountssubtype1.php" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedassetacquisition.php" class="nav-link">
                            <i class="fas fa-tools"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="generalledgerview.php" class="nav-link">
                            <i class="fas fa-book"></i>
                            <span>General Ledger View</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-user-injured"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer"></div>

            <!-- Report Card -->
            <div class="report-card-container">
                <div class="report-card">
                    <div class="card-header">
                        <div class="card-title-section">
                            <h2 class="report-title">General Ledger View Report</h2>
                            <p class="report-description">Comprehensive ledger analysis with detailed transaction views and account summaries.</p>
                        </div>
                        <div class="card-actions">
                            <button class="btn btn-primary" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button class="btn btn-secondary" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>

                    <!-- Search Parameters Section -->
                    <div class="search-parameters">
                        <div class="parameters-header">
                            <h3><i class="fas fa-search"></i> Report Parameters</h3>
                            <button class="toggle-parameters" id="toggleParameters">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        
                        <div class="parameters-content" id="parametersContent">
                            <form name="cbform1" method="post" action="generalledgerview.php" onSubmit="return validcheck()">
                                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                                
                                <!-- Search Type Selection -->
                                <div class="form-group">
                                    <label class="form-label">Search Type</label>
                                    <div class="radio-group">
                                        <label class="radio-label">
                                            <input type="radio" name="searchpaymenttype" id="searchpaymenttype11" value="1" <?php echo ($searchpaymentcode == '1') ? 'checked' : ''; ?>>
                                            <span class="radio-custom"></span>
                                            <span class="radio-text">Ledger</span>
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="searchpaymenttype" id="searchpaymenttype12" value="2" <?php echo ($searchpaymentcode == '2') ? 'checked' : ''; ?>>
                                            <span class="radio-custom"></span>
                                            <span class="radio-text">Group</span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="searchpaymentcode" id="searchpaymentcode" value="<?php echo $searchpaymentcode; ?>">
                                </div>

                                <!-- Ledger Search -->
                                <div class="form-group" id="ledgersearch">
                                    <label class="form-label">Ledger Name</label>
                                    <div class="input-group">
                                        <input type="text" name="ledgername" id="ledgername" class="form-input" value="<?php echo htmlspecialchars($ledger_name); ?>" placeholder="Enter ledger name...">
                                        <input type="hidden" name="ledgerid" id="ledgerid" value="<?php echo $ledger_id; ?>">
                                    </div>
                                </div>

                                <!-- Group Search -->
                                <div class="form-group" id="groupsearch">
                                    <div class="form-row">
                                        <div class="form-col">
                                            <label class="form-label">Main Type</label>
                                            <select name="accountsmaintype" id="accountsmaintype" class="form-select" onChange="return funcAccountsMainTypeChange1()">
                                                <option value="">Select Type</option>
                                                <?php
                                                $query5 = "select * from master_accountsmain where recordstatus = '' order by id";
                                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                while ($res5 = mysqli_fetch_array($exec5)) {
                                                    $res5accountsmainanum = $res5["auto_number"];
                                                    $res5accountsmain = $res5["accountsmain"];
                                                    ?>
                                                    <option value="<?php echo $res5accountsmainanum; ?>" <?php if($accountsmaintype == $res5accountsmainanum) { echo 'selected'; } ?>><?php echo $res5accountsmain; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-col">
                                            <label class="form-label">Sub Type</label>
                                            <select name="accountssub" id="accountssub" class="form-select">
                                                <option value="">Select Sub Type</option>
                                            </select>
                                        </div>
                                        <div class="form-col">
                                            <label class="form-label">View Type</label>
                                            <select name="viewtype" id="viewtype" class="form-select">
                                                <option value="summary" <?php if($viewtype == 'summary') { echo 'selected'; } ?>>Summary</option>
                                                <option value="detailed" <?php if($viewtype == 'detailed') { echo 'selected'; } ?>>Detailed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location and Options -->
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="form-col">
                                            <label class="form-label">Location</label>
                                            <select name="location" id="location" class="form-select">
                                                <option value="All">All</option>
                                                <?php
                                                $query1 = "select * from master_location where status='' order by locationname";
                                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                while ($res1 = mysqli_fetch_array($exec1)) {
                                                    $locationname = $res1["locationname"];
                                                    $locationcode = $res1["locationcode"];
                                                    ?>
                                                    <option value="<?php echo $locationcode; ?>" <?php if($location != '' && $location == $locationcode) { echo "selected"; } ?>><?php echo $locationname; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-col">
                                            <label class="checkbox-label">
                                                <input type="checkbox" name="skipzeroballeg" id="skipzeroballeg" value='1' <?php if($skipzeroballeg == '1') { echo 'checked'; } ?>>
                                                <span class="checkbox-custom"></span>
                                                <span class="checkbox-text">Skip Zero Balance Ledgers</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date Range -->
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="form-col">
                                            <label class="form-label">Date From</label>
                                            <div class="input-group">
                                                <input name="ADate1" id="ADate1" class="form-input" value="<?php echo $fromdate != '' ? $fromdate : $todaydate; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                                <button type="button" class="input-button" onClick="javascript:NewCssCal('ADate1')">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-col">
                                            <label class="form-label">Date To</label>
                                            <div class="input-group">
                                                <input name="ADate2" id="ADate2" class="form-input" value="<?php echo $todate != '' ? $todate : $todaydate; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                                <button type="button" class="input-button" onClick="javascript:NewCssCal('ADate2')">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="form-actions">
                                    <button type="submit" name="Submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Generate Report
                                    </button>
                                    <button type="submit" name="download" id="download" class="btn btn-secondary">
                                        <i class="fas fa-download"></i> Excel Download
                                    </button>
                                    <button type="button" class="btn btn-outline" onclick="resetForm()">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Report Results -->
                    <div class="report-results" id="reportResults">
                        <?php if(isset($_POST['download'])) { ?>
                            <script>
                            window.location = 'generalledgerview_xl.php?ledgerid=<?php echo $ledger_id;?>&&ADate1=<?php echo $fromdate_actual; ?>&&ADate2=<?php echo $todate_actual; ?>&&ledgername=<?php echo $ledger_name; ?>&&searchpaymentcode=<?php echo $searchpaymentcode; ?>&&viewtype=<?php echo $viewtype; ?>&&accountsmaintype=<?php echo $accountsmaintype; ?>&&accountssub=<?php echo $accountssub; ?>&&skipzeroballeg=<?php echo $skipzeroballeg; ?>&&location=<?php echo $location; ?>';
                            </script>
                        <?php } else { ?>
                            <div class="report-content">
                                <div class="report-header">
                                    <h3>General Ledger Report</h3>
                                    <p>Generated on: <?php echo date('Y-m-d H:i:s'); ?></p>
                                </div>
                                
                                <!-- Report data will be displayed here -->
                                <div class="report-table-container">
                                    <div class="table-responsive">
                                        <table class="report-table">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Particulars</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <div class="no-data">
                                                            <i class="fas fa-chart-line"></i>
                                                            <p>No data available. Please generate a report using the parameters above.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript for form functionality -->
    <script>
    $(document).ready(function() {
        $("input:radio[name=searchpaymenttype]").click(function () {
            var val = this.value;
            $("#searchpaymentcode").val(val);
            if(val == "2") {
                $("#ledgersearch").hide();
                $("#groupsearch").show();
            } else {
                $("#ledgersearch").show();
                $("#groupsearch").hide();
            }
        });

        // Initialize form state
        var gg = $('#searchpaymentcode').val();
        if(gg == '') {
            $("#searchpaymenttype11").trigger('click');
            $("#ledgername").focus();
        }

        if(gg == '1') {
            $("#ledgersearch").show();
            $("#groupsearch").hide();
            $("#searchpaymenttype11").prop("checked", true);
            $("#searchpaymenttype12").prop("checked", false);
        } else if(gg == '2') {
            $("#ledgersearch").hide();
            $("#groupsearch").show();
            $("#searchpaymenttype11").prop("checked", false);
            $("#searchpaymenttype12").prop("checked", true);
        }
    });

    function funcAccountsMainTypeChange1() {
        <?php 
        $query12 = "select * from master_accountsmain where recordstatus = ''";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res12 = mysqli_fetch_array($exec12)) {
            $res12accountsmainanum = $res12["auto_number"];
            $res12accountsmain = $res12["accountsmain"];
            ?>
            if(document.getElementById("accountsmaintype").value == "<?php echo $res12accountsmainanum; ?>") {
                document.getElementById("accountssub").options.length = null; 
                var combo = document.getElementById('accountssub');
                <?php 
                $loopcount = 0;
                ?>
                combo.options[<?php echo $loopcount; ?>] = new Option("Select Sub Type", ""); 
                <?php
                $query10 = "select * from master_accountssub where accountsmain = '$res12accountsmainanum' and recordstatus = ''";
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res10 = mysqli_fetch_array($exec10)) {
                    $loopcount = $loopcount + 1;
                    $res10accountssubanum = $res10['auto_number'];
                    $res10accountssub = $res10["accountssub"];
                    ?>
                    combo.options[<?php echo $loopcount; ?>] = new Option("<?php echo $res10accountssub; ?>", "<?php echo $res10accountssubanum; ?>"); 
                    <?php 
                }
                ?>
            }
            <?php
        }
        ?>
        
        if(document.getElementById("accountsmaintype").value == 6) {
            $('#non_multicc').hide();
            $('#multicc').show();
        } else {
            $('#non_multicc').show();
            $('#multicc').hide();
        }
    }

    function validcheck() {
        if(document.getElementById("searchpaymentcode").value == '2' && document.getElementById("accountsmaintype").value == '') {
            alert("Please select the Main Type");
            document.getElementById("accountsmaintype").focus();
            return false;
        }
    }

    function exportToExcel() {
        document.getElementById('download').click();
    }

    function resetForm() {
        document.getElementById('cbform1').reset();
        $('#searchpaymenttype11').trigger('click');
    }

    function disableEnterKey(e) {
        var key;
        if(window.event) {
            key = window.event.keyCode;
        } else {
            key = e.which;
        }
        return (key != 13);
    }
    </script>
</body>
</html>
