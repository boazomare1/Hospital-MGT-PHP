<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Default date ranges
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Search parameters
$searchsubtypeanum1 = isset($_REQUEST["searchsubtypeanum1"]) ? $_REQUEST["searchsubtypeanum1"] : "";
$searchsuppliername1 = isset($_REQUEST["searchsuppliername1"]) ? $_REQUEST["searchsuppliername1"] : "";
$searchinvoice = isset($_REQUEST["searchinvoice"]) ? $_REQUEST["searchinvoice"] : "";
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : $paymentreceiveddatefrom;
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : $paymentreceiveddateto;
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";

// Update date variables if form submitted
if ($ADate1) $paymentreceiveddatefrom = $ADate1;
if ($ADate2) $paymentreceiveddateto = $ADate2;

$errmsg = "";
$banum = "1";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Allocated Report - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/arallocated-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($username); ?></span>
            <span class="location-info">Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu.php" class="btn btn-outline">Main Menu</a>
            <a href="logout.php" class="btn btn-outline">Logout</a>
        </div>
    </div>

    <nav class="nav-breadcrumb">
        <a href="mainmenu.php">Home</a>
        <span>→</span>
        <span>AR Allocated Report</span>
    </nav>

    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <div class="main-container-with-sidebar">
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            VAT Master
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="advancedeposit.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            Advance Deposit
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addalertmessage1.php" class="nav-link">
                            <i class="fas fa-bell"></i>
                            Alert Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ar_allocatedreport.php" class="nav-link active">
                            <i class="fas fa-file-invoice-dollar"></i>
                            AR Allocated Report
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="newpatient.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            New Patient
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientlist.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            Patient List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="visitentry.php" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            Visit Entry
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div id="alertContainer">
                <?php if ($errmsg): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="page-header">
                <div class="page-header-content">
                    <h2>AR Allocated Report</h2>
                    <p>View detailed accounts receivable allocation reports and payment tracking</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i>
                        Export
                    </button>
                </div>
            </div>

            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Criteria</h3>
                </div>
                
                <form name="searchForm" method="post" action="" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername1" class="form-label">Search Subtype</label>
                            <input name="searchsuppliername1" type="text" id="searchsuppliername1" 
                                   value="<?php echo htmlspecialchars($searchsuppliername1); ?>" 
                                   class="form-input" placeholder="Enter subtype name..." autocomplete="off">
                            <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                            <input name="searchsubtypeanum1" id="searchsubtypeanum1" 
                                   value="<?php echo htmlspecialchars($searchsubtypeanum1); ?>" type="hidden">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchinvoice" class="form-label">Search Invoice</label>
                            <input name="searchinvoice" type="text" id="searchinvoice" 
                                   value="<?php echo htmlspecialchars($searchinvoice); ?>" 
                                   class="form-input" placeholder="Enter invoice number..." autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" type="date" 
                                   value="<?php echo htmlspecialchars($ADate1); ?>" 
                                   class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" type="date" 
                                   value="<?php echo htmlspecialchars($ADate2); ?>" 
                                   class="form-input">
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn" onclick="return validateSearchForm()">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">AR Allocated Report Results</h3>
                </div>

                <div class="table-container">
                    <table class="data-table" id="arReportTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Invoice Date</th>
                                <th>Invoice No</th>
                                <th>Patient Name</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Account Name</th>
                                <th>Invoice Amount</th>
                                <th>Allocation Date</th>
                                <th>Allocation Amount</th>
                            </tr>
                        </thead>
                        <tbody id="arReportTableBody">
                            <?php 
                            if ($searchinvoice == '') {
                                if ($searchsubtypeanum1 == '') {
                                    $query2212 = "SELECT accountname, auto_number, id, subtype FROM master_accountname WHERE subtype != '' AND recordstatus != 'DELETED' GROUP BY subtype";
                                    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query2212);
                                    mysqli_stmt_execute($stmt);
                                } else {
                                    $query2212 = "SELECT accountname, auto_number, id, subtype FROM master_accountname WHERE subtype = ? AND recordstatus != 'DELETED' GROUP BY subtype";
                                    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query2212);
                                    mysqli_stmt_bind_param($stmt, 's', $searchsubtypeanum1);
                                    mysqli_stmt_execute($stmt);
                                }
                                
                                $exec2212 = mysqli_stmt_get_result($stmt);
                                
                                while ($res2212 = mysqli_fetch_array($exec2212)) {
                                    $subtypeanum = $res2212['subtype'];
                                    $sno = 1;
                                    
                                    $query9 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT subtype FROM master_subtype WHERE auto_number = ?");
                                    mysqli_stmt_bind_param($query9, 's', $subtypeanum);
                                    mysqli_stmt_execute($query9);
                                    $result9 = mysqli_stmt_get_result($query9);
                                    $res9 = mysqli_fetch_array($result9);
                                    $subtype = $res9['subtype'];
                                    
                                    if ($subtypeanum != '') {
                                        $query2211 = "SELECT accountname, auto_number, id FROM master_accountname WHERE subtype = ?";
                                        $stmt2211 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query2211);
                                        mysqli_stmt_bind_param($stmt2211, 's', $subtypeanum);
                                        mysqli_stmt_execute($stmt2211);
                                        $exec2211 = mysqli_stmt_get_result($stmt2211);
                                        
                                        while ($res2211 = mysqli_fetch_array($exec2211)) {
                                            $res22accountname = $res2211['accountname'];
                                            $res21accountnameano = $res2211['auto_number'];
                                            $res21accountname = $res2211['accountname'];
                                            $res21accountid = $res2211['id'];
                                            
                                            $querydebit12 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM master_transactionpaylater WHERE accountnameano = ? AND accountnameid = ?");
                                            mysqli_stmt_bind_param($querydebit12, 'ss', $res21accountnameano, $res21accountid);
                                            mysqli_stmt_execute($querydebit12);
                                            $execdebit12 = mysqli_stmt_get_result($querydebit12);
                                            $numdebit12 = mysqli_num_rows($execdebit12);
                                            
                                            if ($res22accountname != '' && $numdebit12 > 0) {
                                                $query4210 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM master_transactionpaylater WHERE accountnameid = ? AND transactiondate BETWEEN ? AND ? AND docno LIKE 'AR-%' AND transactionstatus = 'onaccount' AND transactionmodule = 'PAYMENT'");
                                                mysqli_stmt_bind_param($query4210, 'sss', $res21accountid, $ADate1, $ADate2);
                                                mysqli_stmt_execute($query4210);
                                                $exec4210 = mysqli_stmt_get_result($query4210);
                                                $arnumcount = mysqli_num_rows($exec4210);
                                                
                                                $hasAR = $arnumcount > 0;
                                            ?>
                                            <tr class="subtype-header <?php echo $hasAR ? 'has-ar' : ''; ?>" onclick="toggleSubtype('<?php echo $subtypeanum; ?>')">
                                                <td colspan="10" class="subtype-name">
                                                    <i class="fas fa-chevron-<?php echo $hasAR ? 'down' : 'right'; ?>"></i>
                                                    <strong><?php echo htmlspecialchars($subtype); ?></strong>
                                                    <?php if ($hasAR): ?>
                                                        <span class="ar-badge">Has AR</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            
                                            <tbody id="<?php echo $subtypeanum; ?>" class="subtype-details" style="display: <?php echo $hasAR ? 'table-row-group' : 'none'; ?>">
                                                <?php
                                                $colorloopcount = 0;
                                                $query42 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM master_transactionpaylater WHERE accountnameid = ? AND transactiondate BETWEEN ? AND ? AND docno LIKE 'AR-%' AND transactionstatus = 'onaccount' AND transactionmodule = 'PAYMENT'");
                                                mysqli_stmt_bind_param($query42, 'sss', $res21accountid, $ADate1, $ADate2);
                                                mysqli_stmt_execute($query42);
                                                $exec42 = mysqli_stmt_get_result($query42);
                                                
                                                while ($res42 = mysqli_fetch_array($exec42)) {
                                                    $resubsubno = $res42['auto_number'];
                                                    $resubsubarno = $res42['docno'];
                                                    $resubsubtotalamount = $res42['transactionamount'];
                                                    $colorloopcount++;
                                                    $showcolor = ($colorloopcount & 1);
                                                    $rowClass = $showcolor == 0 ? 'even-row' : 'odd-row';
                                                    
                                                    $query_allocated_amount = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT SUM(transactionamount) as amount, SUM(discount) as discount FROM master_transactionpaylater WHERE recordstatus = 'allocated' AND docno = ?");
                                                    mysqli_stmt_bind_param($query_allocated_amount, 's', $resubsubarno);
                                                    mysqli_stmt_execute($query_allocated_amount);
                                                    $exec_allocated_amount = mysqli_stmt_get_result($query_allocated_amount);
                                                    $res_allocated_amount = mysqli_fetch_array($exec_allocated_amount);
                                                    $allocated_amount = $res_allocated_amount['amount'] ?: 0;
                                                    
                                                    $pending_final_value = $resubsubtotalamount - $allocated_amount;
                                                ?>
                                                <tr class="ar-header <?php echo $rowClass; ?>" onclick="toggleAR('<?php echo $resubsubarno; ?>')">
                                                    <td colspan="4" class="ar-docno">
                                                        <i class="fas fa-chevron-right"></i>
                                                        <strong><?php echo htmlspecialchars($resubsubarno); ?></strong>
                                                    </td>
                                                    <td colspan="3" class="ar-amount">
                                                        <strong>AR Amount: <?php echo number_format($resubsubtotalamount, 2); ?></strong>
                                                    </td>
                                                    <td colspan="3" class="ar-balance">
                                                        <strong>AR Balance: <?php echo number_format($pending_final_value, 2); ?></strong>
                                                    </td>
                                                </tr>
                                                
                                                <?php
                                                $colorloopcount1 = 0;
                                                $query421 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM master_transactionpaylater WHERE accountnameid = ? AND transactiondate BETWEEN ? AND ? AND docno = ? AND transactiontype = 'PAYMENT' AND billnumber != '' AND recordstatus = 'allocated'");
                                                mysqli_stmt_bind_param($query421, 'ssss', $res21accountid, $ADate1, $ADate2, $resubsubarno);
                                                mysqli_stmt_execute($query421);
                                                $exec421 = mysqli_stmt_get_result($query421);
                                                
                                                while ($res421 = mysqli_fetch_array($exec421)) {
                                                    $resubsubbillno = $res421['billnumber'];
                                                    
                                                    $query4211 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM master_transactionpaylater WHERE accountnameid = ? AND billnumber = ? AND transactiontype = 'finalize' AND billnumber != ''");
                                                    mysqli_stmt_bind_param($query4211, 'ss', $res21accountid, $resubsubbillno);
                                                    mysqli_stmt_execute($query4211);
                                                    $exec4211 = mysqli_stmt_get_result($query4211);
                                                    $res4211 = mysqli_fetch_array($exec4211);
                                                    
                                                    $colorloopcount1++;
                                                    $showcolor1 = ($colorloopcount1 & 1);
                                                    $detailRowClass = $showcolor1 == 0 ? 'even-row' : 'odd-row';
                                                ?>
                                                <tr class="ar-detail <?php echo $detailRowClass; ?> ar-<?php echo $resubsubarno; ?>" style="display: none;">
                                                    <td><?php echo $colorloopcount1; ?></td>
                                                    <td><?php echo htmlspecialchars($res4211['transactiondate']); ?></td>
                                                    <td><?php echo htmlspecialchars($res4211['billnumber']); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['patientname']); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['patientcode']); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['visitcode']); ?></td>
                                                    <td><?php echo htmlspecialchars($res4211['accountname']); ?></td>
                                                    <td class="amount-cell"><?php echo number_format($res4211['transactionamount'], 2); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['transactiondate']); ?></td>
                                                    <td class="amount-cell"><?php echo number_format($res421['transactionamount'], 2); ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <?php
                                            }
                                            }
                                            }
                                            }
                                            } elseif ($searchinvoice != '') {
                                                $colorloopcount1 = 0;
                                                $query421 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM master_transactionpaylater WHERE transactiontype = 'PAYMENT' AND billnumber = ? AND recordstatus = 'allocated' AND docno IN (SELECT docno FROM master_transactionpaylater WHERE docno LIKE 'AR-%' AND transactionstatus = 'onaccount' AND transactionmodule = 'PAYMENT')");
                                                mysqli_stmt_bind_param($query421, 's', $searchinvoice);
                                                mysqli_stmt_execute($query421);
                                                $exec421 = mysqli_stmt_get_result($query421);
                                                $res421 = mysqli_fetch_array($exec421);
                                                
                                                if ($res421) {
                                                    $colorloopcount1++;
                                                    $showcolor1 = ($colorloopcount1 & 1);
                                                    $colorcode1 = $showcolor1 == 0 ? 'even-row' : 'odd-row';
                                            ?>
                                            <tr class="subtype-header has-ar" onclick="toggleSubtype('<?php echo $res421['accountcode']; ?>')">
                                                <td colspan="10" class="subtype-name">
                                                    <i class="fas fa-chevron-down"></i>
                                                    <strong><?php echo htmlspecialchars($res421['subtype']); ?></strong>
                                                    <span class="ar-badge">Has AR</span>
                                                </td>
                                            </tr>
                                            
                                            <tbody id="<?php echo $res421['accountcode']; ?>" class="subtype-details" style="display: table-row-group;">
                                                <tr class="ar-header even-row">
                                                    <td colspan="4" class="ar-docno">
                                                        <strong><?php echo htmlspecialchars($res421['docno']); ?></strong>
                                                    </td>
                                                    <td colspan="3" class="ar-amount">&nbsp;</td>
                                                    <td colspan="3" class="ar-balance">&nbsp;</td>
                                                </tr>
                                                
                                                <tr class="ar-detail <?php echo $colorcode1; ?>">
                                                    <td><?php echo $colorloopcount1; ?></td>
                                                    <td><?php echo htmlspecialchars($res421['transactiondate']); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['billnumber']); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['patientname']); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['patientcode']); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['visitcode']); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['accountname']); ?></td>
                                                    <td class="amount-cell"><?php echo number_format($res421['transactionamount'], 2); ?></td>
                                                    <td><?php echo htmlspecialchars($res421['transactiondate']); ?></td>
                                                    <td class="amount-cell"><?php echo number_format($res421['transactionamount'], 2); ?></td>
                                                </tr>
                                            </tbody>
                                            <?php
                                                }
                                            }
                                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/arallocated-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

