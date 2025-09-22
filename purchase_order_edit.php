<?php
session_start();

include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$dateonly = date("Y-m-d");

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$totalop = 0;
$totalref = 0;
$dispensingfee = 0;
$totalcopay = 0;
$totalgrt = 0;
$totalgrn = 0;
$totalnet = 0;
$grandgrn = 0;
$grandgrt = 0;
$grandnet = 0;

if(isset($_REQUEST["cbfrmflag1"])){ $cbfrmflag1 = $_REQUEST["cbfrmflag1"];}else{$cbfrmflag1 = "";}
if(isset($_REQUEST["suppliername"])){ $searchsuppliername = $_REQUEST["suppliername"];}else{$searchsuppliername = "";}
if(isset($_REQUEST["suppliercode"])){ $searchsuppliercode = $_REQUEST["suppliercode"];}else{$searchsuppliercode = "";}
if(isset($_REQUEST["ponumber"])){ $searchponumber = $_REQUEST["ponumber"];}else{$searchponumber = "";}
if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}
if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Purchase Orders - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/purchase-order-edit-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete -->
    <link href="autocomplete.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
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
        <span>Edit Purchase Orders</span>
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
                        <a href="purchase_order.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Purchase Orders</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="purchase_order_edit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Edit PO</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="material_receipt_note.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Material Receipt</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="supplier_master.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Suppliers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inventory.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Inventory</span>
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
                    <h2>Edit Purchase Orders</h2>
                    <p>Search and edit existing purchase order records with detailed item information.</p>
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
                    <h3 class="search-form-title">Search Purchase Order</h3>
                </div>
                
                <form name="cbform1" id="searchForm" method="post" action="purchase_order_edit.php" class="search-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pono" class="form-label">Purchase Order Number</label>
                            <input name="pono" type="text" id="pono" class="form-input" 
                                   value="<?php echo htmlspecialchars(isset($_REQUEST['pono']) ? $_REQUEST['pono'] : ''); ?>" 
                                   placeholder="Enter PO number" required>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" id="resetBtn" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Results Section -->
            <?php if (($cbfrmflag1 == 'cbfrmflag1') || (isset($_GET['pono']))): ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Purchase Order Details</h3>
                </div>
                
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>PI</th>
                                <th>PO</th>
                                <th>Supplier Name</th>
                                <th>PO Status</th>
                                <th class="text-right">PO Value</th>
                                <th class="text-right">GRN Amt</th>
                                <th class="text-right">GRT Amt</th>
                                <th class="text-right">Net Amt</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colorloopcount = 0;
                            $sno = 0;
                            $lpototal = 0;
                            $mlpototal = 0;
                            $grandtotal = 0;
                            $totamountval_det = 0;
                            
                            $docno = "";
                            $ponumber = $_REQUEST["pono"];
                            $type = 'all';
                            $reporttype = "detailed";
                            
                            if(1) {
                                $qrypodetatils = "SELECT billdate,purchaseindentdocno,billnumber,suppliername,SUM(totalamount) AS totvalue,goodsstatus from purchaseorder_details where recordstatus='generated' and goodsstatus ='' and itemstatus != 'deleted' and purchaseindentdocno like '%$docno%' and billnumber like '%$ponumber%' group by billnumber order by auto_number desc";
                                
                                $execpodetatils = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetatils) or die ("Error in qrypodetatils".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while($respodetatils = mysqli_fetch_array($execpodetatils)) {
                                    $billdate = $respodetatils["billdate"];
                                    $pinumber = $respodetatils["purchaseindentdocno"];
                                    $ponumber = $respodetatils["billnumber"];
                                    $suppliername = $respodetatils["suppliername"];
                                    $totalamount = $respodetatils["totvalue"];
                                    $lpototal = $lpototal + $totalamount;
                                    
                                    // Check status
                                    $pocnt_qry = "SELECT COUNT(auto_number) pocnt FROM `purchaseorder_details` WHERE `billnumber` = '$ponumber' ";
                                    $execpocnt = mysqli_query($GLOBALS["___mysqli_ston"], $pocnt_qry) or die ("Error in PO Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $pocntres = mysqli_fetch_array($execpocnt);
                                    $pocnt = $pocntres['pocnt'];
                                    
                                    $poreccnt_qry = "SELECT COUNT(auto_number) poreccnt FROM `purchaseorder_details` WHERE `billnumber` = '$ponumber' and goodsstatus='received'";
                                    $execrecpocnt = mysqli_query($GLOBALS["___mysqli_ston"], $poreccnt_qry) or die ("Error in PO REC Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $porecntres = mysqli_fetch_array($execrecpocnt);
                                    $poreccnt = $porecntres['poreccnt'];
                                    
                                    if($pocnt == $poreccnt) {
                                        $grnstatus = "PO Fully Received (Not Editable)";
                                        $status_class = "status-fully-received";
                                    } else {
                                        $grnstatus = "PO Partially Received";
                                        $status_class = "status-partially-received";
                                    }
                                    
                                    $mrnbuild = array();
                                    $grnamount = 0;
                                    $grtamount = 0;
                                    
                                    $query89 = "select billnumber, sum(totalfxamount) as totalfxamount from materialreceiptnote_details where ponumber = '$ponumber' group by billnumber";
                                    $exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    
                                    while($res89 = mysqli_fetch_array($exec89)) {
                                        $mrnno = $res89['billnumber'];
                                        $mrnbuild[] = $mrnno;
                                        $grn = $res89['totalfxamount'];
                                        $grnamount = $grnamount + $grn;
                                        $totalgrn = $totalgrn + $grn;
                                    }
                                    
                                    if($grnamount == 0) {
                                        $grnstatus = "PO Not Received";
                                        $status_class = "status-not-received";
                                    }
                                    
                                    $mrnbuildvalue = implode("','",$mrnbuild);
                                    
                                    $query91 = "select billnumber, sum(totalamount) as totalamount from purchasereturn_details where grnbillnumber IN ('".$mrnbuildvalue."') group by billnumber";
                                    $exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    
                                    while($res91 = mysqli_fetch_array($exec91)) {
                                        $grtno = $res91['billnumber'];
                                        $grt = $res91['totalamount'];
                                        $grtamount = $grtamount + $grt;
                                        $totalgrt = $totalgrt + $grt;
                                    }
                                    
                                    $netamount = $grnamount - $grtamount;
                                    $totalnet = $totalnet + $netamount;
                                    
                                    $colorloopcount++;
                                    $sno++;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $sno; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($billdate)); ?></td>
                                        <td><?php echo htmlspecialchars($pinumber); ?></td>
                                        <td>
                                            <span class="status-badge status-active"><?php echo htmlspecialchars($ponumber); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($suppliername); ?></td>
                                        <td>
                                            <span class="status-indicator <?php echo $status_class; ?>">
                                                <?php echo htmlspecialchars($grnstatus); ?>
                                            </span>
                                        </td>
                                        <td class="amount"><?php echo number_format($totalamount, 2, '.', ','); ?></td>
                                        <td class="amount">
                                            <?php if($grnamount != 0): ?>
                                                <a href="viewgrnpurchase.php?ponumber=<?php echo urlencode($ponumber); ?>" 
                                                   target="_blank" class="action-btn view" title="View GRN">
                                                    <?php echo number_format($grnamount, 2, '.', ','); ?>
                                                </a>
                                            <?php else: ?>
                                                <?php echo number_format($grnamount, 2, '.', ','); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="amount">
                                            <?php if($grtamount != 0): ?>
                                                <a href="viewgrtpurchase.php?ponumber=<?php echo urlencode($mrnbuildvalue); ?>" 
                                                   target="_blank" class="action-btn view" title="View GRT">
                                                    <?php echo number_format($grtamount, 2, '.', ','); ?>
                                                </a>
                                            <?php else: ?>
                                                <?php echo number_format($grtamount, 2, '.', ','); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="amount"><?php echo number_format($netamount, 2, '.', ','); ?></td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <?php if($grnamount == 0): ?>
                                                    <a href="editpo.php?anum=<?php echo $ponumber; ?>&pono=<?php echo $ponumber; ?>&menuid=<?php echo $menu_id; ?>" 
                                                       class="action-btn edit" title="Edit PO">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Not Editable</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <?php if($grnamount >= 0): ?>
                                        <?php
                                        $detailed_cnt = 1;
                                        $qrypodetailed = "SELECT auto_number,billdate,itemcode,itemname,rate,packagequantity,username,fxtotamount,free FROM purchaseorder_details WHERE billnumber = '$ponumber' AND recordstatus<>'deleted'";
                                        $execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        
                                        while($respodetailed = mysqli_fetch_array($execpodetailed)) {
                                            $auto_number_det = $respodetailed["auto_number"];
                                            $billdate_det = $respodetailed["billdate"];
                                            $itemcode_det = $respodetailed["itemcode"];
                                            $itemname_det = $respodetailed["itemname"];
                                            $rate_det = $respodetailed["rate"];
                                            $pkgqnty_det = $respodetailed["packagequantity"];
                                            $username_det = $respodetailed["username"];
                                            $fxamount_det = $respodetailed["fxtotamount"];
                                            $totamountval_det = $totamountval_det + $fxamount_det;
                                            $po_freeqty_det = $respodetailed["free"];
                                            
                                            $mrnqry = "SELECT sum(`itemtotalquantity`) totalrecqty FROM `materialreceiptnote_details` WHERE ponumber='$ponumber' AND itemcode='$itemcode_det'";
                                            $execmrn = mysqli_query($GLOBALS["___mysqli_ston"], $mrnqry) or die ("Error in Total Rec Quantity Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $resmrn = mysqli_fetch_array($execmrn);
                                            $recqty_det = $resmrn['totalrecqty'];
                                            $recqty = preg_replace('~\.0+$~','',$recqty_det);
                                            $balqty_det = $pkgqnty_det - $recqty_det;
                                            
                                            $qry = "SELECT sum(free) free FROM `materialreceiptnote_details` WHERE ponumber='$ponumber' AND itemcode='$itemcode_det' and free !='' ";
                                            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $res = mysqli_fetch_assoc($exec);
                                            $recfreeqty_det = $res['free'];
                                            ?>
                                            
                                            <?php if($detailed_cnt == 1): ?>
                                                <tr class="item-details-row">
                                                    <td colspan="11">
                                                        <table class="item-details-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Item Code</th>
                                                                    <th>Item Name</th>
                                                                    <th class="text-right">Rate</th>
                                                                    <th class="text-right">Ord.Qty</th>
                                                                    <th class="text-right">Free.Qty</th>
                                                                    <th class="text-right">Recd.Qty</th>
                                                                    <th class="text-right">Recd.Free.Qty</th>
                                                                    <th class="text-right">Bal.Qty</th>
                                                                    <th class="text-right">Amount</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            <?php endif; ?>
                                            
                                            <?php if($recqty_det == 0): ?>
                                                <tr>
                                                    <td><?php echo date('d/m/Y', strtotime($billdate_det)); ?></td>
                                                    <td><?php echo htmlspecialchars($itemcode_det); ?></td>
                                                    <td><?php echo htmlspecialchars($itemname_det); ?></td>
                                                    <td class="amount"><?php echo $rate_det; ?></td>
                                                    <td class="amount"><?php echo $pkgqnty_det; ?></td>
                                                    <td class="amount"><?php echo $po_freeqty_det; ?></td>
                                                    <td class="amount"><?php echo $recqty_det; ?></td>
                                                    <td class="amount"><?php echo $recfreeqty_det; ?></td>
                                                    <td class="amount"><?php echo $balqty_det; ?></td>
                                                    <td class="amount"><?php echo number_format($fxamount_det, 2, '.', ','); ?></td>
                                                    <td>
                                                        <a href="editpo.php?anum=<?php echo $auto_number_det; ?>&pono=<?php echo $ponumber; ?>&menuid=<?php echo $menu_id; ?>" 
                                                           class="action-btn edit" title="Edit Item">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php
                                            $detailed_cnt++;
                                        }
                                        ?>
                                        
                                        <?php if($detailed_cnt > 1): ?>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php
                                }
                                
                                $grandgrn = $grandgrn + $totalgrn;
                                $grandgrt = $grandgrt + $totalgrt;
                                $grandnet = $grandnet + $totalnet;
                            }
                            ?>
                                
                                <!-- Summary Row -->
                                <tr class="summary-row">
                                    <td colspan="6" class="text-right"><strong>Total</strong></td>
                                    <td class="amount amount-large"><strong><?php echo number_format($lpototal, 2, '.', ','); ?></strong></td>
                                    <td class="amount amount-large"><strong><?php echo number_format($totalgrn, 2, '.', ','); ?></strong></td>
                                    <td class="amount amount-large"><strong><?php echo number_format($totalgrt, 2, '.', ','); ?></strong></td>
                                    <td class="amount amount-large"><strong><?php echo number_format($totalnet, 2, '.', ','); ?></strong></td>
                                    <td></td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/purchase-order-edit-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript -->
    <script>
    $(function() {
        // AUTO COMPLETE SEARCH FOR SUPPLIER NAME
        $('#suppliername').autocomplete({
            source:'ajaxsuppliernewserach.php', 
            minLength:1,
            delay: 0,
            html: true, 
            select: function(event,ui){
                var supplier = this.id;
                var code = ui.item.id;
                var suppliername = supplier.split('suppliername');
                var suppliercode = suppliername[1];
                $('#suppliercode'+suppliercode).val(code);
            },
        });
    });
    </script>
</body>
</html>
