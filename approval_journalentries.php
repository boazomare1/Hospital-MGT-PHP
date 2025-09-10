<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$grandtotal = '0.00';
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$customername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$visitcode1 = '';
$res2username = '';
$custname = '';
$colorloopcount = '';
$sno = '';

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');  

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if (isset($_REQUEST["canum"])) { 
    $getcanum = $_REQUEST["canum"]; 
} else { 
    $getcanum = ""; 
}
$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Journal Entries - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/approvaljournalentries-modern.css?v=<?php echo time(); ?>">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
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
        <span>Approval Journal Entries</span>
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
                        <a href="ipamendser_pending.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>IP Service Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analyzerresults.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="analyzecomparison.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Analyze Comparison</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeepayrollreport2.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="viewapprovedrfplist.php" class="nav-link">
                            <i class="fas fa-file-contract"></i>
                            <span>Approved RFPs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="depositrefundrequestlist.php" class="nav-link">
                            <i class="fas fa-undo"></i>
                            <span>Refund Requests</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="approval_journalentries.php" class="nav-link">
                            <i class="fas fa-book"></i>
                            <span>Journal Entries</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_lab.php" class="nav-link">
                            <i class="fas fa-microscope"></i>
                            <span>Pending Lab</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_ippharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pending Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_radiology.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Pending Radiology</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-book"></i> Approval Journal Entries</h2>
                    <p>Review and approve pending journal entries for accounting</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-primary" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <h3><i class="fas fa-search"></i> Search Journal Entries</h3>
                </div>
                
                <form name="cbform1" method="post" action="approval_journalentries.php" id="searchForm" class="search-form-content">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location *</label>
                            <select name="location" id="location" class="form-select" required>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $loccode = array();
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode) ? 'selected' : '';
                                    echo "<option value=\"$locationcode\" $selected>$locationname</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From *</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                       class="form-input" readonly required>
                                <i class="fas fa-calendar calendar-icon" onclick="NewCssCal('ADate1')"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To *</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                       class="form-input" readonly required>
                                <i class="fas fa-calendar calendar-icon" onclick="NewCssCal('ADate2')"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <!-- Journal Entries List Section -->
            <div class="journal-list-section">
                <div class="journal-list-header">
                    <h3>
                        <i class="fas fa-book"></i>
                        Pending Journal Entries
                        <span class="journal-count">0</span>
                    </h3>
                    <div class="journal-list-actions">
                        <button class="btn btn-secondary" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset Filters
                        </button>
                    </div>
                </div>

                <!-- Journal Table -->
                <div class="journal-table-container">
                    <table class="journal-table" id="journalTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Entry Date</th>
                                <th>Doc No</th>
                                <th>User Name</th>
                                <th>Account</th>
                                <th>Narration/Comments</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totaldr = '0.00';
                            $totalcr = '0.00';
                            $sno = 0;
                            $transactiondatefrom = $_REQUEST['ADate1'];
                            $transactiondateto = $_REQUEST['ADate2'];
                            
                            $query2 = "select * from master_journalentries where locationcode='$locationcode1' and entrydate between '$transactiondatefrom' and '$transactiondateto' AND docno NOT LIKE 'PCA-%' and (approve_je='0' or approve_je='') group by docno order by auto_number";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if (mysqli_num_rows($exec2) > 0):
                                while ($res2 = mysqli_fetch_array($exec2)):
                                    $res2billnumber = $res2['docno'];
                                    $res2transactiondate = $res2['entrydate'];
                                    $res3transactionamount = $res2['transactionamount'];
                                    $username = $res2['username'];
                                    $updatetime = $res2['updatedatetime'];
                                    $narration = $res2['narration'];

                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }

                                    $sno++;
                            ?>
                            <tr <?php echo $colorcode; ?> id="itr<?php echo $res2billnumber; ?>" data-docno="<?php echo htmlspecialchars($res2billnumber); ?>">
                                <td class="journal-number"><?php echo $sno; ?></td>
                                <td class="journal-date"><?php echo htmlspecialchars($res2transactiondate); ?></td>
                                <td class="journal-docno">
                                    <a href="journalprint.php?billnumber=<?php echo urlencode($res2billnumber); ?>" target="_blank">
                                        <?php echo htmlspecialchars($res2billnumber); ?>
                                    </a>
                                </td>
                                <td class="journal-username"><?php echo htmlspecialchars($username); ?></td>
                                <td class="journal-amount"><?php echo number_format($res3transactionamount, 2, '.', ','); ?></td>
                                <td class="journal-narration"><?php echo htmlspecialchars($narration); ?></td>
                                <td class="journal-action">
                                    <div class="approval-checkbox-container">
                                        <input type="checkbox" id="approved<?php echo $sno; ?>" 
                                               name="approve<?php echo $sno; ?>" 
                                               class="approve-checkbox" 
                                               data-docno="<?php echo htmlspecialchars($res2billnumber); ?>" 
                                               data-id="<?php echo $sno; ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                endwhile;
                            else:
                            ?>
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="empty-state-title">No Pending Journal Entries</div>
                                    <div class="empty-state-description">
                                        There are currently no pending journal entries matching your search criteria.
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Section -->
                <div class="summary-section">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">Total Journal Entries</span>
                            <span class="summary-value summary-pending"><?php echo $sno; ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Selected Location</span>
                            <span class="summary-value">
                                <?php 
                                if ($location != '') {
                                    $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res12 = mysqli_fetch_array($exec12);
                                    echo htmlspecialchars($res12["locationname"]);
                                } else {
                                    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res1 = mysqli_fetch_array($exec1);
                                    echo htmlspecialchars($res1["locationname"]);
                                }
                                ?>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Date Range</span>
                            <span class="summary-value"><?php echo date('M d, Y', strtotime($transactiondatefrom)); ?> - <?php echo date('M d, Y', strtotime($transactiondateto)); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Generated By</span>
                            <span class="summary-value"><?php echo htmlspecialchars($username); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/approvaljournalentries-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy scripts for compatibility -->
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    
    <script language="javascript">
        function ajaxlocationfunction(val) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
                }
            };
            
            xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
            xmlhttp.send();
        }
        
        function approveje(code, id) {
            var code = code;
            var check = confirm("Are you sure you want to Approve");
            if (check != true) {
                $("#approved" + id).prop("checked", false);
                return false;
            }
            
            $.ajax({
                url: 'ajaxapproveje.php?code=' + code,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#itr" + code).hide();
                    alert(response);
                }
            });
        }
    </script>
</body>
</html>