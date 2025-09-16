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
$sno = 0;
$colorloopcount = '';
$totalcost = 0.00;
$docno = $_SESSION['docno'];

// Get location options
$query = "SELECT * FROM login_locationdetails WHERE username='$username' AND docno='$docno' ORDER BY locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));

// Initialize variables
$totalSales = 0;
$totalCOGS = 0;
$totalRevenue = 0;
$totalItems = 0;
$stockData = [];

// Process form submission
if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if (isset($_REQUEST["ADate1"])) { 
    $fromdate = $_REQUEST["ADate1"]; 
} else { 
    $fromdate = $transactiondatefrom; 
}

if (isset($_REQUEST["ADate2"])) { 
    $todate = $_REQUEST["ADate2"]; 
} else { 
    $todate = $transactiondateto; 
}

if (isset($_REQUEST["store"])) { 
    $store = $_REQUEST["store"]; 
} else { 
    $store = ""; 
}

if (isset($_REQUEST["locationcode"])) { 
    $locationcode = $_REQUEST["locationcode"]; 
} else { 
    $locationcode = ""; 
}

if (isset($_REQUEST["searchitemcode"])) { 
    $searchitemcode = $_REQUEST["searchitemcode"]; 
} else { 
    $searchitemcode = ""; 
}

if (isset($_REQUEST["categoryname"])) { 
    $categoryname = $_REQUEST["categoryname"]; 
} else { 
    $categoryname = ""; 
}

// Process report generation
if ($frmflag1 == 'frmflag1') {
    $totalSales = 0;
    $totalCOGS = 0;
    $totalRevenue = 0;
    $totalItems = 0;
    
    if (trim($searchitemcode) != '') {
        // Search for specific item
        $query1 = "SELECT entrydocno, itemname, itemcode, transaction_date, transaction_quantity, fifo_code 
                   FROM transaction_stock 
                   WHERE transaction_date BETWEEN '$fromdate' AND '$todate' 
                   AND itemcode = '$searchitemcode' 
                   AND locationcode = '$locationcode' 
                   AND storecode = '$store' 
                   GROUP BY itemcode";
        
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while ($res1 = mysqli_fetch_array($exec1)) {
            $itemcode = $res1['itemcode'];
            $itemname = $res1['itemname'];
            
            // Get item pricing
            $query2 = "SELECT purchaseprice, rateperunit FROM master_medicine WHERE itemcode = '$itemcode'";
            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2: " . mysqli_error($GLOBALS["___mysqli_ston"]));
            $res2 = mysqli_fetch_array($exec2);
            
            $costPrice = $res2['purchaseprice'];
            $salesPrice = $res2['rateperunit'];
            
            // Get sales quantity
            $query3 = "SELECT SUM(transaction_quantity) as qty 
                       FROM transaction_stock 
                       WHERE itemcode = '$itemcode' 
                       AND description IN ('IP Direct Sales', 'Sales') 
                       AND transaction_date BETWEEN '$fromdate' AND '$todate' 
                       AND storecode = '$store' 
                       AND locationcode = '$locationcode'";
            
            $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3: " . mysqli_error($GLOBALS["___mysqli_ston"]));
            $res3 = mysqli_fetch_array($exec3);
            $salesQty = $res3['qty'] ?: 0;
            
            // Calculate COGS and Revenue
            $cogs = $salesQty * $costPrice;
            $revenue = $salesQty * $salesPrice;
            
            // Get current stock
            $query7 = "SELECT SUM(transaction_quantity) as qty 
                       FROM transaction_stock 
                       WHERE itemcode = '$itemcode' 
                       AND batch_stockstatus = '1' 
                       AND storecode = '$store' 
                       AND locationcode = '$locationcode'";
            
            $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in Query7: " . mysqli_error($GLOBALS["___mysqli_ston"]));
            $res7 = mysqli_fetch_array($exec7);
            $currentQty = $res7['qty'] ?: 0;
            
            $stockData[] = [
                'itemcode' => $itemcode,
                'itemname' => $itemname,
                'costprice' => $costPrice,
                'salesprice' => $salesPrice,
                'currentqty' => $currentQty,
                'salesqty' => $salesQty,
                'cogs' => $cogs,
                'revenue' => $revenue
            ];
            
            $totalSales += $salesQty;
            $totalCOGS += $cogs;
            $totalRevenue += $revenue;
            $totalItems++;
        }
    } else {
        // Search by category
        if (trim($categoryname) != '') {
            $query10 = "SELECT itemcode, purchaseprice, rateperunit 
                        FROM master_medicine 
                        WHERE categoryname LIKE '%$categoryname%' 
                        AND status <> 'DELETED' 
                        GROUP BY itemcode";
        } else {
            $query10 = "SELECT itemcode, purchaseprice, rateperunit 
                        FROM master_medicine 
                        WHERE itemcode = '$searchitemcode' 
                        AND categoryname LIKE '%$categoryname%' 
                        AND status <> 'DELETED' 
                        GROUP BY itemcode";
        }
        
        $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10: " . mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while ($res10 = mysqli_fetch_array($exec10)) {
            $itemcode = $res10['itemcode'];
            $costPrice = $res10['purchaseprice'];
            $salesPrice = $res10['rateperunit'];
            
            // Get item name
            $query1 = "SELECT entrydocno, itemname, itemcode, transaction_date, transaction_quantity, fifo_code 
                       FROM transaction_stock 
                       WHERE transaction_date BETWEEN '$fromdate' AND '$todate' 
                       AND itemcode = '$itemcode' 
                       AND storecode = '$store' 
                       AND locationcode = '$locationcode' 
                       GROUP BY itemcode";
            
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1: " . mysqli_error($GLOBALS["___mysqli_ston"]));
            
            if (mysqli_num_rows($exec1) > 0) {
                $res1 = mysqli_fetch_array($exec1);
                $itemname = $res1['itemname'];
                
                // Get sales quantity
                $query3 = "SELECT SUM(transaction_quantity) as qty 
                           FROM transaction_stock 
                           WHERE itemcode = '$itemcode' 
                           AND description IN ('IP Direct Sales', 'Sales') 
                           AND transaction_date BETWEEN '$fromdate' AND '$todate' 
                           AND storecode = '$store' 
                           AND locationcode = '$locationcode'";
                
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                $salesQty = $res3['qty'] ?: 0;
                
                // Calculate COGS and Revenue
                $cogs = $salesQty * $costPrice;
                $revenue = $salesQty * $salesPrice;
                
                // Get current stock
                $query7 = "SELECT SUM(transaction_quantity) as qty 
                           FROM transaction_stock 
                           WHERE itemcode = '$itemcode' 
                           AND batch_stockstatus = '1' 
                           AND storecode = '$store' 
                           AND locationcode = '$locationcode'";
                
                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in Query7: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                $res7 = mysqli_fetch_array($exec7);
                $currentQty = $res7['qty'] ?: 0;
                
                $stockData[] = [
                    'itemcode' => $itemcode,
                    'itemname' => $itemname,
                    'costprice' => $costPrice,
                    'salesprice' => $salesPrice,
                    'currentqty' => $currentQty,
                    'salesqty' => $salesQty,
                    'cogs' => $cogs,
                    'revenue' => $revenue
                ];
                
                $totalSales += $salesQty;
                $totalCOGS += $cogs;
                $totalRevenue += $revenue;
                $totalItems++;
            }
        }
    }
}

// Get store options for selected location
$storeOptions = [];
if ($locationcode) {
    $query5 = "SELECT ms.auto_number, ms.storecode, ms.store 
               FROM master_employeelocation as me 
               LEFT JOIN master_store as ms ON me.storecode = ms.auto_number 
               WHERE me.locationcode = '$locationcode' 
               AND me.username = '$username'";
    
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in Query5: " . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res5 = mysqli_fetch_array($exec5)) {
        $storeOptions[] = [
            'value' => $res5['auto_number'],
            'text' => $res5['store']
        ];
    }
}

// Get category options
$query42 = "SELECT * FROM master_medicine WHERE status = '' GROUP BY categoryname ORDER BY categoryname";
$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die("Error in Query42: " . mysqli_error($GLOBALS["___mysqli_ston"]));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Current Stock Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/revenuecurrentstock-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Revenue Current Stock Report</span>
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
                        <a href="stockinward1.php" class="nav-link">
                            <i class="fas fa-arrow-down"></i>
                            <span>Stock Inward</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockoutward1.php" class="nav-link">
                            <i class="fas fa-arrow-up"></i>
                            <span>Stock Outward</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="currentstock1.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Current Stock</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="revenuecurrentstock.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Revenue Stock Report</span>
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
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Revenue Current Stock Report</h2>
                    <p>Generate comprehensive revenue and stock analysis reports for your inventory management.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportReport()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="downloadPDF()">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <?php if ($frmflag1 == 'frmflag1'): ?>
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-icon total-sales">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="summary-card-number"><?php echo number_format($totalSales, 0); ?></div>
                    <div class="summary-card-label">Total Sales Qty</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon total-cogs">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="summary-card-number">₹<?php echo number_format($totalCOGS, 2); ?></div>
                    <div class="summary-card-label">Total COGS</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon total-revenue">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="summary-card-number">₹<?php echo number_format($totalRevenue, 2); ?></div>
                    <div class="summary-card-label">Total Revenue</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon total-items">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="summary-card-number"><?php echo $totalItems; ?></div>
                    <div class="summary-card-label">Total Items</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Search Form Section -->
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-search search-icon"></i>
                    <h3 class="search-title">Generate Revenue Stock Report</h3>
                </div>
                
                <form id="searchForm" name="form1" method="post" action="revenuecurrentstock.php" class="search-form">
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <select name="locationcode" id="location" class="form-select" required>
                            <option value="">Select Location</option>
                            <?php
                            if ($exec) {
                                while ($locationRow = mysqli_fetch_array($exec)) {
                                    $selected = ($locationcode == $locationRow['locationcode']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($locationRow['locationcode']) . "' $selected>" . htmlspecialchars($locationRow['locationname']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Store</label>
                        <select name="store" id="store" class="form-select" required>
                            <option value="">Select Store</option>
                            <?php
                            foreach ($storeOptions as $storeOption) {
                                $selected = ($store == $storeOption['value']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($storeOption['value']) . "' $selected>" . htmlspecialchars($storeOption['text']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">From Date</label>
                        <input type="date" name="ADate1" id="dateFrom" class="form-input" 
                               value="<?php echo $fromdate; ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">To Date</label>
                        <input type="date" name="ADate2" id="dateTo" class="form-input" 
                               value="<?php echo $todate; ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Item Code (Optional)</label>
                        <input type="text" name="searchitemcode" id="searchitemcode" class="form-input" 
                               value="<?php echo htmlspecialchars($searchitemcode); ?>" 
                               placeholder="Enter specific item code">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category (Optional)</label>
                        <select name="categoryname" id="category" class="form-select">
                            <option value="">All Categories</option>
                            <?php
                            if ($exec42) {
                                while ($categoryRow = mysqli_fetch_array($exec42)) {
                                    $selected = ($categoryname == $categoryRow['categoryname']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($categoryRow['categoryname']) . "' $selected>" . htmlspecialchars($categoryRow['categoryname']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-chart-line"></i> Generate Report
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag1" value="frmflag1" />
                </form>
            </div>

            <!-- Stock Report Section -->
            <?php if ($frmflag1 == 'frmflag1'): ?>
            <div class="stock-report-section">
                <div class="stock-report-header">
                    <div class="stock-report-title">
                        <i class="fas fa-chart-line"></i>
                        Revenue Current Stock Report
                        <span class="results-count"><?php echo $totalItems; ?></span>
                    </div>
                    <div class="stock-report-actions">
                        <input type="text" id="tableSearch" placeholder="Search items..." class="form-input" style="width: 200px;">
                    </div>
                </div>

                <div class="data-table-container">
                    <table id="dataTable" class="data-table">
                        <thead>
                            <tr>
                                <th data-sortable="true" data-column="sno">S.No.</th>
                                <th data-sortable="true" data-column="item">Item</th>
                                <th data-sortable="true" data-column="costprice">Cost Price</th>
                                <th data-sortable="true" data-column="salesprice">Sales Price</th>
                                <th data-sortable="true" data-column="currentqty">Current Qty</th>
                                <th data-sortable="true" data-column="salesqty">Sales Qty</th>
                                <th data-sortable="true" data-column="cogs">COGS</th>
                                <th data-sortable="true" data-column="revenue">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($stockData)) {
                                $counter = 1;
                                foreach ($stockData as $item) {
                                    ?>
                                    <tr>
                                        <td data-column="sno"><?php echo $counter++; ?></td>
                                        <td data-column="item">
                                            <div class="item-name"><?php echo htmlspecialchars($item['itemname']); ?></div>
                                            <div class="item-code"><?php echo htmlspecialchars($item['itemcode']); ?></div>
                                        </td>
                                        <td data-column="costprice">
                                            <span class="price cost">₹<?php echo number_format($item['costprice'], 2); ?></span>
                                        </td>
                                        <td data-column="salesprice">
                                            <span class="price sales">₹<?php echo number_format($item['salesprice'], 2); ?></span>
                                        </td>
                                        <td data-column="currentqty">
                                            <span class="quantity current"><?php echo number_format($item['currentqty'], 0); ?></span>
                                        </td>
                                        <td data-column="salesqty">
                                            <span class="quantity sales"><?php echo number_format($item['salesqty'], 0); ?></span>
                                        </td>
                                        <td data-column="cogs">
                                            <span class="price cogs">₹<?php echo number_format($item['cogs'], 2); ?></span>
                                        </td>
                                        <td data-column="revenue">
                                            <span class="price revenue">₹<?php echo number_format($item['revenue'], 2); ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                
                                // Summary row
                                ?>
                                <tr class="summary-row">
                                    <td colspan="2" class="summary-label">TOTAL</td>
                                    <td class="summary-value">-</td>
                                    <td class="summary-value">-</td>
                                    <td class="summary-value"><?php echo number_format(array_sum(array_column($stockData, 'currentqty')), 0); ?></td>
                                    <td class="summary-value"><?php echo number_format($totalSales, 0); ?></td>
                                    <td class="summary-value">₹<?php echo number_format($totalCOGS, 2); ?></td>
                                    <td class="summary-value">₹<?php echo number_format($totalRevenue, 2); ?></td>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8" class="no-data">
                                        <div class="no-data-icon">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <h3>No Stock Data Found</h3>
                                        <p>No stock data found for the selected criteria. Try adjusting your search parameters.</p>
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
    <script src="js/revenuecurrentstock-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript Functions -->
    <script type="text/javascript">
        function disableEnterKey() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode;
                return false;
            }
        }

        function Locationcheck() {
            return true;
        }
    </script>
</body>
</html>
