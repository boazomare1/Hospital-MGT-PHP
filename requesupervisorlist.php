<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$updatedatetime = date('Y-m-d H:i:s');
$thistime = time('H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

// Get request parameters
if (isset($_REQUEST["user"])) { 
    $user = $_REQUEST["user"]; 
} else { 
    $user = ""; 
}

if (isset($_REQUEST["request"])) { 
    $request = $_REQUEST["request"]; 
} else { 
    $request = ""; 
}

// Handle form submission
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

$searchResults = [];
$approvalResults = [];
$discardResults = [];

if ($frmflag1 == 'frmflag1') {
    if (isset($_REQUEST["empname"])) { 
        $user = $_REQUEST["empname"]; 
    } else { 
        $user = ""; 
    }
    
    if (isset($_REQUEST["request"])) { 
        $request = $_REQUEST["request"]; 
    } else { 
        $request = ""; 
    }

    $startdate = $_REQUEST['ADate1'];
    $enddate = $_REQUEST['ADate2'];
    $sno = 0;
    
    // Query for approval list (approved_status = '0')
    $querry = "select * from pcrequest where doc_no like '%$request%' and username like '%$user%' and currentdate between '$startdate' and '$enddate' and delete_status <>'deleted' and approved_status='0' ORDER BY `pcrequest`.`doc_no` ASC";
    $exe = mysqli_query($GLOBALS["___mysqli_ston"], $querry);
    
    while ($result = mysqli_fetch_array($exe)) {
        $approvalResults[] = $result;
    }
    
    // Query for discard list (approved_status = '6')
    $querry1 = "select * from pcrequest where doc_no like '%$request%' and username like '%$user%' and currentdate between '$startdate' and '$enddate' and delete_status <>'deleted' and approved_status='6' ORDER BY `pcrequest`.`doc_no` ASC";
    $exe1 = mysqli_query($GLOBALS["___mysqli_ston"], $querry1);
    
    while ($result1 = mysqli_fetch_array($exe1)) {
        $discardResults[] = $result1;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash Supervisor Request List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/petty-cash-request-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Legacy jQuery for autocomplete -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
        <span>Petty Cash Supervisor Request List</span>
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
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="requesupervisorlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Petty Cash Supervisor Requests</span>
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
                    <h2>Petty Cash Supervisor Request List</h2>
                    <p>Review and manage petty cash requests requiring supervisor approval.</p>
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
                    <h3 class="search-form-title">Search Petty Cash Requests</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="requesupervisorlist.php" class="search-form" onSubmit="return additem1process1()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="request" class="form-label">
                                <i class="fas fa-hashtag"></i>
                                Request Number
                            </label>
                            <input type="text" 
                                   name="request" 
                                   id="request" 
                                   class="form-input"
                                   value="<?php echo htmlspecialchars($request); ?>"
                                   placeholder="Enter request number..."
                                   autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="empname" class="form-label">
                                <i class="fas fa-user"></i>
                                User
                            </label>
                            <div class="autocomplete-container">
                                <input type="text" 
                                       name="empname" 
                                       id="empname" 
                                       class="form-input autocomplete-input"
                                       value="<?php echo htmlspecialchars($user); ?>"
                                       placeholder="Search for user..."
                                       autocomplete="off">
                                <i class="fas fa-search autocomplete-icon"></i>
                            </div>
                            <input type="hidden" name="empcode" id="empcode" value="">
                            <input type="hidden" name="selectedempname" id="selectedempname" value="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">
                                <i class="fas fa-calendar-check"></i>
                                Date From
                            </label>
                            <div class="date-input-group">
                                <input name="ADate1" 
                                       id="ADate1" 
                                       value="<?php echo date('Y-m-d'); ?>"
                                       class="form-input date-input" 
                                       readonly 
                                       onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" 
                                     onClick="javascript:NewCssCal('ADate1')"
                                     class="date-picker-icon" 
                                     alt="Select Date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">
                                <i class="fas fa-calendar-times"></i>
                                Date To
                            </label>
                            <div class="date-input-group">
                                <input name="ADate2" 
                                       id="ADate2" 
                                       value="<?php echo date('Y-m-d'); ?>"
                                       class="form-input date-input" 
                                       readonly 
                                       onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" 
                                     onClick="javascript:NewCssCal('ADate2')"
                                     class="date-picker-icon" 
                                     alt="Select Date">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-search"></i> Search Requests
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($frmflag1 == 'frmflag1'): ?>
                <!-- Search Results Section -->
                <div class="results-section">
                    <!-- Approval List -->
                    <?php if (!empty($approvalResults)): ?>
                        <div class="data-table-section">
                            <div class="data-table-header">
                                <i class="fas fa-check-circle data-table-icon"></i>
                                <h3 class="data-table-title">Petty Supervisor Approval List</h3>
                                <div class="data-table-count">Total: <strong><?php echo count($approvalResults); ?></strong></div>
                            </div>

                            <!-- Modern Data Table -->
                            <div class="modern-table-container">
                                <table class="modern-data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Request No</th>
                                            <th>Amount</th>
                                            <th>Request By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sno = 0;
                                        foreach ($approvalResults as $result): 
                                            $sno++;
                                            $date = $result['currentdate'];
                                            $amount = $result['amount'];
                                            $remarks = $result['remarks'];
                                            $username = $result['username'];
                                            $doc_no = $result['doc_no'];
                                            $row_class = ($sno % 2 == 0) ? 'even' : 'odd';
                                        ?>
                                            <tr class="table-row <?php echo $row_class; ?>">
                                                <td><?php echo $sno; ?></td>
                                                <td><span class="date-badge"><?php echo date('d/m/Y', strtotime($date)); ?></span></td>
                                                <td><span class="doc-no-badge"><?php echo htmlspecialchars($doc_no); ?></span></td>
                                                <td><span class="amount-badge"><?php echo number_format($amount, 2, '.', ','); ?></span></td>
                                                <td><?php echo ucwords(htmlspecialchars($username)); ?></td>
                                                <td>
                                                    <a href="viewpcrequest_new.php?docno=<?php echo htmlspecialchars($doc_no); ?>" 
                                                       class="action-btn view" title="View Request Details">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Discard List -->
                    <?php if (!empty($discardResults)): ?>
                        <div class="data-table-section">
                            <div class="data-table-header">
                                <i class="fas fa-times-circle data-table-icon"></i>
                                <h3 class="data-table-title">Petty Supervisor Discard List</h3>
                                <div class="data-table-count">Total: <strong><?php echo count($discardResults); ?></strong></div>
                            </div>

                            <!-- Modern Data Table -->
                            <div class="modern-table-container">
                                <table class="modern-data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Request No</th>
                                            <th>Amount</th>
                                            <th>Request By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sno = 0;
                                        foreach ($discardResults as $result1): 
                                            $sno++;
                                            $date = $result1['currentdate'];
                                            $amount = $result1['amount'];
                                            $remarks = $result1['remarks'];
                                            $username = $result1['username'];
                                            $doc_no = $result1['doc_no'];
                                            $row_class = ($sno % 2 == 0) ? 'even' : 'odd';
                                        ?>
                                            <tr class="table-row <?php echo $row_class; ?>">
                                                <td><?php echo $sno; ?></td>
                                                <td><span class="date-badge"><?php echo date('d/m/Y', strtotime($date)); ?></span></td>
                                                <td><span class="doc-no-badge"><?php echo htmlspecialchars($doc_no); ?></span></td>
                                                <td><span class="amount-badge"><?php echo number_format($amount, 2, '.', ','); ?></span></td>
                                                <td><?php echo ucwords(htmlspecialchars($username)); ?></td>
                                                <td>
                                                    <a href="viewpcrequest_new.php?docno=<?php echo htmlspecialchars($doc_no); ?>" 
                                                       class="action-btn view" title="View Request Details">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($approvalResults) && empty($discardResults)): ?>
                        <div class="no-results-message">
                            <i class="fas fa-search"></i>
                            <h3>No Results Found</h3>
                            <p>No petty cash requests found matching your search criteria.</p>
                            <button type="button" class="btn btn-primary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Try Different Search
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/petty-cash-request-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy autocomplete functionality -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#empname').autocomplete({
                source: "ajaxuser_search.php",
                matchContains: true,
                minLength: 1,
                html: true, 
                select: function(event, ui){
                    var userid = ui.item.usercode;
                    var username = ui.item.username;
                    
                    $("#empcode").val(userid);
                    $("#selectedempname").val(username);
                }
            });
        });
        
        function disableEnterKey() {
            if (event.keyCode === 13) {
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
