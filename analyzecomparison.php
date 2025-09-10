<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$errmsg = '';
$bgcolorcode = '';
$largevalue = 0;
$sno = '';
$colorloopcount = '';

if (isset($_REQUEST["frm1submit1"])) { 
    $frm1submit1 = $_REQUEST["frm1submit1"]; 
} else { 
    $frm1submit1 = ""; 
}

if ($frm1submit1 == 'frm1submit1') {
    foreach($_POST['itemname'] as $key => $value) {
        $itemname = $_POST['itemname'][$key];
        $itemcode = $_POST['itemcode'][$key];
        $suppliername = $_POST['suppliercoa'][$key];
        $suppliercode = $_POST['suppliercode'][$key];
        
        $paynowbillprefix = 'PO-';
        $paynowbillprefix1 = strlen($paynowbillprefix);
        $query2 = "select * from master_rfqpurchaseorder where suppliercode = '$suppliercode' and recordstatus <> 'generated'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $num2 = mysqli_num_rows($exec2);
        $res2 = mysqli_fetch_array($exec2);
        $billnumber = $res2["billnumber"];

        $billdigit = strlen($billnumber);
        if($num2 > 0) {
            $billnumbercode = $billnumber;
            $status = 'generated';
        } else {
            $query24 = "select * from master_rfqpurchaseorder where recordstatus='generated' or recordstatus='ready'";
            $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res24 = mysqli_fetch_array($exec24)) {
                $billnumber = $res24['billnumber'];
                $billdigit = strlen($billnumber);
                $billnumbercode = substr($billnumber, $paynowbillprefix1, $billdigit);
                
                $billnumbercode = intval($billnumbercode);
                if($billnumbercode > $largevalue) {
                    $largevalue = $billnumbercode;
                }
            }
            $billnumbercode = $largevalue;
            $billnumbercode = $billnumbercode + 1;
            $maxanum = $billnumbercode;
            $status = 'ready';
            $billnumbercode = $paynowbillprefix . $maxanum;
            $openingbalance = '0.00';
        }
        
        $query56 = "insert into master_rfqpurchaseorder(companyanum,billnumber,itemcode,itemname,username, ipaddress, billdate,suppliername,suppliercode,recordstatus)
                     values('$companyanum','$billnumbercode','$itemcode','$itemname','$username','$ipaddress','$currentdate','$suppliername','$suppliercode','$status')";
        $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    
    $query16 = "update master_rfq set status = 'generated' where status = ''";
    $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $query17 = "update master_rfqpurchaseorder set recordstatus = 'generated' where recordstatus = 'ready'";
    $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    
    header("location:menupage1.php?mainmenuid=MM029");
}

// Get user location details
$query12 = " select * from login_locationdetails where username = '$username' "; 
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
$res12 = mysqli_fetch_array($exec12);
$locationname = $res12["locationname"]; 
$locationcode = $res12["locationcode"];

// Get RFQ count
$querynw1 = "select count(*) as total from master_rfq where status = ''";
$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$resnw1 = mysqli_fetch_array($execnw1);
$totalRFQ = $resnw1['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyze Comparison - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/analyzecomparison-modern.css?v=<?php echo time(); ?>">
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
        <span>Analyze Comparison</span>
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
                    <li class="nav-item active">
                        <a href="analyzecomparison.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Analyze Comparison</span>
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
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-chart-line"></i> Analyze Comparison</h2>
                    <p>Compare supplier prices and select the best options for procurement</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-primary" onclick="exportToCSV()">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                </div>
            </div>

            <!-- Analysis Section -->
            <div class="analysis-section">
                <div class="analysis-header">
                    <i class="fas fa-chart-bar"></i>
                    <h3>Supplier Price Comparison Analysis</h3>
                </div>
                
                <div class="analysis-info">
                    <div class="info-item">
                        <span class="info-label">Analysis Date</span>
                        <span class="info-value"><?php echo htmlspecialchars($currentdate); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">User</span>
                        <span class="info-value"><?php echo htmlspecialchars($username); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Items</span>
                        <span class="info-value"><?php echo $totalRFQ; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value">Pending Analysis</span>
                    </div>
                </div>

                <!-- Search Bar -->
                <div style="margin: 1.5rem; display: flex; gap: 1rem; align-items: center;">
                    <input type="text" id="searchInput" class="form-input" 
                           placeholder="Search items by name or code..." 
                           style="flex: 1; max-width: 300px;">
                    <button type="button" class="btn btn-secondary" id="clearBtn">
                        <i class="fas fa-times"></i> Clear
                    </button>
                    <span id="searchResults" style="color: var(--text-secondary); font-size: 0.875rem;"></span>
                </div>

                <div class="comparison-table-container">
                    <form action="analyzecomparison.php" method="post" name="form1" id="form1" onSubmit="return validate()">
                        <table class="comparison-table" id="AutoNumber3">
                            <thead>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">ITEM (PKGSIZE, N.UNIT)</th>
                                    <?php
                                    $query1 = "select * from master_rfq where status='' group by suppliername order by auto_number asc";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res1 = mysqli_fetch_array($exec1)) {
                                        $suppliername = $res1['suppliername'];
                                        ?>
                                        <th scope="col"><?php echo htmlspecialchars($suppliername); ?></th>
                                        <?php
                                    }
                                    ?>
                                    <th scope="col">Select Supplier</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query11 = "select * from master_rfq where status='' group by medicinecode order by auto_number asc";
                                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res11 = mysqli_fetch_array($exec11)) {
                                    $itemname = $res11['medicinename'];
                                    $itemcode = $res11['medicinecode'];
                                    $packsize = $res11['packsize'];
                                    $packagequantity = $res11['packagequantity'];
                                    
                                    $sno = $sno + 1;
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                                    ?>
                                    <tr <?php echo $colorcode; ?>>
                                        <td><?php echo $sno; ?></td>
                                        <td>
                                            <div class="item-info">
                                                <span class="item-name"><?php echo htmlspecialchars($itemname); ?></span>
                                                <span class="item-details">(<?php echo htmlspecialchars($packsize); ?>, <?php echo htmlspecialchars($packagequantity); ?>)</span>
                                            </div>
                                        </td>
                                        <input type="hidden" name="itemname[]" id="itemname" value="<?php echo htmlspecialchars($itemname); ?>">
                                        <input type="hidden" name="itemcode[]" id="itemcode" value="<?php echo htmlspecialchars($itemcode); ?>">
                                        <?php
                                        $query12 = "select * from master_rfq where medicinecode='$itemcode' and status = '' order by auto_number asc";
                                        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($res12 = mysqli_fetch_array($exec12)) {
                                            $rate = $res12['rate'];
                                            
                                            $query13 = "select min(rate) as lowestrate from master_rfq where rate <> '0.00' and medicinecode='$itemcode' and status = ''";
                                            $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $res13 = mysqli_fetch_array($exec13);
                                            $lowestrate = $res13['lowestrate'];
                                            
                                            $query14 = "select max(rate) as higherrate from master_rfq where rate <> '0.00' and medicinecode='$itemcode' and status = ''";
                                            $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $res14 = mysqli_fetch_array($exec14);
                                            $higherrate = $res14['higherrate'];
                                            
                                            $query15 = "select avg(rate) as averagerate from master_rfq where rate <> '0.00' and medicinecode='$itemcode' and status = ''";
                                            $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $res15 = mysqli_fetch_array($exec15);
                                            $averagerate = $res15['averagerate'];
                                            
                                            $priceClass = '';
                                            if($lowestrate == $rate) {
                                                $priceClass = 'price-lowest';
                                            } else if($higherrate == $rate) {
                                                $priceClass = 'price-highest';
                                            } else if($averagerate == $rate) {
                                                $priceClass = 'price-average';
                                            }
                                            ?>
                                            <td class="price-cell <?php echo $priceClass; ?>" 
                                                data-price="<?php echo $rate; ?>" 
                                                data-item="<?php echo $itemcode; ?>">
                                                <?php echo number_format($rate, 2); ?>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                        <td>
                                            <div class="supplier-selection">
                                                <input type="text" name="suppliercoa[]" 
                                                       id="paynowlabcoa<?php echo $sno; ?>" 
                                                       class="supplier-input" 
                                                       placeholder="Select supplier..."
                                                       required>
                                                <button type="button" class="map-btn" 
                                                        onclick="coasearch('<?php echo $sno; ?>')" 
                                                        title="Map Supplier">
                                                    <i class="fas fa-search"></i> Map
                                                </button>
                                                <input type="hidden" name="paynowlabtype6" id="paynowlabtype<?php echo $sno; ?>">
                                                <input type="hidden" name="suppliercode[]" id="paynowlabcode<?php echo $sno; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <input type="hidden" name="serial" id="serial" value="<?php echo $sno; ?>">
                            </tbody>
                        </table>
                        
                        <div class="form-actions">
                            <input type="hidden" name="frm1submit1" value="frm1submit1" />
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="save-btn">
                                <i class="fas fa-save"></i> Save Analysis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/analyzecomparison-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



