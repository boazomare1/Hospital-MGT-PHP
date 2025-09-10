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
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_account2.php");
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $paymentreceiveddatefrom; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $paymentreceiveddateto; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
$searchsuppliername=trim($searchsuppliername);
$searchsuppliername=rtrim($searchsuppliername);
?>
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
<!--<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>-->
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
</head>

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

            <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            ?>
			<?php
			// Old PHP code removed - now handled by AJAX
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
				// Data loading is now handled by get_corporate_outstanding.php via AJAX
			}
			?>

        </main>
    </div>

    <!-- JavaScript for Modern Functionality -->
    <script>
        // Global variables
        let currentPage = 1;
        let itemsPerPage = 10;
        let allTransactions = [];
        let filteredTransactions = [];

        // Initialize when document is ready
        $(document).ready(function() {
            loadTransactions();
            setupEventListeners();
            setupSidebar();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Search input event
            $('#transactionSearch').on('input', function() {
                filterTransactions();
            });

            // Age filter change
            $('#ageFilter').on('change', function() {
                filterTransactions();
            });

            // Keyboard shortcut for menu toggle
            $(document).on('keydown', function(e) {
                if (e.ctrlKey && e.key === 'm') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
        }
    </script>
    <script src="js/corporateoutstanding-modern.js"></script>

<?php include ("includes/footer1.php"); ?>

</body>
</html>
								 UNION ALL SELECT SUM(a.`totalamountuhx`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`accountnameid` = '$id' AND b.billtype = 'PAY LATER' AND a.`transactiondate` <  '$ADate1'
								 UNION ALL SELECT SUM(`fxamount`) as paylater FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` <  '$ADate1'
								 UNION ALL SELECT SUM(`debitamount`) as paylater FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` <  '$ADate1'
								 UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `billnumber` LIKE '%IPCr%' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'paylatercredit'
								
								 UNION ALL SELECT SUM(-1*`openbalanceamount`) as paylater FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` <  '$ADate1'
								 UNION ALL SELECT SUM(-1*`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` <  '$ADate1' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT SUM(-1*`creditamount`) as paylater FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1op) or die ("Error in querycr1op".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						$paylater = $rescr1['paylater'];
							$paylater = $paylater / $exchange_rate;
						$openingbalance += $paylater;
						}
				?>
                <tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
				
              <td width="9%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="35%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong> Opening Balance </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>
                <td width="20%" align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>
                <td width="20%" align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>
                <td width="20%" align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="16%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td width="16%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',','); ?></strong></div></td>
				</tr>
            <?php
	$totaldebit=0;		
$debit=0;
$credit1=0;
$credit2=0;
$totalpayment=0;
$totalcredit='0';
$resamount=0;
$totalamount30 = 0;
					$totalamount60 = 0;
					$totalamount90 = 0;
					$totalamount120 = 0;
					$totalamount180 = 0;
					$totalamountgreater = 0;
			$totalamountgreater=0;
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			//$searchsuppliername1 = trim($searchsuppliername1);
		  
	  $queryunion="select groupdate,patientcode,patientname,visitcode,billnumber,particulars,subtype,subtypeano,accountname,fxamount,auto_number,transactiontype from(select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum' and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%'
	  
	  union all select transactiondate as groupdate, patientcode,'opening balance' as patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, transactionamount as fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'  and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%'
	  
	   union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount,docno,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'
	   
	    union all select b.transactiondate as groupdate,b.patientcode as patientcode,b.patientname as patientname,b.visitcode as visitcode,b.billnumber as billnumber,b.particulars as particulars,b.transactionmode as transactionmode,b.subtypeano as subtypeano,b.accountname as accountname,b.fxamount as fxamount,b.docno as docno,b.transactiontype as transactiontype FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$searchsuppliercode' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'
	   
	    union all select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, transactionmode, subtypeano, chequenumber, fxamount, docno, transactiontype from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')
		
		union all select entrydate as groupdate,'' as patientcode,'' as patientname,'' as visitcode,docno as billnumber,narration as particulars,selecttype as transactionmode,selecttype as subtypeano,'' as chequenumber,transactionamount as fxamount, auto_number,vouchertype as transactiontype FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as t order by groupdate asc";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryunion) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$transactiontype = $res2['transactiontype'];
	if($transactiontype=='finalize')
			{
				$res2transactiondate = $res2['groupdate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				if($res2patientname==''){
				$res2patientname = $particulars;
				}
				$anum = $res2['auto_number'];

				$res2transactionamount = $res2['fxamount']/$exchange_rate;
				
				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno1 = mysqli_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$res2mrdno='';
				
				$totalpayment = 0;
				
				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				$payment = $res98['transactionamount1']/$exchange_rate;
				$totalpayment = $totalpayment + $payment;
				}
									
				$res2transactionamount = $res2transactionamount - $totalpayment;
				
				if($res2transactionamount != '0')
				{
				$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
						$t2 = strtotime($res2transactiondate);
						$days_between = ceil(abs($t1 - $t2) / 86400);
						$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
						$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$resmrdno1 = mysqli_fetch_array($execmrdno1);
						$res1mrdno = $resmrdno1['mrdno'];
						if($snocount == 1)
						{
							$total = $openingbalance + $res2transactionamount;
						}
						else
						{
							$total = $total + $res2transactionamount;
						}
						
						if($days_between <= 30)
						{
							if($snocount == 1)
							{
								$totalamount30 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount30 = $totalamount30 + $res2transactionamount;
							}
						}
						else if(($days_between >30) && ($days_between <=60))
						{
							if($snocount == 1)
							{
								$totalamount60 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount60 = $totalamount60 + $res2transactionamount;
							}
						}
						else if(($days_between >60) && ($days_between <=90))
						{
							if($snocount == 1)
							{
								$totalamount90 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount90 = $totalamount90 + $res2transactionamount;
							}
						}
						else if(($days_between >90) && ($days_between <=120))
						{
							if($snocount == 1)
							{
								$totalamount120 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount120 = $totalamount120 + $res2transactionamount;
							}
						}
						else if(($days_between >120) && ($days_between <=180))
						{
							if($snocount == 1)
							{
								$totalamount180 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount180 = $totalamount180 + $res2transactionamount;
							}
						}
						else
						{
							if($snocount == 1)
							{
								$totalamountgreater = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamountgreater = $totalamountgreater + $res2transactionamount;
							}
						}
						
						
		 			
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>) <?php echo $particulars ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>

        
        <?php 
        $bill_fetch="SELECT updatedate from completed_billingpaylater where billno='$res2billnumber' ";
        $exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec_bill);

        ?>

        <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31">
          <!-- <p style='color:red; text-align:center;'> -->
          <?php 
          if(isset($res2['updatedate'])){
            echo date("Y-m-d", strtotime($res2['updatedate']));
          }else{ echo "<p style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----</p>";
          }
           ?>
             
           <!-- </p> -->
         </div></td>


                            
              <td class="bodytext31" valign="center"  align="right">
          
			    <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="right">
			    <div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left">
                            <div align="center"><?php echo $days_between; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
              
           </tr>
			<?php
				
			$res2transactionamount=0;
			$resamount=0;
			
			}
			$res2transactionamount=0;
			$resamount=0;
			
			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
			
			}
			//echo '<br>'.$total;
			if($transactiontype=='JOURNAL')
			{
				$totalpayment = 0;
				$res2transactiondate = $res2['groupdate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				if($res2patientname==''){
				$res2patientname = $particulars;
				}
				$anum = $res2['auto_number'];

				
				if($res2['subtypeano'] == 'Cr')
				{
			    $query7="SELECT  -1*`creditamount` as fxamount FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Cr' and auto_number = '".$res2['auto_number']."'";
				}
				else
				{
				$query7="SELECT  `debitamount` as fxamount  FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Dr' and auto_number = '".$res2['auto_number']."'";
				}
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
				$res2transactionamount = $res7['fxamount']/$exchange_rate;				
				$res2transactionamount = $res2transactionamount - $totalpayment;
				
				if($res2transactionamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res2transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					if($snocount == 1)
						{
							$total = $openingbalance + $res2transactionamount;
						}
						else
						{
							$total = $total + $res2transactionamount;
						}
						if($days_between <= 30)
						{
							if($snocount == 1)
							{
								$totalamount30 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount30 = $totalamount30 + $res2transactionamount;
							}
						}
						else if(($days_between >30) && ($days_between <=60))
						{
							if($snocount == 1)
							{
								$totalamount60 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount60 = $totalamount60 + $res2transactionamount;
							}
						}
						else if(($days_between >60) && ($days_between <=90))
						{
							if($snocount == 1)
							{
								$totalamount90 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount90 = $totalamount90 + $res2transactionamount;
							}
						}
						else if(($days_between >90) && ($days_between <=120))
						{
							if($snocount == 1)
							{
								$totalamount120 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount120 = $totalamount120 + $res2transactionamount;
							}
						}
						else if(($days_between >120) && ($days_between <=180))
						{
							if($snocount == 1)
							{
								$totalamount180 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount180 = $totalamount180 + $res2transactionamount;
							}
						}
						else
						{
							if($snocount == 1)
							{
								$totalamountgreater = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamountgreater = $totalamountgreater + $res2transactionamount;
							}
						}
						
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td> 
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>

              <?php if($res2transactionamount > 0)
			  {
			  ?>     
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="right">
			    <div align="right"></div></td>
          
			<?php
			}
			else
			{
				?>

				 <td class="bodytext31" valign="center"  align="right">
			    <div align="right"></div></td>
				 <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format(-1*$res2transactionamount,2,'.',','); ?></div></td>
				<?php
				}
				?>
        
               <td class="bodytext31" valign="center"  align="left">
                            <div align="center"><?php echo $days_between; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
              
           </tr>
			<?php
						
			$res2transactionamount=0;
			$resamount=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			if(substr($res2billnumber,0,4)=="IPDr"){
					continue;
				}
}
	if($transactiontype=='paylatercredit')
			{
		
				$respaylatercreditpayment=0;
				$res6transactiondate = $res2['groupdate'];
				$res6patientname = $res2['patientname'];
				$res6patientcode = $res2['patientcode'];
				$res6visitcode = $res2['visitcode'];
				$res6billnumber = $res2['billnumber'];
				$res6transactionmode = $res2['subtype'];
				$res6docno = $res2['auto_number'];
				$particulars = $res2['particulars'];
				
				$res6transactionamount = $res2['fxamount']/$exchange_rate;
						
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				$query47 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
				$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res47 = mysqli_fetch_array($exec47))
				{
					$paylatercreditpayment = $res47['transactionamount1']/$exchange_rate;
					
					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
				}
				$query57 = "select patientvisitcode from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
							$exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							$num57 = mysqli_num_rows($exec57);							
							if($num57 != 0)
							{
								$lab = "Lab";
							}
							else
							{
								$lab = "";
							}
							
							$query58 = "select patientvisitcode from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
							$exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							$num58 = mysqli_num_rows($exec58);							
							if($num58 != 0)
							{
								$rad = "Rad";
							}
							else
							{
								$rad = "";
							}
							
							$query59 = "select patientvisitcode from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
							$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							$num59 = mysqli_num_rows($exec59);							
							if($num59 != 0)
							{
								$ser = "Services";
							}
							else
							{
								$ser = "";
							}
				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($res6transactionamount != 0)
				{
					
					if($snocount == 1)
						{
							$total = $openingbalance - $res6transactionamount;
						}
						else
						{
							$total = $total - $res6transactionamount;
						}
					
					if($days_between <= 30)
							{
								$totalamount30 = $totalamount30 - $res6transactionamount;							
							}
							else if(($days_between >30) && ($days_between <=60))
							{						
								$totalamount60 = $totalamount60 - $res6transactionamount;
							}
							else if(($days_between >60) && ($days_between <=90))
							{							
								$totalamount90 = $totalamount90 - $res6transactionamount;							
							}
							else if(($days_between >90) && ($days_between <=120))
							{							
								$totalamount120 = $totalamount120 - $res6transactionamount;							
							}
							else if(($days_between >120) && ($days_between <=180))
							{							
								$totalamount180 = $totalamount180 - $res6transactionamount;							
							}
							else
							{							
								$totalamountgreater = $totalamountgreater - $res6transactionamount;							
							}
							
							$snocount = $snocount + 1;
							
				//echo $cashamount;
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#ecf0f5"';
				}
		
				?>
			   <tr <?php echo $colorcode; ?>>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
                                <div class="bodytext31"><?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6docno; ?>)- Cr.Note : <?php echo $lab; ?>&nbsp;<?php echo $rad; ?>&nbsp;<?php echo $ser; ?> <?php echo $particulars ?></div></td>		
                    <td class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo $res1mrdno; ?></div></td>	
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="center">
                            <div class="bodytext31"><?php echo $days_between; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
				
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				
				}
		}
	if($transactiontype=='pharmacycredit')
			{
		
				/*$respaylatercreditpayment=0;
				$res6transactiondate = $res2['groupdate'];
				$res6patientname = $res2['patientname'];
				$res6patientcode = $res2['patientcode'];
				$res6visitcode = $res2['visitcode'];
				$res6billnumber = $res2['billnumber'];
				$res6transactionmode = $res2['subtype'];
				$res6docno = $res2['auto_number'];
				$particulars = $res2['particulars'];
				//$docno  = $res2['docno'];
				
				$res6transactionamount = $res2['fxamount']/$exchange_rate;
								
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				$query47 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
				$exec47 = mysql_query($query47) or die(mysql_error());
				while($res47 = mysql_fetch_array($exec47))
				{
					$paylatercreditpayment = $res47['transactionamount1']/$exchange_rate;
					
					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
				}
				
				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($res6transactionamount != 0)
				{
					if($snocount == 1)
						{
							$total = $openingbalance - $res6transactionamount;
						}
						else
						{
							$total = $total - $res6transactionamount;
						}
					
					
					if($days_between <= 30)
							{
								$totalamount30 = $totalamount30 - $res6transactionamount;							
							}
							else if(($days_between >30) && ($days_between <=60))
							{						
								$totalamount60 = $totalamount60 - $res6transactionamount;
							}
							else if(($days_between >60) && ($days_between <=90))
							{							
								$totalamount90 = $totalamount90 - $res6transactionamount;							
							}
							else if(($days_between >90) && ($days_between <=120))
							{							
								$totalamount120 = $totalamount120 - $res6transactionamount;							
							}
							else if(($days_between >120) && ($days_between <=180))
							{							
								$totalamount180 = $totalamount180 - $res6transactionamount;							
							}
							else
							{							
								$totalamountgreater = $totalamountgreater - $res6transactionamount;							
							}
							
							$snocount = $snocount + 1;
							
				//echo $cashamount;
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#ecf0f5"';
				}*/
		
				?>
			  <!-- <tr <?php echo $colorcode; ?>>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				   <td width="6%"class="bodytext31" valign="center"  align="left">
							<div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
							<td width="32%"class="bodytext31" valign="center"  align="left">
							<div class="bodytext31"><?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6billnumber; ?>)- Cr.Note : Pharma <?php echo $particulars ?></div></td> 
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res1mrdno; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				   
				  <td class="bodytext31" valign="center"  align="center">
                            <div class="bodytext31"><?php echo $days_between; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>-->
				<?php
				//$res6transactionamount=0;
				//$respaylatercreditpayment=0;
				//}
				}
	if($transactiontype=='PAYMENT')
		{
			
		$billnum=$res2['billnumber'];
$squery="select billnumber from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit') and billnumber='$billnum'";
$exequery=mysqli_query($GLOBALS["___mysqli_ston"], $squery);
$numquery=mysqli_num_rows($exequery);
			if($numquery>0)
			
			{
				$resonaccountpayment=0;
				$res3transactiondate = $res2['groupdate'];
				$res3patientname = $res2['patientname'];
				$res3patientcode = $res2['patientcode'];
				$res3visitcode = $res2['visitcode'];
				$res3billnumber = $res2['billnumber'];
				$res3docno = $res2['auto_number'];
				$res3transactionmode = $res2['subtype'];
				$res3transactionnumber = $res2['accountname'];
				$particulars = $res2['particulars'];
				if($res2patientname=='')
						{
							$res2patientname='On Account';
						}
				$res3transactionamount = $res2['fxamount']/$exchange_rate;
				
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res3transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);

				$totalonaccountpayment = 0;
			 	$query67 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where  docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
				$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res67 = mysqli_fetch_array($exec67))
				{
					$onaccountpayment = $res67['transactionamount1']/$exchange_rate;
					$totalonaccountpayment = $totalonaccountpayment + $onaccountpayment;
				}
				 
			 	 $res3transactionamount = $res3transactionamount - $totalonaccountpayment;
				 
				if($snocount == 0)
						{
							$total = $openingbalance - $res3transactionamount;
						}
						else
						{
							$total = $total - $res3transactionamount;
						}
						
				if($res3transactionamount != 0)
				{
								
				if($days_between <= 30)
				{
				
				$totalamount30 = $totalamount30 - $res3transactionamount;
				
				}
				else if(($days_between >30) && ($days_between <=60))
				{
				
				$totalamount60 = $totalamount60 - $res3transactionamount;
				
				}
				else if(($days_between >60) && ($days_between <=90))
				{
				
				$totalamount90 = $totalamount90 - $res3transactionamount;
				
				}
				else if(($days_between >90) && ($days_between <=120))
				{
				
				$totalamount120 = $totalamount120 - $res3transactionamount;
				
				}
				else if(($days_between >120) && ($days_between <=180))
				{
				
				$totalamount180 = $totalamount180 - $res3transactionamount;
				
				}
				else
				{
				
				$totalamountgreater = $totalamountgreater - $res3transactionamount;
				
				}
				$snocount = $snocount + 1;
			
				//echo $cashamount;
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#ecf0f5"';
				}
		
				?>
			   <tr <?php echo $colorcode; ?>>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo $res3patientname; ?> (<?php echo $res3patientcode; ?>, <?php echo $res3visitcode; ?>, <?php echo $res3billnumber; ?>) <?php echo $particulars ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo ''; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res3docno; ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php //echo number_format($res3transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format(abs($res3transactionamount),2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="center">
			  <div class="bodytext31"><?php echo $days_between; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
			}
			}
			}
			
			}
			
			?>
               <tr>
        <td>&nbsp;</td>
      </tr>
            <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
			<tr>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
					<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
            	 </tr>
						<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>30 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>60 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>90 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>120 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180 days</strong></td>
           <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180+ days</strong></td>
           
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total Due</strong></td>
            </tr>
			<?php 
			
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount30,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
            
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo number_format($grandtotal,2,'.',','); ?></td>
            </tr>
			
		    <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
         	<?php
			
	
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsupplieranum=$searchsupplieranum&&searchsuppliercode=$searchsuppliercode";
			
			?>
		    <td class="bodytext31" valign="center"  align="right"><a href="print_corporateoutstandingpdf.php?<?php echo $urlpath; ?>" target="_blank" ><img  width="40" height="40" src="images/pdfdownload.jpg" style="cursor:pointer;"></a></td>   
		   	 <td class="bodytext31" valign="center"  align="right" target="_blank" ><a href="print_corporateoutstanding.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
               </tr>
			  </table>
            <?php
			}
			?>
        </main>
    </div>

    <!-- JavaScript for Modern Functionality -->
    <script>
        // Global variables
        let currentPage = 1;
        let itemsPerPage = 10;
        let allTransactions = [];
        let filteredTransactions = [];

        // Initialize when document is ready
        $(document).ready(function() {
            loadTransactions();
            setupEventListeners();
            setupSidebar();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Search input event
            $('#transactionSearch').on('input', function() {
                filterTransactions();
            });

            // Age filter change
            $('#ageFilter').on('change', function() {
                filterTransactions();
            });

            // Keyboard shortcut for menu toggle
            $(document).on('keydown', function(e) {
                if (e.ctrlKey && e.key === 'm') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
        }

        // Setup sidebar functionality
        function setupSidebar() {
            $('#menuToggle').on('click', function() {
                toggleSidebar();
            });

            $('#sidebarToggle').on('click', function() {
                toggleSidebar();
            });
        }

        // Toggle sidebar
        function toggleSidebar() {
            const sidebar = $('#leftSidebar');
            const container = $('.main-container-with-sidebar');
            const toggle = $('#menuToggle');
            
            sidebar.toggleClass('collapsed');
            container.toggleClass('sidebar-collapsed');
            toggle.toggleClass('active');
        }

        // Load transactions from server
        function loadTransactions() {
            // Get form values
            const searchAccount = $('#searchsuppliername').val();
            const asOnDate = $('#ADate2').val();

            // Build query parameters
            const params = new URLSearchParams();
            if (searchAccount) params.append('search_account', searchAccount);
            if (asOnDate) params.append('as_on_date', asOnDate);

            // Make AJAX call
            $.ajax({
                url: 'get_corporate_outstanding.php',
                method: 'GET',
                data: params.toString(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        allTransactions = response.transactions;
                        filteredTransactions = [...allTransactions];
                        currentPage = 1;
                        updateSummary(response.summary);
                        renderTable();
                        updatePagination();
                        $('#summaryCards').show();
                    } else {
                        console.error('Error loading transactions:', response.error);
                        $('#outstandingTableBody').html('<tr><td colspan="10" class="no-data">Error loading data. Please try again.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('#outstandingTableBody').html('<tr><td colspan="10" class="no-data">Error loading data. Please try again.</td></tr>');
                }
            });
        }

        // Update summary cards
        function updateSummary(summary) {
            $('#totalOutstanding').text('₹' + summary.total_outstanding);
            $('#totalCount').text(summary.total_count);
            $('#aging30').text('₹' + summary.age_buckets['0-30']);
            $('#aging90').text('₹' + (parseFloat(summary.age_buckets['61-90'].replace(/,/g, '')) + parseFloat(summary.age_buckets['91-120'].replace(/,/g, '')) + parseFloat(summary.age_buckets['120+'].replace(/,/g, ''))).toLocaleString('en-IN', {minimumFractionDigits: 2}));
        }

        // Filter transactions
        function filterTransactions() {
            const searchTerm = $('#transactionSearch').val().toLowerCase();
            const ageFilter = $('#ageFilter').val();

            filteredTransactions = allTransactions.filter(transaction => {
                const matchesSearch = !searchTerm || 
                    transaction.description.toLowerCase().includes(searchTerm) ||
                    transaction.billnumber.toLowerCase().includes(searchTerm) ||
                    transaction.mrdnumber.toLowerCase().includes(searchTerm);

                const matchesAge = !ageFilter || transaction.age_bucket === ageFilter;

                return matchesSearch && matchesAge;
            });

            currentPage = 1;
            renderTable();
            updatePagination();
        }

        // Clear all filters
        function clearFilters() {
            $('#transactionSearch').val('');
            $('#ageFilter').val('');
            filteredTransactions = [...allTransactions];
            currentPage = 1;
            renderTable();
            updatePagination();
        }

        // Render table with current data
        function renderTable() {
            const tbody = $('#outstandingTableBody');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = filteredTransactions.slice(startIndex, endIndex);

            if (pageData.length === 0) {
                tbody.html('<tr><td colspan="10" class="no-data">No outstanding transactions found. Try adjusting your search criteria.</td></tr>');
                return;
            }

            tbody.empty();
            pageData.forEach((transaction, index) => {
                const row = `
                    <tr class="table-row ${index % 2 === 0 ? 'even' : 'odd'}">
                        <td class="sno-cell">${startIndex + index + 1}</td>
                        <td class="date-cell">${transaction.transactiondate}</td>
                        <td class="description-cell">${transaction.description}</td>
                        <td class="mrd-cell">${transaction.mrdnumber}</td>
                        <td class="bill-number-cell">${transaction.billnumber}</td>
                        <td class="disp-date-cell">${transaction.dispatchdate || '-'}</td>
                        <td class="amount-cell">₹${transaction.transactionamount}</td>
                        <td class="outstanding-cell">₹${transaction.outstanding_amount}</td>
                        <td class="days-cell">${transaction.days_outstanding} days</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="corporateoutstanding.php?view=${transaction.auto_number}" class="action-btn view-btn" title="View Details">
                                    <span class="action-icon">👁️</span>
                                </a>
                                <a href="print_corporateoutstandingpdf.php?id=${transaction.auto_number}" class="action-btn print-btn" title="Print PDF" target="_blank">
                                    <span class="action-icon">📄</span>
                                </a>
                                <a href="print_corporateoutstanding.php?id=${transaction.auto_number}" class="action-btn edit-btn" title="Export Excel" target="_blank">
                                    <span class="action-icon">📊</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Update pagination controls
        function updatePagination() {
            const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(currentPage * itemsPerPage, filteredTransactions.length);

            // Update info
            $('#startIndex').text(filteredTransactions.length > 0 ? startIndex : 0);
            $('#endIndex').text(endIndex);
            $('#totalItems').text(filteredTransactions.length);

            // Update buttons
            $('#prevBtn').prop('disabled', currentPage === 1);
            $('#nextBtn').prop('disabled', currentPage === totalPages);

            // Update page numbers
            const pageNumbers = $('#pageNumbers');
            pageNumbers.empty();

            if (totalPages <= 7) {
                // Show all page numbers
                for (let i = 1; i <= totalPages; i++) {
                    pageNumbers.append(`
                        <button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>
                    `);
                }
            } else {
                // Show first, last, current, and neighbors
                const pages = [1];
                
                if (currentPage > 3) {
                    pages.push('<span class="pagination-ellipsis">...</span>');
                }
                
                for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                    if (!pages.includes(i)) {
                        pages.push(i);
                    }
                }
                
                if (currentPage < totalPages - 2) {
                    pages.push('<span class="pagination-ellipsis">...</span>');
                }
                
                if (totalPages > 1) {
                    pages.push(totalPages);
                }

                pages.forEach(page => {
                    if (typeof page === 'number') {
                        pageNumbers.append(`
                            <button class="pagination-btn ${page === currentPage ? 'active' : ''}" onclick="goToPage(${page})">${page}</button>
                        `);
                    } else {
                        pageNumbers.append(page);
                    }
                });
            }
        }

        // Navigation functions
        function goToPage(page) {
            currentPage = page;
            renderTable();
            updatePagination();
        }

        function previousPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
                updatePagination();
            }
        }

        function nextPage() {
            const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
                updatePagination();
            }
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt($('#itemsPerPage').val());
            currentPage = 1;
            renderTable();
            updatePagination();
        }

        // Form submission handler
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            loadTransactions();
        });
    </script>

<?php include ("includes/footer1.php"); ?>

</body>
</html>
