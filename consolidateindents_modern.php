<?php
session_start();
ob_start();

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

$docno = $_SESSION['docno'];

// Get location details
$query01 = "select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01 = mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];

$query018 = "select auto_number from master_location where locationcode='$main_locationcode'";
$exc018 = mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018 = mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

// Get location for sort by location purpose
$locationcode = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

if($locationcode != '') {
    $locationcode = $locationcode;
} else {
    $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
    $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res = mysqli_fetch_array($exec);
    $locationname = $res["locationname"];
    $locationcode = $res["locationcode"];
}

$ADate1 = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : '';
$ADate2 = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : '';

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

// Handle form submission
if ($frm1submit1 == 'frm1submit1') {
    $job_title = $_POST['jobtitle'];

    // Update supplier information
    foreach($_POST['docno'] as $key => $value) {
        $docno = $_POST['docno'][$key];
        $numb12 = $_POST['numb12'.$key];

        for($i=1; $i<=$numb12; $i++) {
            $itemcode = $_POST['itemcode'.$key][$i];
            $suppliername = addslashes($_POST['suppliername'.$key][$i]);
            $suppliercode = $_POST['suppliercode'.$key][$i];
            $supplieranum = $_POST['supplieranum'.$key][$i];
            $fx = $_POST['fx'.$key][$i];
            $fxrate = $_POST['fxrate'.$key][$i];
            $reqqty = $_POST['reqqty'.$key][$i];
            $package = $_POST['package'.$key][$i];
            $packagequantity = $_POST['packagequantity'.$key][$i];
            $auto_number = $_POST['auto_number'.$key][$i];
            $purchasetype = $_POST['purchasetype'.$key][$i];
            $fxpkrate = $_POST['fxpkrate'.$key][$i];
            $fxamount = $_POST['fxamount'.$key][$i];
            $rate = $_POST['rate'.$key][$i];
            $amount = $_POST['amount'.$key][$i];

            // Clean numeric values
            $reqqty = str_replace(',', '', $reqqty);
            $rate = str_replace(',', '', $rate);
            $amount = str_replace(',', '', $amount);
            $fxpkrate = str_replace(',', '', $fxpkrate);
            $fxamount = str_replace(',', '', $fxamount);

            if(trim($purchasetype)=='Expenses' || trim($purchasetype)=='Others' || strtoupper(trim($purchasetype))=='ASSETS') {
                $query55 = "update purchase_indent set suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplieranum',currency='$fx',fxamount='$fxrate',quantity='$reqqty',packagequantity='$packagequantity',fxpkrate='$rate',fxtotamount='$amount',rate='$rate',amount='$amount',edited_by='$username',updatedatetime='$updatedatetime' where docno='$docno' and auto_number='$auto_number'";
                $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"])."ERROR IN QUERY55");
            } else {
                $query55 = "update purchase_indent set suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplieranum',currency='$fx',fxamount='$fxrate',quantity='$reqqty',packagequantity='$packagequantity',fxpkrate='$rate',fxtotamount='$amount',rate='$rate',amount='$amount',edited_by='$username',updatedatetime='$updatedatetime' where docno='$docno' and medicinecode='$itemcode' and auto_number='$auto_number'";
                $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"])."ERROR IN QUERY55");

                $query555 = "update master_itemtosupplier set suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplieranum' where itemcode='$itemcode'";
                $exec555 = mysqli_query($GLOBALS["___mysqli_ston"], $query555) or die(mysqli_error($GLOBALS["___mysqli_ston"])."ERROR IN QUERY555"); 
            }
        }
    }

    // Generate purchase orders
    foreach($_POST['select'] as $key => $value) {
        $docno = $_POST['docno'][$key];		 
        $locationname = $_POST['locationname'][$key];
        $locationcode = $_POST['locationcode'][$key];
        $storecode = $_POST['storecode'][$key];
        $storename = $_POST['storename'][$key];				

        $query33 = "select * from purchase_indent where docno='$docno' and approvalstatus='approved' and pogeneration!='completed'";
        $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

        while($res33 = mysqli_fetch_array($exec33)) {
            $itemname = $res33['medicinename'];
            $itemcode = $res33['medicinecode'];
            $quantity = $res33['quantity'];
            $quantity = str_replace(',', '', $quantity);
            $rate = $res33['rate'];
            $amount = $res33['amount'];
            $fxpkrate = $res33['fxpkrate'];
            $fxtotamount = $res33['fxtotamount'];
            $baremarks = $res33['baremarks'];
            $packagequantity = $res33['packagequantity'];
            $purchasetype = $res33['purchasetype'];
            $suppliername = $res33['suppliername'];
            $suppliercode = $res33['suppliercode'];
            $supplieranum = $res33['supplieranum'];
            $auto_number = $res33['auto_number'];
            $currency = $res33['currency'];
            $fxamount = $res33['fxamount'];
            $freeqty = $res33['freeqty'];
            $discount = $res33['discount'];
            $baserate = $res33['baserate'];
            $tax_amount = $res33['tax_amount'];
            $tax_amount = str_replace(',', '', $tax_amount);
            $tax_percentage = $res33['tax_percentage'];
            $discount_by_percent = $res33['discount_by_percent'];

            if($discount_by_percent)
                $discount_per = $discount;
            else
                $discount_per = 0;

            $discount_amt = $baserate - $rate;
            $lpodate = $res33['povalidity'];

            // Generate PO based on purchase type
            if(trim($purchasetype)!='Expenses' && trim($purchasetype)!='Others') {
                // Generate regular PO
                if($suppliername=='') {
                    $query45 = "select suppliername,suppliercode from master_itemtosupplier where itemcode='$itemcode' order by auto_number desc limit 0, 1";
                    $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res45 = mysqli_fetch_array($exec45);
                    $suppliername = $res45['suppliername'];
                    $suppliercode = $res45['suppliercode'];
                    $supplieranum = $res45['supplieranum'];
                }

                // Get PO prefix and generate PO number
                $query3 = "select * from bill_formats where description = 'purchase_order'";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                $paynowbillprefix = $res3['prefix'];
                $paynowbillprefix1 = strlen($paynowbillprefix);

                $query3 = "select * from purchaseorder_details order by auto_number desc limit 0, 1";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $num3 = mysqli_num_rows($exec3);
                $res3 = mysqli_fetch_array($exec3);
                $billnumber = $res3['billnumber'];
                $billdigit = strlen($billnumber);

                if($num3 > 0) {
                    $query2 = "select * from purchaseorder_details where suppliercode = '$suppliercode' and recordstatus = 'Process' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $num2 = mysqli_num_rows($exec2);
                    $res2 = mysqli_fetch_array($exec2);
                    $billnumber = $res2["billnumber"];					
                    $billdigit = strlen($billnumber);

                    if($billnumber != '') {
                        $billnumbercode = $billnumber;
                        $docstatus = '';
                    } else {
                        $query24 = "select * from purchaseorder_details where docstatus = 'new' order by auto_number desc limit 0, 1";
                        $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res24 = mysqli_fetch_array($exec24);
                        $billnumber = $res24['billnumber'];
                        $maxcount = split("-",$billnumber);
                        $maxcount1 = $maxcount[1];
                        $maxanum = $maxcount1+1;				
                        $billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
                        $openingbalance = '0.00';						
                        $docstatus = 'new';
                    }
                } else {
                    $query2 = "select * from purchaseorder_details where docstatus = 'new' order by auto_number desc limit 0, 1";
                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res2 = mysqli_fetch_array($exec2);
                    $billnumber = $res2["billnumber"];
                    $billdigit = strlen($billnumber);

                    if ($billnumber == '') {
                        $billnumbercode = $paynowbillprefix.'1';
                        $openingbalance = '0.00';
                        $docstatus = 'new';
                    }
                }

                $query56 = "insert into purchaseorder_details(companyanum,billnumber,itemcode,itemname,rate,quantity,free,discountpercentage,totalamount,discountamount,username, ipaddress, billdate,purchaseindentdocno,suppliername,suppliercode,supplieranum,packagequantity,recordstatus,docstatus,locationname,locationcode,storename,storecode,currency,fxamount,fxpkrate,fxtotamount,remarks,job_title,baserate,povalidity,discount_by_percent,itemtaxpercentage,itemtaxamount)
                values('$companyanum','$billnumbercode','$itemcode','$itemname','$rate','$quantity','$freeqty','$discount_per','$amount','$discount_amt','$username','$ipaddress','$currentdate','$docno','$suppliername','$suppliercode',$supplieranum,'$packagequantity','Process','$docstatus','".$locationname."','".$locationcode."','".$storename."','".$storecode."','$currency','$fxamount','$fxpkrate','$fxtotamount','$baremarks','$job_title','$baserate','$lpodate','$discount_by_percent','$tax_percentage','$tax_amount')";
                $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		

                $query55 = "update purchase_indent set pogeneration='completed' where docno='$docno' and medicinecode='$itemcode'";
                $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            } else {
                // Generate manual LPO
                $paynowbillprefix = 'MLPO-';
                $paynowbillprefix1 = strlen($paynowbillprefix);

                $query3 = "select * from manual_lpo order by auto_number desc limit 0, 1";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $num3 = mysqli_num_rows($exec3);
                $res3 = mysqli_fetch_array($exec3);
                $billnumber = $res3['billnumber'];
                $billdigit = strlen($billnumber);

                if($num3 > 0) {
                    $query2 = "select * from manual_lpo where suppliercode = '$suppliercode' and recordstatus = 'Process' order by auto_number desc limit 0, 1";
                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $num2 = mysqli_num_rows($exec2);
                    $res2 = mysqli_fetch_array($exec2);
                    $billnumber = $res2["billnumber"];					
                    $billdigit = strlen($billnumber);

                    if($billnumber != '') {
                        $billnumbercode = $billnumber;
                        $docstatus = '';					
                    } else {
                        $query24 = "select * from manual_lpo order by auto_number desc limit 0, 1";
                        $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res24 = mysqli_fetch_array($exec24);
                        $billnumber = $res24['billnumber'];
                        $billdigit = strlen($billnumber);
                        $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);						
                        $billnumbercode = intval($billnumbercode);						
                        $billnumbercode = $billnumbercode + 1;						
                        $maxanum = $billnumbercode;						
                        $billnumbercode = $paynowbillprefix .$maxanum;
                        $openingbalance = '0.00';						
                        $docstatus = 'new';
                    }
                } else {
                    $query2 = "select * from manual_lpo order by auto_number desc limit 0, 1";
                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res2 = mysqli_fetch_array($exec2);
                    $billnumber = $res2["billnumber"];
                    $billdigit = strlen($billnumber);

                    if ($billnumber == '') {
                        $billnumbercode = $paynowbillprefix.'1';
                        $openingbalance = '0.00';
                        $docstatus = 'new';
                    }
                }

                $query56 = "insert into manual_lpo(companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username, ipaddress, entrydate,purchaseindentdocno,purchasetype,suppliername,suppliercode,supplieranum,recordstatus,docstatus,locationname,locationcode,storename,storecode,currency,fxamount,fxpkrate,fxtotamount,remarks,job_title,,itemtaxpercentage,itemtaxamount) values('$companyanum','$billnumbercode','$itemcode','$itemname','$rate','$quantity','$amount','$username','$ipaddress','$currentdate','$docno','$purchasetype','$suppliername','$suppliercode',$supplieranum,'Process','$docstatus','".$locationname."','".$locationcode."','".$storename."','".$storecode."','$currency','$fxamount','$fxpkrate','$fxtotamount','$baremarks','$job_title','$tax_percentage','$tax_amount')";
                $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		

                $query55 = "update purchase_indent set pogeneration='completed' where docno='$docno' and auto_number='$auto_number'";
                $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            }
        }
    }

    // Update record status
    foreach($_POST['select'] as $key => $value) {
        $docno = $_POST['select'][$key];		
        $query53 = "update purchaseorder_details set recordstatus='generated' where recordstatus='Process'";
        $exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		
        $query53 = "update manual_lpo set recordstatus='generated' where recordstatus='Process'";
        $exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
    }

    // Handle re-approval
    foreach($_POST['reapproval'] as $key => $value) {
        $docno = $_POST['reapproval'][$key];	
        $query55 = "update purchase_indent set approvalstatus='1' where docno='$docno'";
        $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
    }

    $errmsg = "Purchase orders generated successfully.";
    $bgcolorcode = 'success';
    header("location:consolidateindents.php");
    exit;
}

// Get PO number for display
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'PO-';
$paynowbillprefix1 = strlen($paynowbillprefix);

$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit = strlen($billnumber);

if ($billnumber == '') {
    $billnumbercode = 'PO-'.'1';
    $openingbalance = '0.00';
} else {
    $billnumber = $res2["docno"];
    $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
    $billnumbercode = intval($billnumbercode);
    $billnumbercode = $billnumbercode + 1;
    $maxanum = $billnumbercode;
    $billnumbercode = 'PO-' .$maxanum;
    $openingbalance = '0.00';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolidate Indents - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/consolidateindents-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/datetimepicker_css.js"></script>
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
        <span>Consolidate Indents</span>
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
                        <a href="purchase_indent.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Purchase Indent</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="consolidateindents.php" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <span>Consolidate Indents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="purchaseorder_details.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Purchase Orders</span>
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
                    <h2>Consolidate Indents</h2>
                    <p>Consolidate approved purchase indents and generate purchase orders.</p>
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
                    <h3 class="search-form-title">Search Purchase Indents</h3>
                </div>
                
                <form name="cbform1" method="post" action="consolidateindents.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="cbcustomername1()">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    $selected = ($locationcode != '' && $locationcode == $res1locationanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1locationanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1location); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" class="form-input" 
                                   value="<?php echo $transactiondatefrom; ?>" readonly="readonly" 
                                   onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" class="form-input" 
                                   value="<?php echo $transactiondateto; ?>" readonly="readonly" 
                                   onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
                        </div>

                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div class="form-actions">
                                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <i class="fas fa-list results-icon"></i>
                    <h3 class="results-title">Consolidate Indents</h3>
                    <div class="results-count">
                        <?php 
                        $query34 = "select * from purchase_indent where approvalstatus='approved' and pogeneration='' and locationcode='".$locationcode."' and date BETWEEN '".$ADate1."' and '".$ADate2."' group by docno";
                        $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $resnw1 = mysqli_num_rows($exec34);
                        ?>
                        <span class="count-badge"><?php echo $resnw1; ?> Records</span>
                    </div>
                </div>

                <?php if ($resnw1 > 0): ?>
                    <form method="post" name="form1" action="consolidateindents.php" onSubmit="return validcheck()" class="consolidate-form">
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Location</th>
                                        <th>Store</th>
                                        <th>Date</th>
                                        <th>From</th>
                                        <th>Doc No</th>
                                        <th>Status</th>
                                        <th>Appr Budget</th>
                                        <th>Select</th>
                                        <th>Re-Approval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $colorloopcount = 0;
                                    $sno = 0;
                                    $sno1 = 0;
                                    $query34 = "select * from purchase_indent where approvalstatus='approved' and pogeneration='' and locationcode='".$locationcode."' and date BETWEEN '".$ADate1."' and '".$ADate2."' group by docno";
                                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

                                    while($res34 = mysqli_fetch_array($exec34)) {
                                        $date = $res34['date'];
                                        $user = $res34['username'];
                                        $docno = $res34['docno'];
                                        $locationname = $res34['locationname'];
                                        $locationcode = $res34['locationcode'];
                                        $storename = $res34['storename'];
                                        $storecode = $res34['storecode'];
                                        $job_title = $res34['job_title'];

                                        $query121 = "select sum(amount) as budgetamount from purchase_indent where docno='$docno' and approvalstatus='approved' and pogeneration!='completed'";
                                        $exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res121 = mysqli_fetch_array($exec121);
                                        $budgetamount = $res121['budgetamount']; 

                                        $query128 = "select purchaseindentdocno from purchaseorder_details where purchaseindentdocno='$docno'";
                                        $exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $numbpo = mysqli_num_rows($exec128);		

                                        if($numbpo == 0) {
                                            $colorloopcount++;
                                            $sno++;
                                            $showcolor = ($colorloopcount & 1); 
                                            $colorcode = ($showcolor == 0) ? 'bgcolor="#CBDBFA"' : 'bgcolor="#ecf0f5"';
                                            ?>
                                            <tr <?php echo $colorcode; ?>>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div class="expand-controls">
                                                        <a id="down<?php echo $sno; ?>" onClick="dropdown(<?php echo $sno; ?>,'down')" href="#" class="expand-btn">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </a>
                                                        <a id="up<?php echo $sno; ?>" onClick="dropdown(<?php echo $sno; ?>,'up')" href="#" class="expand-btn" style="display:none;">
                                                            <i class="fas fa-chevron-up"></i>
                                                        </a>
                                                    </div>
                                                    <div class="row-number"><?php echo $sno; ?></div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div align="center"><?php echo htmlspecialchars($locationname); ?></div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div align="center"><?php echo htmlspecialchars($storename); ?></div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div align="center"><?php echo htmlspecialchars($date); ?></div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div align="center"><?php echo htmlspecialchars($user); ?></div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div align="center"><?php echo htmlspecialchars($docno); ?></div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div class="bodytext31" align="center">
                                                        <span class="status-badge status-approved">Approved</span>
                                                    </div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div class="bodytext31" align="center"><?php echo number_format($budgetamount,2,'.',','); ?></div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div class="bodytext31" align="center">
                                                        <input type="checkbox" name="select[<?php echo $sno;?>]" id="select<?php echo $sno;?>" 
                                                               value="<?php echo htmlspecialchars($docno); ?>" 
                                                               onClick="checkboxselect('<?php echo $docno; ?>',this.id)" class="select">
                                                    </div>
                                                </td>
                                                <td class="bodytext31" valign="center" align="left">
                                                    <div class="bodytext31" align="center">
                                                        <input type="checkbox" name="reapproval[<?php echo $sno;?>]" id="reapproval<?php echo $sno;?>" 
                                                               value="<?php echo htmlspecialchars($docno); ?>" 
                                                               class="reapproval" onClick="recheck(<?php echo $sno; ?>)">
                                                    </div>
                                                </td>

                                                <!-- Hidden fields -->
                                                <input type="hidden" name="jobtitle" value="<?php echo htmlspecialchars($job_title); ?>"> 
                                                <input type="hidden" name="locationname[<?php echo $sno;?>]" value="<?php echo htmlspecialchars($locationname); ?>"> 
                                                <input type="hidden" name="locationcode[<?php echo $sno;?>]" value="<?php echo htmlspecialchars($locationcode); ?>"> 
                                                <input type="hidden" name="storename[<?php echo $sno;?>]" value="<?php echo htmlspecialchars($storename); ?>"> 
                                                <input type="hidden" name="storecode[<?php echo $sno;?>]" value="<?php echo htmlspecialchars($storecode); ?>"> 
                                                <input type="hidden" name="budgetamount[<?php echo $sno;?>]" id="budgetamount<?php echo $sno;?>" value="<?php echo $budgetamount; ?>"> 
                                                <input type="hidden" name="docno[<?php echo $sno;?>]" value="<?php echo htmlspecialchars($docno); ?>"> 
                                            </tr>

                                            <!-- Expandable Details Row -->
                                            <tr id="droupid<?php echo $sno; ?>" style="display:none;">
                                                <td colspan="10">
                                                    <div class="details-container">
                                                        <table class="details-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Medicine Name</th>
                                                                    <th>Supplier Name</th>
                                                                    <th>FX</th>
                                                                    <th>Exc Rate</th>
                                                                    <th>Req Qty</th>
                                                                    <th>Pack Size</th>
                                                                    <th>Pkg Qty</th>
                                                                    <th>Mst/Ind Rate</th>
                                                                    <th>Mst/Ind Amount</th>
                                                                    <th>Original Rate</th>
                                                                    <th>PO Rate</th>
                                                                    <th>PO Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sno2 = 0;
                                                                $totalamount = 0;	
                                                                $budgetamount = 0;		

                                                                $query12 = "select * from purchase_indent where docno='$docno' and approvalstatus='approved' and pogeneration!='completed'";
                                                                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                                $numb12 = mysqli_num_rows($exec12);

                                                                while($res12 = mysqli_fetch_array($exec12)) {
                                                                    $tax_amount = 0;
                                                                    $medicinename = $res12['medicinename'];
                                                                    $itemcode = $res12['medicinecode'];			
                                                                    $reqqty = $res12['quantity'];
                                                                    $purchasetype = $res12['purchasetype'];
                                                                    $suppliername = $res12['suppliername'];
                                                                    $suppliercode = $res12['suppliercode'];
                                                                    $supplieranum = $res12['supplieranum'];
                                                                    $auto_number = $res12['auto_number'];
                                                                    $originalrate = $res12['originalrate'];
                                                                    $currency = $res12['currency'];
                                                                    $fxamount = $res12['fxamount'];
                                                                    $tax_amount = $res12['tax_amount'];

                                                                    if($currency == '') {
                                                                        $currency = 'UGX';
                                                                        $fxamount = '1';
                                                                    }

                                                                    $query2 = "select * from master_medicine where itemcode = '$itemcode'";
                                                                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                                    $res2 = mysqli_fetch_array($exec2);
                                                                    $package = $res2['packagename'];

                                                                    $packagequantity = $res12['packagequantity'];
                                                                    $rate = $res12['rate'];
                                                                    $amount = $res12['amount']; 
                                                                    $fxpkrate = $res12['rate']*$fxamount;
                                                                    $fxtotamount = $fxpkrate*$reqqty; 

                                                                    if($fxpkrate == '0') {
                                                                        $fxpkrate = $rate;
                                                                        $fxtotamount = $rate*$packagequantity;
                                                                    }

                                                                    $fxtotamount = $fxtotamount + $tax_amount;
                                                                    $totalamount = $totalamount + $amount;
                                                                    $sno1 = $sno1 + 1;
                                                                    $sno2 = $sno2 + 1;
                                                                    $budgetamount = $budgetamount + (number_format($fxtotamount/$fxamount,2,'.',''));		

                                                                    // Get supplier if empty
                                                                    if($purchasetype != 'Expenses' && $purchasetype != 'Others') {
                                                                        if($suppliername == '') {
                                                                            $query3 = "select suppliername,suppliercode,supplieranum from master_itemtosupplier where locationcode = '$locationcode' and itemcode = '$itemcode' and recordstatus <> 'deleted' ORDER BY auto_number desc";
                                                                            $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                                            $res3 = mysqli_fetch_array($exec3);
                                                                            $suppliername = $res3['suppliername'];
                                                                            $suppliercode = $res3['suppliercode'];
                                                                            $supplieranum = $res3['supplieranum'];
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center"><?php echo htmlspecialchars($medicinename);?>
                                                                                <input type="hidden" id="itemcode<?php echo $sno1;?>" name="itemcode<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo htmlspecialchars($itemcode);?>">
                                                                                <input type="hidden" id="purchasetype<?php echo $sno1;?>" name="purchasetype<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo htmlspecialchars($purchasetype);?>">
                                                                                <input type="hidden" id="auto_number<?php echo $sno1;?>" name="auto_number<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo htmlspecialchars($auto_number);?>">
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center"> 
                                                                                <input type="text" id="suppliername<?php echo $sno1;?>" name="suppliername<?php echo $sno;?>[<?php echo $sno2; ?>]" class="suppliername <?php echo $docno; ?>" value="<?php echo htmlspecialchars(trim($suppliername));?>"/>
                                                                                <input type="hidden" id="suppliercode<?php echo $sno1;?>" name="suppliercode<?php echo $sno;?>[<?php echo $sno2; ?>]" class="suppliercode" value="<?php echo htmlspecialchars(trim($suppliercode));?>"/>
                                                                                <input type="hidden" id="supplieranum<?php echo $sno1;?>" name="supplieranum<?php echo $sno;?>[<?php echo $sno2; ?>]" class="supplieranum" value="<?php echo htmlspecialchars(trim($supplieranum));?>"/>
                                                                                <?php
                                                                                if($suppliername == '') {
                                                                                    echo "<script>document.getElementById('select".$sno."').checked=false;document.getElementById('select".$sno."').disabled=true;</script>";
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="2" id="fx<?php echo $sno1;?>" name="fx<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo htmlspecialchars($currency);?>" readonly>
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="2" id="fxrate<?php echo $sno1;?>" name="fxrate<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo htmlspecialchars($fxamount);?>" onKeyUp="totalamount('<?php echo $sno1;?>','<?php echo $sno;?>');">
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="2" id="reqqty<?php echo $sno1;?>" name="reqqty<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo number_format($reqqty);?>" readonly>
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="2" id="package<?php echo $sno1;?>" name="package<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo htmlspecialchars($package);?>" readonly>
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="1" name="packagequantity<?php echo $sno;?>[<?php echo $sno2; ?>]" id="packagequantity<?php echo $sno1;?>" value="<?php echo htmlspecialchars($packagequantity);?>" readonly>
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="5" name="fxpkrate<?php echo $sno;?>[<?php echo $sno2; ?>]" id="fxpkrate<?php echo $sno1;?>" value="<?php echo number_format($fxpkrate,'2','.',',');?>" onKeyUp="totalamount('<?php echo $sno1;?>','<?php echo $sno;?>');">
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="5" name="fxamount<?php echo $sno;?>[<?php echo $sno2; ?>]" id="fxamount<?php echo $sno1;?>" value="<?php echo number_format($fxtotamount,'2','.',',');?>" readonly>
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="5" name="orate<?php echo $sno;?>[<?php echo $sno2; ?>]" id="orate<?php echo $sno1;?>" value="<?php echo number_format($originalrate,'2','.',',');?>" readonly>
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="5" name="rate<?php echo $sno;?>[<?php echo $sno2; ?>]" id="rate<?php echo $sno1;?>" value="<?php echo number_format($fxpkrate/$fxamount,2,'.',',');?>" readonly>
                                                                            </div>
                                                                        </td>
                                                                        <td class="bodytext31" valign="center" align="left">
                                                                            <div align="center">
                                                                                <input type="text" size="5" name="amount<?php echo $sno;?>[<?php echo $sno2; ?>]" class="amount<?php echo $sno;?>" id="amount<?php echo $sno1;?>" value="<?php echo number_format($fxtotamount/$fxamount,2,'.',',');?>" readonly>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php 
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td colspan="11" class="bodytext31" valign="center" align="left">
                                                                        <div align="center">
                                                                            <input type="text" size="5" name="totalamount<?php echo $sno;?>" id="totalamount<?php echo $sno;?>" value="<?php echo number_format($budgetamount,2,'.',',');?>" readonly>
                                                                            <input type="hidden" size="5" name="numb12<?php echo $sno;?>" id="numb12<?php echo $sno;?>" value="<?php echo $numb12;?>" readonly>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-actions">
                            <input type="hidden" name="frm1submit1" value="frm1submit1" />
                            <input type="hidden" name="reapprove" value="0" />
                            <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
                            <button type="submit" name="submit" id="savepo" class="btn btn-primary">
                                <i class="fas fa-file-invoice"></i> Generate PO / Re-Approval
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No Approved Indents</h3>
                        <p>There are no approved purchase indents available for consolidation.</p>
                        <a href="purchase_indent.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Indent
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/consolidateindents-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
