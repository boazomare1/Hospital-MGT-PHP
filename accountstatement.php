<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$subtype_ano='';
$res1mrdno ='';
$exchange_rate=1;
$currency=0;
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "0";
$colorloopcount="";
$range = "";
$total30=0;
$total60=0;
$total90=0;
$total120=0;
$total180=0;
$total210=0;
$res11transactionamount='0';
$res12transactionamount='0';
$res2transactionamount=0;
$res3transactionamount=0;
$res4transactionamount=0;
$res5transactionamount=0;
$res6transactionamount=0;
$restot='0';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $paymentreceiveddatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $paymentreceiveddateto; }
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

$searchsuppliername=trim($searchsuppliername);
$searchsuppliername=rtrim($searchsuppliername);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Statement - Poplar Hospital</title>
    <link rel="stylesheet" type="text/css" href="css/accountstatement-modern.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="js/accountstatement-modern.js?v=<?php echo time(); ?>"></script>
</head>
<body>
<?php include ("includes/alertmessages1.php"); ?>
<?php include ("includes/title1.php"); ?>
<?php include ("includes/menu1.php"); ?>

<!-- Modern Header -->
<header class="modern-header">
    <div class="header-content">
        <div>
            <h1 class="header-title">Account Statement</h1>
            <p class="header-subtitle">View detailed account transactions and balances</p>
        </div>
    </div>
</header>

<!-- Breadcrumb -->
<nav class="breadcrumb">
    <div class="breadcrumb-content">
        <a href="mainmenu1.php" class="breadcrumb-item">Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Account Statement</span>
    </div>
</nav>

<!-- Floating Menu Toggle -->
<button id="menuToggle" class="floating-menu-toggle" title="Toggle Menu (Ctrl+M)">
    <span>☰</span>
</button>

<!-- Main Container with Sidebar -->
<div class="main-container-with-sidebar">
    <!-- Left Sidebar -->
    <aside id="leftSidebar" class="left-sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Quick Navigation</h3>
            <button id="sidebarToggle" class="sidebar-toggle" title="Toggle Sidebar">×</button>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section">
                <h4 class="sidebar-section-title">Main Menu</h4>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="mainmenu1.php" class="sidebar-menu-link">
                            <span class="sidebar-menu-icon">🏠</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="accountstatement.php" class="sidebar-menu-link active">
                            <span class="sidebar-menu-icon">📊</span>
                            Account Statement
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="sidebar-section">
                <h4 class="sidebar-section-title">Reports</h4>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="corporateoutstanding.php" class="sidebar-menu-link">
                            <span class="sidebar-menu-icon">💰</span>
                            Corporate Outstanding
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="accountreceivableentrylist.php" class="sidebar-menu-link">
                            <span class="sidebar-menu-icon">📋</span>
                            Account Receivable
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Account Statement</h1>
            <p class="page-description">Search and view detailed account transactions with aging analysis</p>
        </div>

        <!-- Search Form -->
        <form id="accountStatementForm" class="search-form">
            <h2 class="form-title">Search Account</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="searchAccountName" class="form-label">Account Name</label>
                    <input type="text" id="searchAccountName" name="searchAccountName" class="form-input" placeholder="Type to search accounts..." autocomplete="off">
                    <input type="hidden" id="searchAccountCode" name="searchAccountCode" value="<?php echo $searchsuppliercode; ?>">
                    <input type="hidden" id="searchAccountAnum" name="searchAccountAnum" value="<?php echo $searchsupplieranum; ?>">
                </div>
                <div class="form-group">
                    <label for="dateFrom" class="form-label">Date From</label>
                    <input type="date" id="dateFrom" name="dateFrom" class="form-input" value="<?php echo $ADate1; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="dateTo" class="form-label">Date To</label>
                    <input type="date" id="dateTo" name="dateTo" class="form-input" value="<?php echo $ADate2; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" style="display: none; text-align: center; padding: 2rem;">
            <div style="font-size: 1.5rem; color: #6b7280;">Loading account statement...</div>
        </div>

        <!-- Summary Cards -->
        <div id="summaryCards" class="summary-cards" style="display: none;">
            <div class="summary-card">
                <div class="summary-card-title">Opening Balance</div>
                <div class="summary-card-value" id="openingBalance">₹0.00</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-title">Total Debit</div>
                <div class="summary-card-value" id="totalDebit">₹0.00</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-title">Total Credit</div>
                <div class="summary-card-value" id="totalCredit">₹0.00</div>
            </div>
            <div class="summary-card">
                <div class="summary-card-title">Current Balance</div>
                <div class="summary-card-value" id="currentBalance">₹0.00</div>
            </div>
        </div>

        <!-- Aging Analysis Cards -->
        <div id="agingCards" class="summary-cards" style="display: none;">
            <div class="summary-card aging-30">
                <div class="summary-card-title">30 Days</div>
                <div class="summary-card-value" id="aging30">₹0.00</div>
            </div>
            <div class="summary-card aging-60">
                <div class="summary-card-title">60 Days</div>
                <div class="summary-card-value" id="aging60">₹0.00</div>
            </div>
            <div class="summary-card aging-90">
                <div class="summary-card-title">90 Days</div>
                <div class="summary-card-value" id="aging90">₹0.00</div>
            </div>
            <div class="summary-card aging-120">
                <div class="summary-card-title">120 Days</div>
                <div class="summary-card-value" id="aging120">₹0.00</div>
            </div>
            <div class="summary-card aging-180">
                <div class="summary-card-title">180 Days</div>
                <div class="summary-card-value" id="aging180">₹0.00</div>
            </div>
            <div class="summary-card aging-180-plus">
                <div class="summary-card-title">180+ Days</div>
                <div class="summary-card-value" id="aging180Plus">₹0.00</div>
            </div>
        </div>

        <!-- Account Information -->
        <div id="accountInfo" class="search-form" style="display: none;">
            <h2 class="form-title">Account Information</h2>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Account Name</label>
                    <div class="form-input" style="background: #f9fafb; font-weight: 600;" id="accountName">-</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Account Code</label>
                    <div class="form-input" style="background: #f9fafb; font-weight: 600;" id="accountCode">-</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Currency</label>
                    <div class="form-input" style="background: #f9fafb; font-weight: 600;" id="accountCurrency">-</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Exchange Rate</label>
                    <div class="form-input" style="background: #f9fafb; font-weight: 600;" id="exchangeRate">-</div>
                </div>
            </div>
        </div>

        <!-- Data Table Container -->
        <div class="data-table-container">
            <div class="table-header">
                <h3 class="table-title">Transaction Details</h3>
                <div class="table-controls">
                    <div class="table-filters">
                        <div class="filter-group">
                            <label for="transactionSearch" class="filter-label">Search Transactions</label>
                            <input type="text" id="transactionSearch" class="filter-input" placeholder="Search by description, bill number, or MRD...">
                        </div>
                        <button onclick="clearFilters()" class="btn btn-secondary" style="margin-top: 1.5rem;">Clear Filters</button>
                    </div>
                    <div class="table-actions">
                        <button onclick="exportToExcel()" class="btn btn-success">📊 Excel</button>
                        <button onclick="exportToPDF()" class="btn btn-success">📄 PDF</button>
                    </div>
                </div>
            </div>

            <table class="modern-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>MRD No</th>
                        <th>Bill Number</th>
                        <th>Dispatch Date</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Days</th>
                        <th>Current Balance</th>
                    </tr>
                </thead>
                <tbody id="statementTableBody">
                    <tr>
                        <td colspan="10" class="no-data">Search for an account to view transactions</td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination" style="display: none;">
                <div class="pagination-info">Showing 0 to 0 of 0 transactions</div>
                <div class="pagination-controls"></div>
            </div>
        </div>
    </main>
</div>

<?php include ("includes/footer1.php"); ?>
</body>
</html>
