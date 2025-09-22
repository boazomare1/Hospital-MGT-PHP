<?php
session_start();
set_time_limit(0);

include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION["companycode"];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$searchmedicinename = "";
$colorloopcount = '';
$openingbalance = 0;
$user = '';

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');
$ADate1 = $transactiondatefrom;
$ADate2 = $transactiondateto;

// Handle form submissions
if (isset($_REQUEST["medicinecode"])) { $medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    if (isset($_REQUEST["searchitemcode"])) { $medicinecode = $_REQUEST["searchitemcode"]; } else { $medicinecode = ""; }
    if (isset($_REQUEST["itemname"])) { $searchmedicinename = $_REQUEST["itemname"]; } else { $searchmedicinename = ""; }
    if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
    if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
    if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
    if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
}

// Get location details
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
    <title>Expiry Date Update - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/expiry-update-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for datepicker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script type="text/javascript" src="js/autosuggestmedicine2.js"></script>
    <script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
    <script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <link href="js/jquery-ui.css" rel="stylesheet">
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
        <a href="inventory_master.php">Inventory Management</a>
        <span>→</span>
        <span>Expiry Date Update</span>
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
                        <a href="inventory_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Inventory Management</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="expirydtupdate.php" class="nav-link">
                            <i class="fas fa-calendar-times"></i>
                            <span>Expiry Date Update</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stock_report.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Stock Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inventory_reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Inventory Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="supplier_master.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Supplier Management</span>
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
                    <h2>Expiry Stock Report & Update</h2>
                    <p>Search and update expiry dates for inventory items with inline editing capabilities.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportResults()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>
            
            <!-- Search Form Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Search Criteria</h3>
                    <span class="form-help">Filter items by location, store, category, and item name</span>
                </div>
                
                <form name="stockinward" action="expirydtupdate.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location" class="form-label required">Location</label>
                            <select name="location" id="location" class="form-select" onChange="storefunction(this.value)">
                                <option value="">-Select Location-</option>
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                ?>
                                <option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>>
                                    <?php echo htmlspecialchars($reslocation); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="store" class="form-label">Store</label>
                            <select name="store" id="store" class="form-select">
                                <option value="">-Select Store-</option>
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
                                    <?php echo htmlspecialchars($res5name); ?>
                                </option>
                                <?php }} ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="categoryname" class="form-label">Category</label>
                            <select name="categoryname" id="categoryname" class="form-select">
                                <?php
                                $categoryname = $_REQUEST['categoryname'];
                                if ($categoryname != '') {
                                ?>
                                <option value="<?php echo htmlspecialchars($categoryname); ?>" selected="selected">
                                    <?php echo htmlspecialchars($categoryname); ?>
                                </option>
                                <option value="">Show All Category</option>
                                <?php } else { ?>
                                <option selected="selected" value="">Show All Category</option>
                                <?php } ?>
                                
                                <?php
                                $query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
                                $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res42 = mysqli_fetch_array($exec42)) {
                                    $categoryname_option = $res42['categoryname'];
                                ?>
                                <option value="<?php echo htmlspecialchars($categoryname_option); ?>">
                                    <?php echo htmlspecialchars($categoryname_option); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="itemname" class="form-label">Search Item</label>
                            <div class="search-input-container">
                                <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
                                <input type="hidden" name="searchitemcode" id="searchitemcode" value="<?= $medicinecode; ?>">
                                <input name="itemname" type="text" id="itemname" class="form-input search-input" 
                                       autocomplete="off" value="<?php echo htmlspecialchars($searchmedicinename); ?>" 
                                       placeholder="Enter item name to search...">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="medicinecode" class="form-label">Item Code</label>
                            <input type="hidden" name="medicinecode" id="medicinecode" value="<?php echo htmlspecialchars($medicinecode); ?>" />
                            <input type="text" class="form-input readonly" value="<?php echo htmlspecialchars($medicinecode); ?>" readonly>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <input type="hidden" name="locationnamenew" value="<?php echo htmlspecialchars($locationname); ?>">
                        <input type="hidden" name="locationcodenew" value="<?php echo htmlspecialchars($res12locationanum); ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                        
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Search Items
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset Form
                        </button>
                    </div>
                </form>
            </div>
            
            <?php if ($frmflag1 == 'frmflag1'): ?>
            <!-- Results Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <div class="data-table-title">
                        <i class="fas fa-calendar-times"></i>
                        <h3>Expiry Stock Results</h3>
                    </div>
                    <div class="data-table-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="selectAllItems()">
                            <i class="fas fa-check-square"></i>
                            Select All
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="clearAllSelections()">
                            <i class="fas fa-square"></i>
                            Clear All
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table" id="expiryResultsTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Batch No</th>
                                <th>Expiry Date</th>
                                <th>Supplier</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
                            if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
                            
                            $noofdays = strtotime($ADate2) - strtotime($ADate1);
                            $noofdays = $noofdays/(3600*24);
                            
                            $loc = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
                            $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
                            $sno = 0;
                            
                            $query99 = "select itemcode,expirydate,suppliername,batchnumber,itemname,sum(batch_quantity) as batch_quantity,categoryname,cost from ((select ts.itemcode as itemcode,pd.expirydate as expirydate,pd.suppliername as suppliername,ts.batchnumber as batchnumber,ts.itemname as itemname,ts.batch_quantity as batch_quantity,pd.categoryname as categoryname,ts.rate as cost from transaction_stock as ts  JOIN purchase_details as pd ON (ts.batchnumber = pd.batchnumber and ts.fifo_code = pd.fifo_code) where ts.batch_stockstatus = 1 and ts.locationcode = '".$loc."' and ts.storecode ='".$store."'  and ts.itemcode ='$medicinecode' group by ts.itemcode,ts.fifo_code,ts.batchnumber )";
                            $query99 .= " union (select ts1.itemcode as itemcode,mrn.expirydate as expirydate,mrn.suppliername as suppliername,ts1.batchnumber as batchnumber,ts1.itemname as itemname,ts1.batch_quantity as batch_quantity,mrn.categoryname as categoryname,ts1.rate as cost from transaction_stock as ts1 LEFT JOIN materialreceiptnote_details as mrn ON (ts1.batchnumber = mrn.batchnumber and ts1.fifo_code = mrn.fifo_code) where ts1.batch_stockstatus = 1 and ts1.locationcode = '".$loc."' and ts1.storecode ='".$store."' and mrn.categoryname like '%".$categoryname."%'  and mrn.companyanum = '$companyanum' and ts1.itemcode ='$medicinecode' group by ts1.itemcode,ts1.fifo_code,ts1.batchnumber)) res group by res.itemcode,res.batchnumber";
                            
                            $exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if (mysqli_num_rows($exec99) == 0): ?>
                            <tr>
                                <td colspan="10" class="no-data">
                                    <i class="fas fa-search"></i>
                                    <h3>No Items Found</h3>
                                    <p>No expiry stock items match your search criteria. Try adjusting your filters.</p>
                                </td>
                            </tr>
                            <?php else:
                            while ($res99 = mysqli_fetch_array($exec99)) {
                                $res99itemcode = $res99['itemcode']; 
                                $res99categoryname = $res99['categoryname'];
                                $res99expirydate = $res99['expirydate'];
                                $res59suppliername = $res99['suppliername'];
                                $res59batchnumber = $res99['batchnumber'];
                                $res59itemname = trim($res99['itemname']);
                                $updatedate = date('Y-m-d');
                                
                                // Calculate current stock
                                $query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$res99itemcode' and locationcode='$loc' and storecode = '$store' and batchnumber = '$res59batchnumber' and recorddate <= '$updatedate' and transactionfunction='1'";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res1 = mysqli_fetch_array($exec1);
                                $currentstock1 = $res1['currentstock'];
                                
                                $query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$res99itemcode' and locationcode='$location' and storecode='$store' and batchnumber = '$res59batchnumber' and recorddate <= '$updatedate' and transactionfunction='0'";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res1 = mysqli_fetch_array($exec1);
                                $currentstock2 = $res1['currentstock'];
                                
                                $batch_quantity = $currentstock1 - $currentstock2;
                                
                                // Get cost
                                $query2 = "select purchaseprice from master_medicine where itemcode='$res99itemcode'";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res2 = mysqli_fetch_array($exec2);
                                $cost = $res2['purchaseprice'];
                                
                                if($cost == '') $cost = $res99['cost'];
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = 'bgcolor="#ecf0f5"';
                                }
                                
                                $sno = $sno + 1;
                            ?>
                            <tr <?php echo $colorcode; ?> id="<?php echo $sno; ?>">
                                <td class="item-number"><?php echo $sno; ?></td>
                                <td class="item-code"><?php echo htmlspecialchars($res99itemcode); ?></td>
                                <td class="item-category"><?php echo htmlspecialchars($categoryname); ?></td>
                                <td class="item-name"><?php echo htmlspecialchars($res59itemname); ?></td>
                                <td class="batch-number">
                                    <div class="batch-display batchupdatestatic">
                                        <span class="updatebatch" id="uibatch_<?php echo $sno;?>"><?php echo htmlspecialchars($res59batchnumber); ?></span>
                                    </div>
                                    <div class="batch-edit batchupdatetd" style="display:none;">
                                        <input id="batchupdate_<?php echo $sno;?>" name="batchupdate[]" class="form-input batch-input" 
                                               value="<?php echo htmlspecialchars($res59batchnumber); ?>" size="10" />
                                    </div>
                                </td>
                                <td class="expiry-date">
                                    <div class="expiry-display expirydatetdstatic">
                                        <span class="expdate" id="uiexpirydate_<?php echo $sno;?>"><?php echo htmlspecialchars($res99expirydate); ?></span>
                                    </div>
                                    <div class="expiry-edit expirydatetd" style="display:none;">
                                        <div class="date-input-container">
                                            <input class="expdatepicker form-input" id="expdate_<?php echo $sno;?>" name="expdate[]" 
                                                   value="<?php echo htmlspecialchars($res99expirydate); ?>" size="10" readonly />
                                            <i class="fas fa-calendar-alt datepicker-icon" 
                                               onClick="javascript:NewCssCal('expdate_<?php echo $sno;?>','yyyyMMdd','','','','','future')"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="supplier-name"><?php echo htmlspecialchars($res59suppliername); ?></td>
                                <td class="quantity"><?php echo number_format($batch_quantity); ?></td>
                                <td class="cost">$<?php echo number_format($cost, 2); ?></td>
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <a class="action-btn edit-btn edititem" id="<?php echo $sno; ?>" href="#" title="Edit Expiry Date">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="action-btn save-btn saveitem" id="s_<?php echo $sno; ?>" href="#" style="display:none;" title="Save Changes">
                                            <i class="fas fa-save"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Hidden fields -->
                            <input type="hidden" name="batchno[]" id="batchno_<?php echo $sno;?>" value="<?php echo htmlspecialchars($res59batchnumber); ?>" />
                            <input type="hidden" name="itemcode[]" id="itemcode_<?php echo $sno;?>" value="<?php echo htmlspecialchars($res99itemcode); ?>" />
                            <input type="hidden" name="itemname[]" id="itemname_<?php echo $sno;?>" value="<?php echo htmlspecialchars($res59itemname); ?>" />
                            <input type="hidden" name="expirydate[]" id="expirydate_<?php echo $sno;?>" value="<?php echo htmlspecialchars($res99expirydate); ?>" />
                            
                            <?php } endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table-summary">
                    <div class="summary-item">
                        <i class="fas fa-list"></i>
                        <span>Total Items: <?php echo $sno; ?></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-info-circle"></i>
                        <span>Click Edit to update expiry dates and batch numbers</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/expiry-update-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script language="javascript">
        // Legacy functions preserved for compatibility
        function funcOnLoadBodyFunctionCall() {
            funcCustomerDropDownSearch4();
        }
        
        function Locationcheck() {
            if(document.getElementById("location").value == '') {
                alert("Please Select Location");
                document.getElementById("location").focus();
                return false;
            }
        }
        
        function storefunction(loc) {
            var username = document.getElementById("username").value;
            var xmlhttp;
            
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("store").innerHTML = xmlhttp.responseText;
                }
            }
            
            xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
            xmlhttp.send();
        }
        
        function disableEnterKey() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;     //IE
            } else {
                key = e.which;     //firefox
            }
            
            if(key == 13) { // if enter key press
                return false;
            } else {
                return true;
            }
        }
        
        function deleterecord1(varEntryNumber, varAutoNumber) {
            var varEntryNumber = varEntryNumber;
            var varAutoNumber = varAutoNumber;
            var fRet;
            
            fRet = confirm('Are you sure want to delete the stock entry no. '+varEntryNumber+' ?');
            
            if (fRet == false) {
                alert("Stock Entry Delete Not Completed.");
                return false;
            } else {
                window.location = "stockreport2.php?task=del&&delanum="+varAutoNumber;
            }
        }
        
        function saveExpDate(date) {
            alert('date selected');
        }
        
        // Modern functions
        function refreshPage() {
            window.location.reload();
        }
        
        function exportResults() {
            // Export functionality
            const table = document.getElementById('expiryResultsTable');
            if (table) {
                const rows = table.querySelectorAll('tbody tr');
                let csvContent = 'No,Item Code,Category,Item Name,Batch No,Expiry Date,Supplier,Quantity,Cost\n';
                
                rows.forEach(function(row) {
                    const cells = row.querySelectorAll('td');
                    if (cells.length > 1 && !row.querySelector('.no-data')) {
                        const rowData = Array.from(cells).slice(0, -1).map(cell => `"${cell.textContent.trim()}"`);
                        csvContent += rowData.join(',') + '\n';
                    }
                });
                
                const blob = new Blob([csvContent], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'expiry_stock_report.csv';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }
        }
        
        function selectAllItems() {
            // Select all items functionality
            console.log('Select all items');
        }
        
        function clearAllSelections() {
            // Clear all selections functionality
            console.log('Clear all selections');
        }
        
        // jQuery document ready
        $(document).ready(function(){
            $( ".edititem" ).click(function() {
                var clickedid = $(this).attr('id');
                var current_expdate = $('tr#'+clickedid).find("div.expdate").text();
                var current_batch = $('tr#'+clickedid).find("div.updatebatch").text();
                
                $('tr#'+clickedid).find("td.expirydatetd").show();
                $('tr#'+clickedid).find("td.expirydatetdstatic").hide();
                $('tr#'+clickedid).find("td.batchupdatetd").show();
                $('tr#'+clickedid).find("td.batchupdatestatic").hide();
                $('#batchupdate_'+clickedid).val(current_batch);
                $('#expdate_'+clickedid).val(current_expdate);
                $('#s_'+clickedid).show();
                
                return false;
            });
            
            $( ".saveitem" ).click(function() {
                var clickedid = $(this).attr('id');
                var idstr = clickedid.split('s_');
                var id = idstr[1];
                var expiry_date = $('#expdate_'+id).val();
                var batchnumber = $('#batchno_'+id).val();
                var itemcode = $('#itemcode_'+id).val();
                var itemname = $('#itemname_'+id).val();
                var newbatch = $('#batchupdate_'+id).val();
                
                $.ajax({
                    url: 'ajax/ajaxcommon.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { 
                        itemcode: itemcode, 
                        batchnumber: batchnumber,
                        expirydate: expiry_date,
                        itemname: itemname,
                        newbatch: newbatch
                    },
                    success: function (data) { 
                        var msg = data.msg;
                        if(data.status == 1) {
                            $('#expirydate_'+id).val(expiry_date);
                            $('#newbatch_'+id).val(newbatch);
                            $('tr#'+id).find("td.expirydatetd").hide();
                            $('tr#'+id).find("td.expirydatetdstatic").show();
                            $('tr#'+id).find("td.batchupdatetd").hide();
                            $('tr#'+id).find("td.batchupdatestatic").show();
                            $('#uiexpirydate_'+id).text(expiry_date);
                            $('#uibatch_'+id).text(newbatch);
                            $('#s_'+id).hide();
                        } else {
                            alert(msg);
                        }
                    }
                });
                
                return false;
            });
        });
    </script>
</body>
</html>
