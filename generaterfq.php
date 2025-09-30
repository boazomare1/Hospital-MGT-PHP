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

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");

if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if (isset($_REQUEST["billautonumber"])) { 
    $billautonumber = $_REQUEST["billautonumber"]; 
} else { 
    $billautonumber = ""; 
}

if (isset($_REQUEST["frm1submit1"])) { 
    $frm1submit1 = $_REQUEST["frm1submit1"]; 
} else { 
    $frm1submit1 = ""; 
}

if ($frm1submit1 == 'frm1submit1') {
    $paynowbillprefix = 'RFQ-';
    $paynowbillprefix1 = strlen($paynowbillprefix);
    
    $query3 = "select * from purchase_rfq order by auto_number desc limit 0, 1";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $num3 = mysqli_num_rows($exec3);
    $res3 = mysqli_fetch_array($exec3);
    $billnumber = $res3['docno'];
    $billdigit = strlen($billnumber);

    if($num3 > 0) {
        $query24 = "select * from purchase_rfq order by auto_number desc limit 0, 1";
        $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res24 = mysqli_fetch_array($exec24);
        $billnumber = $res24['docno'];
        $billdigit = strlen($billnumber);
        $billnumbercode = substr($billnumber, $paynowbillprefix1, $billdigit);
        $billnumbercode = intval($billnumbercode);
        $billnumbercode = $billnumbercode + 1;
        $maxanum = $billnumbercode;
        $billnumbercode = $paynowbillprefix . $maxanum;
        $openingbalance = '0.00';
    } else {
        $query2 = "select * from purchase_rfq order by auto_number desc limit 0, 1";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        $billnumber = $res2["docno"];
        $billdigit = strlen($billnumber);
        
        if ($billnumber == '') {
            $billnumbercode = $paynowbillprefix . '1';
            $openingbalance = '0.00';
        }
    }

    foreach($_POST['docno'] as $key => $value) {
        $docno = $_POST['docno'][$key];
        
        foreach($_POST['select'] as $check) {
            $acknow = $check;
            
            if($acknow == $docno) {
                $query58 = "update purchase_rfq set status='completed' where status='Process'";
                $exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

                $query33 = "select * from purchase_rfqrequest where docno='$docno' and approvalstatus='approved' and grandapprovalstatus='approved' group by medicinecode";
                $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                
                while($res33 = mysqli_fetch_array($exec33)) {
                    $itemname = $res33['medicinename'];
                    $itemcode = $res33['medicinecode'];

                    $query331 = "select sum(quantity) as totalquantity from purchase_rfqrequest where medicinecode = '$itemcode' and docno='$docno' and approvalstatus='approved' and grandapprovalstatus='approved'";
                    $exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
                    $res331 = mysqli_fetch_array($exec331);
                    $quantity = $res331['totalquantity'];
                    $rate = $res33['rate'];
                    $amount = $quantity * $rate;
                    $packagequantity = $res33['packagequantity'];

                    $query56 = "insert into purchase_rfq(companyanum,docno,medicinecode,medicinename,rate,quantity,amount,username, ipaddress, date,packagequantity,status)
                              values('$companyanum','$billnumbercode','$itemcode','$itemname','$rate','$quantity','$amount','$username','$ipaddress','$currentdate','$packagequantity','Process')";
                    $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		

                    $query55 = "update purchase_rfqrequest set rfqgeneration='completed' where docno='$docno' and medicinecode='$itemcode'";
                    $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
        }
    }

    $errmsg = "RFQ generated successfully.";
    $bgcolorcode = 'success';
    header("location:generaterfq.php?st=success");
    exit;
}

// Handle success redirect
if($st == 'success') {
    header("location:print_generaterfq.php");
    exit;
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        $errmsg = "RFQ generated successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate RFQ - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/generaterfq-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/autocomplete_customer1.js"></script>
    <script type="text/javascript" src="js/autosuggest3.js"></script>
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
        <span>Generate RFQ</span>
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
                        <a href="purchase_rfqrequest.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Purchase RFQ Request</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="generaterfq.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Generate RFQ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="purchase_rfq.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>RFQ List</span>
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
                    <h2>Generate RFQ</h2>
                    <p>Generate Request for Quotation (RFQ) from approved purchase requests.</p>
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

            <!-- RFQ Generation Form -->
            <div class="rfq-form-section">
                <div class="rfq-form-header">
                    <i class="fas fa-file-invoice rfq-form-icon"></i>
                    <h3 class="rfq-form-title">Select Approved Requests</h3>
                </div>
                
                <form method="post" name="form1" action="generaterfq.php" class="rfq-form">
                    <?php 
                    $query34 = "select * from purchase_rfqrequest where approvalstatus='approved' and grandapprovalstatus='approved' and rfqgeneration='' group by docno";
                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    $resnw1 = mysqli_num_rows($exec34);
                    ?>

                    <div class="form-info">
                        <div class="info-item">
                            <i class="fas fa-info-circle"></i>
                            <span>Total Approved Requests: <strong><?php echo $resnw1; ?></strong></span>
                        </div>
                    </div>

                    <?php if ($resnw1 > 0): ?>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" onchange="toggleAllCheckboxes()">
                                        </th>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>From</th>
                                        <th>DOC No</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $colorloopcount = 0;
                                    $sno = 0;
                                    $query34 = "select * from purchase_rfqrequest where approvalstatus='approved' and grandapprovalstatus='approved' and rfqgeneration='' group by docno";
                                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    
                                    while($res34 = mysqli_fetch_array($exec34)) {
                                        $date = $res34['date'];
                                        $user = $res34['username'];
                                        $docno = $res34['docno'];
                                        $colorloopcount++;
                                        $sno++;
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="select[]" class="select-checkbox" 
                                                       value="<?php echo htmlspecialchars($docno); ?>" checked>
                                            </td>
                                            <td><?php echo $sno; ?></td>
                                            <td><?php echo htmlspecialchars($date); ?></td>
                                            <td><?php echo htmlspecialchars($user); ?></td>
                                            <td>
                                                <span class="doc-number"><?php echo htmlspecialchars($docno); ?></span>
                                                <input type="hidden" name="docno[]" value="<?php echo htmlspecialchars($docno); ?>">
                                            </td>
                                            <td>
                                                <span class="status-badge status-approved">Approved</span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-actions">
                            <input type="hidden" name="frm1submit1" value="frm1submit1" />
                            <input type="hidden" name="doccno" value="<?php echo isset($billnumbercode) ? $billnumbercode : ''; ?>">
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="fas fa-file-invoice"></i>
                                Generate RFQ
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>No Approved Requests</h3>
                            <p>There are no approved purchase requests available for RFQ generation.</p>
                            <a href="purchase_rfqrequest.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New Request
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/generaterfq-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
