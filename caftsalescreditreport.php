<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$docno = $_SESSION['docno'];
$currentdate = date("Y-m-d");

// Initialize variables
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$visitcode1 = '';

// Initialize report variables
$res2username = '';
$custname = '';
$sno = '';
$customercode = '';
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';
$res2total = '0.00';
$cashamount = '0.00';
$cardamount = '0.00';
$chequeamount = '0.00';
$onlineamount = '0.00';
$total = '0.00';
$cashtotal = '0.00';
$cardtotal = '0.00';
$chequetotal = '0.00';
$onlinetotal = '0.00';

$res2cashamount1 = '';
$res2cardamount1 = '';
$res2chequeamount1 = '';
$res2onlineamount1 = '';
$cashamount2 = '0.00';
$cardamount2 = '0.00';
$chequeamount2 = '0.00';
$onlineamount2 = '0.00';
$creditamount2 = '0.00';
$total1 = '0.00';

include ("autocompletebuild_users.php");

$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

if ($getcanum != '') {
    $query4 = "select * from master_customer where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbcustomername = $res4['customername'];
    $customername = $res4['customername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1') {
    $cbcustomername = $_REQUEST['cbcustomername'];
    
    if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
    if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
    
    $transactiondatefrom = $_REQUEST['ADate1'];
    $transactiondateto = $_REQUEST['ADate2'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAFT Sales Credit Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/caftsalescreditreport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <!-- Autosuggest styles -->
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
        <span>CAFT Sales Credit Report</span>
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
                    <li class="nav-item">
                        <a href="adddepartment1.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Department Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="caftsalescreditreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>CAFT Sales Credit Report</span>
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
                    <h2>CAFT Sales Credit Report</h2>
                    <p>Generate comprehensive sales and credit reports for CAFT transactions and customer accounts.</p>
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
                    <h3 class="search-form-title">CAFT Sales Credit Report Filters</h3>
                </div>
                
                <form name="cbform1" method="post" action="caftsalescreditreport.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cbcustomername" class="form-label">Search User</label>
                            <input name="cbcustomername" type="text" id="cbcustomername" class="form-input" placeholder="Enter customer name to search" autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" class="form-input" value="<?php echo $transactiondatefrom; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" class="form-input" value="<?php echo $transactiondateto; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i> Search Report
                        </button>
                        <button type="reset" class="btn btn-outline" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Report Table Section -->
            <div class="report-table-section">
                <div class="report-table-header">
                    <i class="fas fa-table report-table-icon"></i>
                    <h3 class="report-table-title">CAFT Sales Credit Report Results</h3>
                </div>
                
                <div class="table-container">
                    <table class="report-table" id="reportTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer Name</th>
                                <th>Total Sales Amount</th>
                                <th>Total Sales Return Amount</th>
                                <th>Net Collection Amount</th>
                                <th>Net Payment Amount</th>
                                <th>Cash Amount</th>
                                <th>Card Amount</th>
                                <th>Cheque Amount</th>
                                <th>Online Amount</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                        <?php
                        if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                        
                        if ($cbfrmflag1 == 'cbfrmflag1') {
                            $cbcustomername = $_REQUEST['cbcustomername'];
                            $ADate1 = $_REQUEST['ADate1'];
                            $ADate2 = $_REQUEST['ADate2'];
                            $cbcustomername = trim($cbcustomername);
                            $res21username = $cbcustomername;
                            
                            // Query to get CAFT sales credit report data
                            $query2 = "SELECT 
                                c.customername,
                                SUM(b.totalamount) as total_sales_amount,
                                SUM(CASE WHEN b.billstatus = 'CANCELLED' THEN b.totalamount ELSE 0 END) as total_sales_return_amount,
                                SUM(CASE WHEN b.paymenttype = 'CASH' THEN b.totalamount ELSE 0 END) as cash_amount,
                                SUM(CASE WHEN b.paymenttype = 'CARD' THEN b.totalamount ELSE 0 END) as card_amount,
                                SUM(CASE WHEN b.paymenttype = 'CHEQUE' THEN b.totalamount ELSE 0 END) as cheque_amount,
                                SUM(CASE WHEN b.paymenttype = 'ONLINE' THEN b.totalamount ELSE 0 END) as online_amount,
                                SUM(b.totalamount) as total_amount
                                FROM master_customer c
                                LEFT JOIN billing_caft b ON c.auto_number = b.customeranum
                                WHERE b.transactiondate BETWEEN '$ADate1' AND '$ADate2'
                                AND c.companyanum = '$companyanum'
                                AND c.status = 'ACTIVE'";
                            
                            if (!empty($cbcustomername)) {
                                $query2 .= " AND c.customername LIKE '%$cbcustomername%'";
                            }
                            
                            $query2 .= " GROUP BY c.auto_number, c.customername ORDER BY c.customername";
                            
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            $sno = 0;
                            $grand_total_sales = 0;
                            $grand_total_returns = 0;
                            $grand_cash_total = 0;
                            $grand_card_total = 0;
                            $grand_cheque_total = 0;
                            $grand_online_total = 0;
                            $grand_total_amount = 0;
                            
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $sno++;
                                $customername = $res2['customername'];
                                $total_sales_amount = $res2['total_sales_amount'] ?: 0;
                                $total_sales_return_amount = $res2['total_sales_return_amount'] ?: 0;
                                $cash_amount = $res2['cash_amount'] ?: 0;
                                $card_amount = $res2['card_amount'] ?: 0;
                                $cheque_amount = $res2['cheque_amount'] ?: 0;
                                $online_amount = $res2['online_amount'] ?: 0;
                                $total_amount = $res2['total_amount'] ?: 0;
                                
                                $net_collection_amount = $total_sales_amount - $total_sales_return_amount;
                                $net_payment_amount = $cash_amount + $card_amount + $cheque_amount + $online_amount;
                                
                                // Add to grand totals
                                $grand_total_sales += $total_sales_amount;
                                $grand_total_returns += $total_sales_return_amount;
                                $grand_cash_total += $cash_amount;
                                $grand_card_total += $card_amount;
                                $grand_cheque_total += $cheque_amount;
                                $grand_online_total += $online_amount;
                                $grand_total_amount += $total_amount;
                                
                                echo "<tr>";
                                echo "<td>" . $sno . "</td>";
                                echo "<td>" . htmlspecialchars($customername) . "</td>";
                                echo "<td class='text-right'>" . number_format($total_sales_amount, 2) . "</td>";
                                echo "<td class='text-right'>" . number_format($total_sales_return_amount, 2) . "</td>";
                                echo "<td class='text-right'>" . number_format($net_collection_amount, 2) . "</td>";
                                echo "<td class='text-right'>" . number_format($net_payment_amount, 2) . "</td>";
                                echo "<td class='text-right'>" . number_format($cash_amount, 2) . "</td>";
                                echo "<td class='text-right'>" . number_format($card_amount, 2) . "</td>";
                                echo "<td class='text-right'>" . number_format($cheque_amount, 2) . "</td>";
                                echo "<td class='text-right'>" . number_format($online_amount, 2) . "</td>";
                                echo "<td class='text-right'><strong>" . number_format($total_amount, 2) . "</strong></td>";
                                echo "</tr>";
                            }
                            
                            // Add grand total row
                            if ($sno > 0) {
                                echo "<tr class='grand-total-row'>";
                                echo "<td colspan='2'><strong>GRAND TOTAL</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_total_sales, 2) . "</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_total_returns, 2) . "</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_total_sales - $grand_total_returns, 2) . "</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_cash_total + $grand_card_total + $grand_cheque_total + $grand_online_total, 2) . "</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_cash_total, 2) . "</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_card_total, 2) . "</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_cheque_total, 2) . "</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_online_total, 2) . "</strong></td>";
                                echo "<td class='text-right'><strong>" . number_format($grand_total_amount, 2) . "</strong></td>";
                                echo "</tr>";
                            } else {
                                echo "<tr><td colspan='11' class='text-center'>No records found for the selected criteria.</td></tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Controls -->
                <div class="pagination-controls">
                    <button id="prevBtn" class="btn btn-outline" onclick="changePage(-1)">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <span id="pageInfo" class="page-info">Page 1 of 1</span>
                    <button id="nextBtn" class="btn btn-outline" onclick="changePage(1)">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="pagination-info">
                    <span id="recordInfo">Showing 0 records</span>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script>
        // Pagination variables
        let currentPage = 1;
        const recordsPerPage = 10;
        let allRecords = [];
        let filteredRecords = [];

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializePagination();
            initializeSidebar();
        });

        // Pagination functions
        function initializePagination() {
            const tableBody = document.getElementById('reportTableBody');
            if (tableBody) {
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                allRecords = rows.map((row, index) => ({
                    element: row,
                    originalIndex: index
                }));
                filteredRecords = [...allRecords];
                updatePagination();
            }
        }

        function updatePagination() {
            const totalRecords = filteredRecords.length;
            const totalPages = Math.ceil(totalRecords / recordsPerPage);
            
            const pageInfo = document.getElementById('pageInfo');
            const recordInfo = document.getElementById('recordInfo');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            if (pageInfo) pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
            if (recordInfo) recordInfo.textContent = `Showing ${Math.min((currentPage - 1) * recordsPerPage + 1, totalRecords)}-${Math.min(currentPage * recordsPerPage, totalRecords)} of ${totalRecords} records`;
            
            if (prevBtn) prevBtn.disabled = currentPage === 1;
            if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;
            
            showPageRecords();
        }

        function showPageRecords() {
            const tableBody = document.getElementById('reportTableBody');
            if (tableBody) {
                allRecords.forEach(record => {
                    record.element.style.display = 'none';
                });
                
                const startIndex = (currentPage - 1) * recordsPerPage;
                const endIndex = startIndex + recordsPerPage;
                
                for (let i = startIndex; i < endIndex && i < filteredRecords.length; i++) {
                    filteredRecords[i].element.style.display = '';
                }
            }
        }

        function changePage(direction) {
            const totalPages = Math.ceil(filteredRecords.length / recordsPerPage);
            const newPage = currentPage + direction;
            
            if (newPage >= 1 && newPage <= totalPages) {
                currentPage = newPage;
                updatePagination();
            }
        }

        // Sidebar functions
        function initializeSidebar() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const leftSidebar = document.getElementById('leftSidebar');
            const mainContainer = document.querySelector('.main-container-with-sidebar');
            
            if (menuToggle && leftSidebar) {
                menuToggle.addEventListener('click', function() {
                    leftSidebar.classList.toggle('sidebar-open');
                    mainContainer.classList.toggle('sidebar-open');
                });
            }
            
            if (sidebarToggle && leftSidebar) {
                sidebarToggle.addEventListener('click', function() {
                    leftSidebar.classList.toggle('collapsed');
                    mainContainer.classList.toggle('sidebar-collapsed');
                });
            }
        }

        // Form functions
        function resetForm() {
            document.getElementById('cbcustomername').value = '';
            document.getElementById('ADate1').value = '<?php echo $transactiondatefrom; ?>';
            document.getElementById('ADate2').value = '<?php echo $transactiondateto; ?>';
        }

        // Utility functions
        function refreshPage() {
            window.location.reload();
        }

        function exportToExcel() {
            const table = document.getElementById('reportTable');
            if (table) {
                // Simple CSV export
                let csv = [];
                const rows = table.querySelectorAll('tr');
                
                for (let i = 0; i < rows.length; i++) {
                    const row = [], cols = rows[i].querySelectorAll('td, th');
                    
                    for (let j = 0; j < cols.length; j++) {
                        row.push(cols[j].innerText);
                    }
                    csv.push(row.join(','));
                }
                
                const csvContent = csv.join('\n');
                const blob = new Blob([csvContent], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'caft_sales_credit_report.csv';
                a.click();
                window.URL.revokeObjectURL(url);
            }
        }

        // Add CSS for text alignment
        const style = document.createElement('style');
        style.textContent = `
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .grand-total-row { background-color: var(--background-accent); font-weight: bold; }
            .grand-total-row td { border-top: 2px solid var(--medstar-primary); }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>