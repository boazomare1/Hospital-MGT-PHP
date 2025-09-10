<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ADate1='2000-01-01';

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
$exchange_rate=1;

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
<html>
<head>
<title>Corporate Outstanding - MedStar Hospital</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script>
function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Account Name.');
return false;
}
else
{
if((document.getElementById("searchsuppliercode").value == "")||(document.getElementById("searchsuppliercode").value == " "))
{
alert('Please Select Account Name.');
return false;
}
} 
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>

<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" href="css/corporateoutstanding-modern.css">      
<script>
$(document).ready(function(e) {
   
		$('#searchsuppliername').autocomplete({
		
	
	source:"ajaxaccount_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchsuppliercode").val(accountid);
			$("#searchsupplieranum").val(accountanum);
			
			},
    
	});
		
});
</script>
</head>

<body>

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Corporate Outstanding Management System</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>→</span>
        <a href="#">📊 Reports</a>
        <span>→</span>
        <span>💼 Corporate Outstanding</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="menuToggle" title="Toggle Menu (Ctrl+M)">
        <span class="toggle-icon">☰</span>
    </button>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside class="left-sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <h3>💼 Corporate Management</h3>
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                    <span class="toggle-icon">☰</span>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <span class="nav-icon">🏠</span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <span class="nav-icon">💼</span>
                            <span class="nav-text">Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Outstanding Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">📈</span>
                            <span class="nav-text">Aging Analysis</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content-area">
            <!-- Page Header -->
            <div class="page-header">
                <h2 class="page-title">
                    <span class="section-icon">💼</span>
                    Corporate Outstanding Report
                </h2>
                <p class="page-subtitle">Track and manage outstanding corporate receivables with aging analysis and detailed reporting.</p>
            </div>

            <!-- Alert Messages -->
            <?php include ("includes/alertmessages1.php"); ?>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="section-header">
                    <span class="section-icon">🔍</span>
                    <h3 class="section-title">Search Corporate Outstanding</h3>
                </div>

                <form name="cbform1" method="post" action="corporateoutstanding.php" id="searchForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Search Account</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" class="form-input" placeholder="Enter account name or code" autocomplete="off">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" />
                            <input name="searchsupplieranum" type="hidden" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">As On Date</label>
                            <input name="ADate2" id="ADate2" class="form-input" value="<?php echo $ADate2; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                        </div>

                        <div class="form-group form-actions">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" class="btn btn-primary" onClick="return funcAccount();">🔍 Search</button>
                            <button type="reset" class="btn btn-secondary">🔄 Reset</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards" id="summaryCards" style="display: none;">
                <div class="summary-card">
                    <div class="summary-value" id="totalOutstanding">₹0.00</div>
                    <div class="summary-label">Total Outstanding</div>
                </div>
                <div class="summary-card">
                    <div class="summary-value" id="totalCount">0</div>
                    <div class="summary-label">Total Records</div>
                </div>
                <div class="summary-card warning">
                    <div class="summary-value" id="aging30">₹0.00</div>
                    <div class="summary-label">0-30 Days</div>
                </div>
                <div class="summary-card danger">
                    <div class="summary-value" id="aging90">₹0.00</div>
                    <div class="summary-label">90+ Days</div>
                </div>
            </div>

            <!-- Data Section -->
            <div class="data-section">
                <div class="section-header">
                    <span class="section-icon">📊</span>
                    <h3 class="section-title">Outstanding Transactions</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="search-filter-bar">
                    <div class="search-section">
                        <input type="text" id="transactionSearch" class="search-input" placeholder="Search transactions...">
                        <button type="button" class="btn btn-primary btn-sm" onclick="filterTransactions()">🔍 Search</button>
                    </div>
                    <div class="filter-section">
                        <select id="ageFilter" class="form-select">
                            <option value="">All Ages</option>
                            <option value="0-30">0-30 Days</option>
                            <option value="31-60">31-60 Days</option>
                            <option value="61-90">61-90 Days</option>
                            <option value="91-120">91-120 Days</option>
                            <option value="120+">120+ Days</option>
                        </select>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="clearFilters()">🔄 Clear</button>
                    </div>
                </div>

                <!-- Data Table with Pagination -->
                <div class="table-container">
                    <table class="data-table" id="outstandingTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>MRD No</th>
                                <th>Bill Number</th>
                                <th>Disp. Date</th>
                                <th>Amount</th>
                                <th>Outstanding</th>
                                <th>Days</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="outstandingTableBody">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Controls -->
                <div class="pagination-controls">
                    <div class="pagination-info">
                        Showing <span id="startIndex">0</span> to <span id="endIndex">0</span> of <span id="totalItems">0</span> transactions
                    </div>
                    <div class="pagination-buttons">
                        <button class="pagination-btn" id="prevBtn" onclick="previousPage()" disabled>← Previous</button>
                        <div class="page-numbers" id="pageNumbers"></div>
                        <button class="pagination-btn" id="nextBtn" onclick="nextPage()" disabled>Next →</button>
                    </div>
                    <div class="items-per-page">
                        <label for="itemsPerPage">Items per page:</label>
                        <select id="itemsPerPage" class="items-select" onchange="changeItemsPerPage()">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script src="js/corporateoutstanding-modern.js"></script>

<?php include ("includes/footer1.php"); ?>

</body>
</html>















