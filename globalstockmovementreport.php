<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$searchmedicinename = "";
$colorloopcount = '';
$openingbalance = 0;
$user = '';

// Default date range
$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');

// Get request parameters
if (isset($_REQUEST["medicinecode"])) { 
    $medicinecode = $_REQUEST["medicinecode"]; 
} else { 
    $medicinecode = ""; 
}

if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

// Process form submission
if ($frmflag1 == 'frmflag1') {
    if (isset($_REQUEST["searchitemcode"])) { 
        $medicinecode = $_REQUEST["searchitemcode"]; 
    } else { 
        $medicinecode = ""; 
    }
    
    if (isset($_REQUEST["itemname"])) { 
        $searchmedicinename = $_REQUEST["itemname"]; 
    } else { 
        $searchmedicinename = ""; 
    }
    
    if (isset($_REQUEST["categoryname"])) { 
        $categoryname = $_REQUEST["categoryname"]; 
    } else { 
        $categoryname = ""; 
    }
    
    if (isset($_REQUEST["store"])) { 
        $store = $_REQUEST["store"]; 
    } else { 
        $store = ""; 
    }
    
    if (isset($_REQUEST["store"])) { 
        $storecode = $_REQUEST["store"]; 
    } else { 
        $storecode = ""; 
    }
    
    if (isset($_REQUEST["ADate1"])) { 
        $ADate1 = $_REQUEST["ADate1"]; 
    } else { 
        $ADate1 = ""; 
    }
    
    if (isset($_REQUEST["ADate2"])) { 
        $ADate2 = $_REQUEST["ADate2"]; 
    } else { 
        $ADate2 = ""; 
    }
    
    if (isset($_REQUEST["ADate1"])) { 
        $AbDate1 = $_REQUEST["ADate1"]; 
    } else { 
        $AbDate1 = ""; 
    }
    
    if (isset($_REQUEST["ADate2"])) { 
        $AbDate2 = $_REQUEST["ADate2"]; 
    } else { 
        $AbDate2 = ""; 
    }
}

// Get user location details
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

$locationcode = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Stock Movement Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/globalstockmovement-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script type="text/javascript" src="js/autosuggestmedicine2.js"></script>
    <script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
    <script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <?php include("js/dropdownlist1scripting1stock1.php"); ?>
</head>
<body onLoad="return funcCustomerDropDownSearch1();">
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
        <a href="inventory.php">📦 Inventory</a>
        <span>→</span>
        <span>Global Stock Movement Report</span>
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
                        <a href="inventory.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Inventory</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="globalstockmovementreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Stock Movement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="globalclosingstockreport.php" class="nav-link">
                            <i class="fas fa-warehouse"></i>
                            <span>Closing Stock</span>
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
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Global Stock Movement Report</h2>
                    <p>Track stock movements across all locations and stores for detailed inventory analysis.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="globalclosingstockreport.php" class="btn btn-outline">
                        <i class="fas fa-warehouse"></i> Closing Stock
                    </a>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Parameters</h3>
                </div>
                
                <form name="stockinward" action="globalstockmovementreport.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onChange="storefunction(this.value)">
                                <option value="">Select Location</option>
                                <?php
                                $query = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                    ?>
                                    <option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>>
                                        <?php echo $reslocation; ?>
                                    </option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="store" class="form-label">Store</label>
                            <select name="store" id="store" class="form-input">
                                <option value="">Select Store</option>
                                <?php 
                                $loc = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
                                $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
                                $frmflag1 = isset($_REQUEST['frmflag1']) ? $_REQUEST['frmflag1'] : '';
                                $store = isset($_REQUEST['store']) ? $_REQUEST['store'] : '';
                                
                                if ($frmflag1 == 'frmflag1') {
                                    $loc = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
                                    $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
                                    $query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
                                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res5 = mysqli_fetch_array($exec5)) {
                                        $res5anum = $res5["storecode"];
                                        $res5name = $res5["store"];
                                        ?>
                                        <option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>>
                                            <?php echo $res5name;?>
                                        </option>
                                        <?php 
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="categoryname" class="form-label">Category</label>
                            <select name="categoryname" id="categoryname" class="form-input">
                                <?php
                                $categoryname = isset($_REQUEST['categoryname']) ? $_REQUEST['categoryname'] : '';
                                if ($categoryname != '') {
                                    ?>
                                    <option value="<?php echo htmlspecialchars($categoryname); ?>" selected="selected">
                                        <?php echo htmlspecialchars($categoryname); ?>
                                    </option>
                                    <option value="">Show All Category</option>
                                    <?php
                                } else {
                                    ?>
                                    <option selected="selected" value="">Show All Category</option>
                                    <?php
                                }
                                ?>
                                <?php
                                $query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
                                $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res42 = mysqli_fetch_array($exec42)) {
                                    $categoryname = $res42['categoryname'];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($categoryname); ?>">
                                        <?php echo htmlspecialchars($categoryname); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="itemname" class="form-label">Item Name</label>
                            <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
                            <input type="hidden" name="searchitemcode" id="searchitemcode" value="<?php echo htmlspecialchars($medicinecode); ?>">
                            <input name="itemname" type="text" id="itemname" class="form-input" 
                                   placeholder="Search item name..." autocomplete="off" 
                                   value="<?php echo htmlspecialchars($searchmedicinename); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input" 
                                       value="<?php echo $transactiondatefrom; ?>" readonly="readonly" 
                                       onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     style="cursor:pointer" class="date-picker-icon"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" class="form-input" 
                                       value="<?php echo $transactiondateto; ?>" readonly="readonly" 
                                       onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     style="cursor:pointer" class="date-picker-icon"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="locationnamenew" value="<?php echo htmlspecialchars($locationname); ?>">
                        <input type="hidden" name="locationcodenew" value="<?php echo $res12locationanum; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                        <input type="hidden" name="medicinecode" id="medicinecode" value="<?php echo htmlspecialchars($medicinecode); ?>" readonly />
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <?php if ($frmflag1 == 'frmflag1'): ?>
            <div class="results-section">
                <div class="results-header">
                    <h3>Stock Movement Report</h3>
                    <div class="results-info">
                        <span class="date-range">
                            <i class="fas fa-calendar"></i>
                            Date Range: <?php echo $transactiondatefrom.' To '.$transactiondateto; ?>
                        </span>
                        <?php if ($searchmedicinename != ''): ?>
                        <span class="item-name">
                            <i class="fas fa-box"></i>
                            Item: <?php echo htmlspecialchars($searchmedicinename); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table sticky-header">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Batch</th>
                                <th>Opening Stock</th>
                                <th>Receipts</th>
                                <th>Issues</th>
                                <th>Returns</th>
                                <th>Closing Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($searchmedicinename != '') {
                                $noofdays = strtotime($ADate2) - strtotime($ADate1);
                                $noofdays = $noofdays/(3600*24);
                                
                                // Get store for location
                                $loc = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
                                $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
                                $query5ll = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
                                if($store!='') {
                                    $query5ll .=" and ms.storecode='".$store."'";
                                }
                                $exec5ll = mysqli_query($GLOBALS["___mysqli_ston"], $query5ll) or die ("Error in Query5ll".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res5ll = mysqli_fetch_array($exec5ll)) {
                                    $store = $res5ll["storecode"];
                                    $res5name = $res5ll["store"];
                                    ?>
                                    <tr class="store-header">
                                        <td colspan="7" class="store-name">
                                            <i class="fas fa-store"></i>
                                            <?php echo htmlspecialchars($res5name); ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $ADate1 = $AbDate1;
                                    for($i=0; $i<=$noofdays; $i++) {
                                        if($i!=0) {
                                            $ADate1 = date('Y-m-d', strtotime($ADate1) + (1*3600*24));
                                            $ADate2 = $ADate1;
                                        } else {
                                            $ADate2 = $ADate1;
                                        }
                                        ?>
                                        <tr class="date-header">
                                            <td colspan="7" class="date-name">
                                                <i class="fas fa-calendar-day"></i>
                                                <?php echo $ADate1; ?>
                                            </td>
                                        </tr>
                                        <?php
                                        include("openingbalancecalculation.php");
                                        $balance = $openingbalance;
                                        ?>
                                        <tr class="item-header">
                                            <td colspan="7" class="item-name">
                                                <i class="fas fa-box"></i>
                                                <?php echo htmlspecialchars($searchmedicinename); ?>
                                            </td>
                                        </tr>
                                        <tr class="opening-balance">
                                            <td class="description">
                                                <i class="fas fa-arrow-up"></i>
                                                Opening Balance
                                            </td>
                                            <td class="batch">-</td>
                                            <td class="opening-stock"><?php echo $openingbalance; ?></td>
                                            <td class="receipts">-</td>
                                            <td class="issues">-</td>
                                            <td class="returns">-</td>
                                            <td class="closing-stock"><?php echo $balance; ?></td>
                                        </tr>
                                        <?php
                                        if($store == 'all') {
                                            $query1 = "select entrydocno,transaction_date,transaction_quantity,batchnumber,username,description,patientname,patientvisitcode,transactionfunction,auto_number from transaction_stock where locationcode = '".$locationcode."' AND itemcode like '%$medicinecode%' and transaction_date between '$ADate1' and '$ADate2'";
                                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $num1 = mysqli_num_rows($exec1);
                                        } else {
                                            $query1 = "select entrydocno,transaction_date,transaction_quantity,batchnumber,username,description,patientname,patientvisitcode,transactionfunction,auto_number from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
                                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        }
                                        
                                        while($res1 = mysqli_fetch_array($exec1)) {
                                            $billnumber = $res1['entrydocno'];
                                            $suppliername = '';
                                            $billdate = $res1['transaction_date'];
                                            $quantity = $res1['transaction_quantity'];
                                            $purchaseopeningstock = 0;
                                            $purchaseissues = 0;
                                            $purchasereturns = 0;
                                            $batch = $res1['batchnumber'];
                                            $user = $res1['username'];
                                            
                                            $description = $res1['description'];
                                            $patientname = $res1['patientname'];
                                            $patientvisitcode = $res1['patientvisitcode'];
                                            $transactionfunction = $res1['transactionfunction'];
                                            
                                            if($description=="" && $transactionfunction=='1' && substr($billnumber,0,3)=="ADJ"){
                                                $description='Stock Adj Add Stock';
                                            }else if($description=="" && $transactionfunction=='0' && substr($billnumber,0,3)=="ADJ"){
                                                $description="Stock Adj Minus Stock";
                                            }
                                            
                                            if($transactionfunction=='1') {
                                                $purchaseissues = $quantity;
                                                $purchasereturns = 0;
                                                $openingbalance = $openingbalance + $quantity;
                                                $purchasequantity = $openingbalance;
                                            } else {
                                                $purchaseissues = 0;
                                                $purchasereturns = $quantity;
                                                $openingbalance = $openingbalance - $quantity;
                                                $purchasequantity = $openingbalance;
                                            }
                                            
                                            $colorloopcount = $colorloopcount + 1;
                                            $showcolor = ($colorloopcount & 1); 
                                            if ($showcolor == 0) {
                                                $colorcode = 'class="alternate-row"';
                                            } else {
                                                $colorcode = 'class="normal-row"';
                                            }
                                            
                                            // Generate description based on transaction type
                                            $transaction_description = '';
                                            if($description=='Purchase'||$description=='OPENINGSTOCK') {
                                                $query8 = "select suppliername from master_purchase where billnumber = '$billnumber'";
                                                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res8 = mysqli_fetch_array($exec8);
                                                $suppliername = $res8['suppliername'];
                                                $transaction_description = 'By Purchase ('.$billnumber.','.$suppliername.' , '.$billdate.','.$user.')';
                                                $purchaseissues='0';
                                            } else if($description=='Purchase Return') {
                                                $query8 = "select suppliername from purchasereturn_details where billnumber = '$billnumber'";
                                                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res8 = mysqli_fetch_array($exec8);
                                                $suppliername = $res8['suppliername'];
                                                $transaction_description = 'By Purchase Return ('.$billnumber.','.$suppliername.' , '.$billdate.','.$user.')';
                                                $quantity='0';
                                            } else if($description=='Package'||$description=='Sales'||$description=='IP Direct Sales'||$description=='IP Sales') {
                                                $transaction_description = 'By Issue ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                $purchaseissues=$purchasereturns;
                                                $purchasereturns='0';
                                                $quantity='0';
                                            } else if($description=='IP Sales Return'||$description=='Sales Return') {
                                                $transaction_description = 'By Return ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                $purchasereturns=$purchaseissues;
                                                $purchaseissues='0';
                                                $quantity='0';
                                            } else if($description=='Process') {
                                                $transaction_description = 'By Process ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                $purchaseissues=$purchasereturns;
                                                $purchasereturns='0';
                                                $quantity='0';
                                            } else if($description=='Stock Damaged Minus Stock') {
                                                $transaction_description = 'By Adjust - Damaged ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                $quantity='0';
                                                $purchaseissues = $purchasereturns;
                                                $purchasereturns='0';
                                            } else if($description=='Stock Adj Minus Stock') {
                                                $transaction_description = 'By Adjust - Stk Adj Minus ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                $quantity='0';
                                                $purchaseissues = $purchasereturns;
                                                $purchasereturns='0';
                                            } else if($description=='Stock Adj Add Stock') {
                                                $transaction_description = 'By Adjust - Stk Adj Add ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                $quantity=$purchaseissues;
                                                $purchaseissues='0';
                                            } else if($description=='Stock Expired Minus Stock') {
                                                $transaction_description = 'By Adjust - Expired ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                $quantity='0';
                                                $purchaseissues = $purchasereturns;
                                                $purchasereturns='0';
                                            } else if($description=='Stock Transfer From'||$description=='Stock Transfer To') {
                                                $query8 = "select typetransfer,fromstore,tostore,tolocationname,locationname from master_stock_transfer where docno = '$billnumber'";
                                                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res8 = mysqli_fetch_array($exec8);
                                                $fromstore = $res8['fromstore'];
                                                $tostore = $res8['tostore'];
                                                $tolocationname = $res8['tolocationname'];
                                                $locationname = $res8['locationname'];
                                                $typetransfer = $res8['typetransfer'];
                                                
                                                $query8 = "select store from master_store where storecode = '$fromstore'";
                                                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res8 = mysqli_fetch_array($exec8);
                                                $fromstorename = $res8['store'];
                                                
                                                $query9 = "select store from master_store where storecode = '$tostore'";
                                                $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res9 = mysqli_fetch_array($exec9);
                                                $tostorename = $res9['store'];
                                                
                                                if($typetransfer=="Consumable" || $tostorename=='') {
                                                    $query2a = "select accountname,accountsmain,id from master_accountname where id='$tostore'";
                                                    $exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    $res2a = mysqli_fetch_array($exec2a);
                                                    $tostorename = $res2a["accountname"];
                                                }
                                                
                                                if($description=='Stock Transfer From') {
                                                    $transaction_description = 'By Transfer ('.$fromstorename.' to '.$tostorename.' , '.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                    $purchaseissues=$quantity;
                                                    $purchasereturns='0';
                                                    $quantity='0';
                                                } else {
                                                    $transaction_description = 'By Transfer ('.$fromstorename.' to '.$tostorename.' , '.$billnumber.' ,'.$billdate.' ,'.$user.' )';
                                                    $purchaseissues=0;
                                                    $purchasereturns='0';
                                                }
                                            }
                                            ?>
                                            <tr <?php echo $colorcode; ?>>
                                                <td class="description">
                                                    <i class="fas fa-file-alt"></i>
                                                    <?php echo htmlspecialchars($transaction_description); ?>
                                                </td>
                                                <td class="batch"><?php echo htmlspecialchars($batch); ?></td>
                                                <td class="opening-stock"><?php echo $purchaseopeningstock; ?></td>
                                                <td class="receipts"><?php echo intval($quantity); ?></td>
                                                <td class="issues"><?php echo $purchaseissues; ?></td>
                                                <td class="returns"><?php echo $purchasereturns; ?></td>
                                                <td class="closing-stock"><?php echo intval($purchasequantity); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        $balance = $openingbalance;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Export Actions -->
                <div class="export-actions">
                    <a href="pdf_globalstockmovementreport.php?frmflag1=frmflag1&&ADate1=<?= $AbDate1 ?>&&ADate2=<?= $AbDate2 ?>&&medicinecode=<?php echo $medicinecode; ?>&&searchitemcode=<?php echo $medicinecode; ?>&&itemname=<?php echo $searchmedicinename; ?>&&categoryname=<?php echo $categoryname; ?>&&store=<?php echo $storecode; ?>&&location=<?php echo $location; ?>" 
                       target="_blank" class="btn btn-outline">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/globalstockmovement-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
