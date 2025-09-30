<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$titlestr = 'RFQ GOODS RECEIVED NOTE';

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

// Process form submission
if ($frmflag2 == 'frmflag2') {
    $billnumber = $_REQUEST['billnum'];
    $store = $_REQUEST['store1'];
    $billdate = $_REQUEST['billdate'];
    $suppliername = $_REQUEST['suppliername'];
    $suppliercode = $_REQUEST['suppliercode'];
    $ponumber = $_REQUEST['pono'];
    $accountssubid = $_REQUEST['accountssubid'];
    $supplierbillno = $_REQUEST['supplierbillno1'];
    $amount = $_REQUEST['totalpurchaseamount1'];
    
    $query23 = "select * from master_employee where username='$username'";
    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res23 = mysqli_fetch_array($exec23);
    $res7locationanum = $res23['location'];
    
    $query55 = "select * from master_location where auto_number='$res7locationanum'";
    $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res55 = mysqli_fetch_array($exec55);
    $location = $res55['locationname'];
    
    $query751 = "select * from master_financialintegration where field='grn'";
    $exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res751 = mysqli_fetch_array($exec751);
    $coa = $res751['code'];
    
    // Process each item
    foreach($_POST['itemname'] as $key => $value) {
        $itemname = $_POST['itemname'][$key];
        $itemcode = $_POST['itemcode'][$key];
        
        $query5 = "select * from master_itempharmacy where itemcode = '$itemcode'";
        $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res5 = mysqli_fetch_array($exec5);
        $itemanum = $res5['auto_number'];
        
        $rate = $_POST['rate'][$key];
        $quantity = $_POST['receivedquantity'][$key];
        $allpackagetotalquantity = $_POST['totalquantity'][$key];
        $orderedquantity = $_POST['orderedquantity'][$key];
        $free = $_POST['free'][$key];
        $itemdiscountpercent = $_POST['discount'][$key];
        $totalamount = $_POST['totalamount1'][$key];
        $itemtaxpercent = $_POST['tax'][$key];
        $batchnumber = $_POST['batch'][$key];
        $salesprice = $_POST['saleprice1'][$key];
        $costprice = $_POST['costprice'][$key];
        $expirydate = $_POST['expirydate'][$key];
        
        $expirymonth = substr($expirydate, 0, 2);
        $expiryyear = substr($expirydate, 3, 2);
        $expiryday = '01';
        $expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
        
        $packagename = $_POST['packsize'][$key];
        $balqty = $_POST['balqty'][$key];
        
        if(intval($orderedquantity) == intval($quantity)) {
            $itemstatus = 'received';
        } else {
            $itemstatus = '';
        }
        
        $query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
        $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res31 = mysqli_fetch_array($exec31);
        $itemunitabb = $res31['unitname_abbreviation'];
        $res31packageanum = $res31['packageanum'];
        $categoryname = $res31['categoryname'];
        
        $query32 = "select * from master_packagepharmacy where auto_number = '$res31packageanum'";
        $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res32 = mysqli_fetch_array($exec32);
        $packageanum = $res32['auto_number'];
        $quantityperpackage = $res32['quantityperpackage'];
        
        $query33 = "select * from materialreceiptnote_details where billnumber='$ponumber' and itemcode='$itemcode'";
        $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $res33 = mysqli_fetch_array($exec33);
        $purchaseordernumber = $res33['ponumber'];
        
        $query4 = "insert into purchase_details (bill_autonumber, companyanum, billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, packageanum, packagename, quantityperpackage, allpackagetotalquantity, manufactureranum, manufacturername,typeofpurchase,suppliername,suppliercode,ponumber,supplierbillnumber,costprice,location,store,coa,categoryname) values ('$billautonumber', '$companyanum', '$billnumber', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', '$totalamount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$openingstock', '$closingstock', '$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', '$itemtaxpercent', '$itemtaxamount', '$itemunitabb', '$batchnumber', '$salesprice', '$expirydate', '$free', '$quantity', '$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', '$manufactureranum', '$manufacturername','Process','$suppliername','$suppliercode','$ponumber','$supplierbillno','$costprice','$location','$store','$coa','$categoryname')";
        $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $query56 = "update materialreceiptnote_details set itemstatus='$itemstatus' where billnumber='$ponumber' and itemcode='$itemcode'";
        $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $query561 = "update master_itempharmacy set rateperunit='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";
        $exec561 = mysqli_query($GLOBALS["___mysqli_ston"], $query561) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $query562 = "update master_medicine set rateperunit='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";
        $exec562 = mysqli_query($GLOBALS["___mysqli_ston"], $query562) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $query56 = "update master_rfq set goodsstatus='$itemstatus' where billnumber='$purchaseordernumber' and itemcode='$itemcode'";
        $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    
    $transactiontype = 'PAYMENT';
    $transactionmode = 'CREDIT';
    $particulars = 'BY CREDIT (Inv NO:'.$billnumber.$supplierbillno.')';
    
    $query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, transactionmode, transactiontype, transactionamount, creditamount,balanceamount, billnumber, billanum, ipaddress, updatedate, companyanum, companyname, transactionmodule,suppliercode) values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', '$transactionmode', '$transactiontype', '$amount', '$amount', '$amount', '$billnumber', '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode')";
    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $transactiontype = 'PURCHASE';
    $transactionmode = 'BILL';
    $particulars = 'BY PURCHASE (Inv NO:'.$billnumber.$supplierbillno.')';
    
    $query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, transactionmode, transactiontype, transactionamount, billnumber, billanum, ipaddress, updatedate, companyanum, companyname, transactionmodule,suppliercode) values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', '$transactionmode', '$transactiontype', '$amount', '$billnumber', '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode')";
    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber)values('$companyanum','$billnumber','$updatedatetime','$suppliercode', '$suppliername','$amount','$quantity','$ipaddress','$supplierbillno')";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    
    header("location:menupage1.php?mainmenuid=MM029");
}

// Handle MRN search
if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $searchpo = $_POST['po'];
    $searchpo = trim($searchpo);
    $len1 = strlen($searchpo);
    $str1 = preg_replace('/[^\\/\-a-z\s]/i', '', $searchpo);
    
    if($str1 == 'MRN-') {
        $query5 = "select * from materialreceiptnote_details where billnumber = '$searchpo' and itemstatus='' order by billnumber";
    } else {
        $query5 = "select * from materialreceiptnote_details where billnumber = '$searchpo' and itemstatus='' order by billnumber";
    }
    
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res5 = mysqli_fetch_array($exec5)) {
        $billnum = $res5["billnumber"];
        $suppliername = $res5['suppliername'];
        $suppliercode = $res5['suppliercode'];
        $suppliername = strtoupper($suppliername);
        $billdate = $res5['entrydate'];
        $supplierbillnumber = $res5['supplierbillnumber'];
        
        $query1 = "select * from master_accountname where id='$suppliercode'";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_num_rows());
        $res1 = mysqli_fetch_array($exec1);
        $accountssubanum = $res1['accountssub'];
        
        $query11 = "select * from master_accountssub where auto_number='$accountssubanum'";
        $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $res11 = mysqli_fetch_array($exec11);
        $accountssubid = $res11['id'];
        
        $query66 = "select * from master_supplier where suppliercode='$suppliercode'";
        $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $res66 = mysqli_fetch_array($exec66);
        $addressname = $res66['address1'];
        $address = $addressname;
        $addressname1 = $res66['address2'];
        if($addressname1 != '') {
            $address = $address.','.$addressname1;
        }
        $area = $res66['area'];
        if($area != '') {
            $address = $address.','.$area;
        }
        $city = $res66['city'];
        if($city !='') {
            $address = $address.','.$city;
        }
        $state = $res66['state'];
        if($state !='') {
            $address = $address.','.$state;
        }
        $country = $res66['country'];
        if($country !='') {
            $address = $address.','.$country;
        }
        $telephone2 = $res66['mobilenumber'];
        $tele = $telephone2;
        $telephone = $res66['phonenumber1'];
        if($telephone != '') {
            $tele = $tele.','.$telephone;
        }
        $telephone1 = $res66['phonenumber2'];
        if($telephone1 != '') {
            $tele = $tele.','.$telephone1;
        }
    }
}

// Get bill number
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'GRN-';
$paynowbillprefix1 = strlen($paynowbillprefix);

$query2 = "select * from purchase_details where typeofpurchase='Process' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit = strlen($billnumber);

if ($billnumber == '') {
    $billnumbercode = 'GRN-1';
    $openingbalance = '0.00';
} else {
    $billnumber = $res2["billnumber"];
    $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
    $billnumbercode = intval($billnumbercode);
    $billnumbercode = $billnumbercode + 1;
    $maxanum = $billnumbercode;
    $billnumbercode = 'GRN-' .$maxanum;
    $openingbalance = '0.00';
}

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];

// Status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if (isset($_REQUEST["banum"])) { 
    $banum = $_REQUEST["banum"]; 
} else { 
    $banum = ""; 
}

if ($st == '1') {
    $errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
    $bgcolorcode = 'success';
}

if ($st == '2') {
    $errmsg = "Failed. New Bill Cannot Be Completed.";
    $bgcolorcode = 'failed';
}

if ($st == '1' && $banum != '') {
    $loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

include("autocompletebuild_materialreceiptnote.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFQ Goods Received Note - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/rfqgoodsreceivednote-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
    
    <!-- JavaScript files -->
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/autocomplete_mrn.js"></script>
    <script type="text/javascript" src="js/autosuggestmrn.js"></script>
    
    <?php include ("js/dropdownlist1scriptingmrn.php"); ?>
</head>
<body onLoad="return funcOnLoadBodyFunctionCall();">
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
        <span>RFQ Goods Received Note</span>
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
                        <a href="rfqgoodsreceivednote.php" class="nav-link">
                            <i class="fas fa-clipboard-check"></i>
                            <span>RFQ Goods Received</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="materialreceivednote.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Material Received</span>
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
                    <h2>RFQ Goods Received Note</h2>
                    <p>Process goods received against RFQ purchase orders and update inventory.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="materialreceivednote.php" class="btn btn-outline">
                        <i class="fas fa-clipboard-list"></i> Material Received
                    </a>
                </div>
            </div>

            <!-- MRN Search Form -->
            <div class="mrn-search-section">
                <div class="mrn-search-header">
                    <i class="fas fa-search mrn-search-icon"></i>
                    <h3 class="mrn-search-title">Search MRN for RFQ Goods Receipt</h3>
                </div>
                
                <form name="cbform1" method="post" action="rfqgoodsreceivednote.php" class="mrn-search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="po" class="form-label">MRN Number</label>
                            <input type="text" name="po" id="po" class="form-input" 
                                   value="<?php echo htmlspecialchars($billnum); ?>" 
                                   placeholder="Search MRN number..." autocomplete="off" />
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search MRN
                        </button>
                    </div>
                </form>
            </div>

            <!-- RFQ Goods Received Form -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="rfq-goods-received-section">
                <div class="rfq-goods-received-header">
                    <i class="fas fa-clipboard-check rfq-goods-received-icon"></i>
                    <h3 class="rfq-goods-received-title">RFQ Goods Received Details</h3>
                </div>
                
                <!-- Document Information -->
                <div class="document-info-section">
                    <div class="document-info-grid">
                        <div class="info-item">
                            <label class="info-label">Document No</label>
                            <span class="info-value"><?php echo htmlspecialchars($billnumbercode); ?></span>
                            <input name="docno" id="docno" value="<?php echo htmlspecialchars($billnumbercode); ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">MRN Number</label>
                            <span class="info-value"><?php echo htmlspecialchars($billnum); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Supplier</label>
                            <span class="info-value"><?php echo htmlspecialchars($suppliername); ?> & <?php echo htmlspecialchars($suppliercode); ?></span>
                            <input name="supplier" id="supplier" value="<?php echo htmlspecialchars($suppliername); ?>" type="hidden"/>
                            <input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo htmlspecialchars($suppliercode); ?>">
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Invoice No</label>
                            <span class="info-value"><?php echo htmlspecialchars($supplierbillnumber); ?></span>
                            <input name="supplierbillno" id="supplierbillno" value="<?php echo htmlspecialchars($supplierbillnumber); ?>" 
                                   class="form-input" onKeyUp="return billnotransfer()" />
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">MRN Date</label>
                            <span class="info-value"><?php echo htmlspecialchars($billdate); ?></span>
                            <input name="lpodate" id="lpodate" value="<?php echo htmlspecialchars($billdate); ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">GRN Date</label>
                            <span class="info-value"><?php echo $dateonly; ?></span>
                            <input name="grndate" id="grndate" value="<?php echo $dateonly; ?>" type="hidden"/>
                        </div>
                    </div>
                </div>

                <!-- Supplier Information -->
                <div class="supplier-info-section">
                    <div class="supplier-info-grid">
                        <div class="info-item">
                            <label class="info-label">Address</label>
                            <span class="info-value"><?php echo htmlspecialchars($address); ?></span>
                            <input name="address" id="address" value="<?php echo htmlspecialchars($address); ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Telephone</label>
                            <span class="info-value"><?php echo htmlspecialchars($tele); ?></span>
                            <input name="telephone" id="telephone" value="<?php echo htmlspecialchars($tele); ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Location</label>
                            <span class="info-value"><?php echo htmlspecialchars($location); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Store</label>
                            <select name="store" id="store" onChange="return storeassign()" class="form-select">
                                <option value="">Select Store</option>
                                <?php
                                $query5 = "select * from master_store where location = '$res7locationanum' and recordstatus = ''";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res5 = mysqli_fetch_array($exec5)) {
                                    $store = $res5["store"];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($store); ?>"><?php echo htmlspecialchars($store); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Time</label>
                            <span class="info-value"><?php echo $timeonly; ?></span>
                            <input name="time" id="time" value="<?php echo $timeonly; ?>" type="hidden"/>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="items-table-section">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Item</th>
                                    <th>Ord.Qty</th>
                                    <th>Recd.Qty</th>
                                    <th>Bal.Qty</th>
                                    <th>Batch</th>
                                    <th>Exp.Dt</th>
                                    <th>Pkg.Size</th>
                                    <th>Free</th>
                                    <th>Tot.Qty</th>
                                    <th>QP/PK</th>
                                    <th>Price/Pk</th>
                                    <th>Disc %</th>
                                    <th>Tax</th>
                                    <th>Total Value</th>
                                    <th>Cost Price</th>
                                    <th>Sale Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $colorloopcount = '';
                                $sno = 0;
                                $totalamount = 0;
                                $grandtotalamount = 0;
                                $len = strlen($billnum);
                                $str = preg_replace('/[^\\/\-a-z\s]/i', '', $billnum);
                                
                                if($str == 'MRN-') {
                                    $query76 = "select * from materialreceiptnote_details where billnumber='$billnum' and itemstatus=''";
                                } else {
                                    $query76 = "select * from materialreceiptnote_details where billnumber='$billnum' and itemstatus=''";
                                }
                                
                                $exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $number = mysqli_num_rows($exec76);
                                
                                while($res76 = mysqli_fetch_array($exec76)) {
                                    $totalreceivedqty = 0;
                                    $itemname = $res76['itemname'];
                                    $itemcode = $res76['itemcode'];
                                    $rate = $res76['priceperpack'];
                                    $quantity = $res76['quantity'];
                                    $amount = $res76['totalamount'];
                                    $suppliercode = $res76['suppliercode'];
                                    $batchnumber = $res76['batchnumber'];
                                    $expirydate = $res76['expirydate'];
                                    $free = $res76['itemfreequantity'];
                                    $priceperpack = $res76['priceperpack'];
                                    $totalqty = $res76['allpackagetotalquantity'];
                                    $discountpercent = $res76['discountpercentage'];
                                    $itemtaxpercentage = $res76['itemtaxpercentage'];
                                    $itemtotalamount = $rate * $quantity;
                                    $grandtotalamount = $grandtotalamount + $itemtotalamount;
                                    $packsize = $res76['unit_abbreviation'];
                                    $packsizelen = strlen($packsize);
                                    $unitquantity = substr($packsize,0,$packsizelen-1);
                                    $costprice = $itemtotalamount/($unitquantity * $quantity);
                                    
                                    $query761 = "select * from master_rfq where suppliercode='$suppliercode' and medicinecode='$itemcode' and status = 'generated' order by auto_number desc";
                                    $exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res761 = mysqli_fetch_array($exec761);
                                    $orderedquantity = $res761['packagequantity'];
                                    $amount3 = $res761['amount'];
                                    $quotedprice = $res761['rate'];
                                    
                                    if($rate > $quotedprice) {
                                        $error_css = 'background-color:red';
                                    } else if($rate < $quotedprice) {
                                        $error_css = 'background-color:yellow';
                                    } else {
                                        $error_css = '';
                                    }
                                    
                                    $balanceqty = $orderedquantity - $quantity;
                                    
                                    $expirydate = explode("-",$expirydate);
                                    $year = $expirydate[0];
                                    $year = substr($year,2,4);
                                    $month = $expirydate[1];
                                    $newexpirydate = $expirydate[1].'/'.$year;
                                    
                                    $query77 = "select * from master_medicine where itemcode='$itemcode'";
                                    $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res77 = mysqli_fetch_array($exec77);
                                    $packagesize = $res77['packagename'];
                                    $spmarkup = $res77['spmarkup'];
                                    $saleprice = $spmarkup * $costprice;
                                    
                                    $sno = $sno + 1; ?>
                                    <tr class="item-row">
                                        <td class="sno-cell"><?php echo $sno; ?></td>
                                        <td class="item-cell"><?php echo htmlspecialchars($itemname); ?></td>
                                        
                                        <input type="hidden" name="itemname[]" value="<?php echo htmlspecialchars($itemname); ?>">
                                        <input type="hidden" name="itemcode[]" value="<?php echo htmlspecialchars($itemcode); ?>">
                                        <input type="hidden" name="rate[]" value="<?php echo $rate; ?>">
                                        <input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">
                                        <input type="hidden" name="totalamount[]" value="<?php echo $amount; ?>">
                                        
                                        <td class="qty-cell"><?php echo intval($orderedquantity); ?></td>
                                        <input type="hidden" name="orderedquantity[]" id="orderedquantity<?php echo $sno; ?>" value="<?php echo intval($orderedquantity); ?>">
                                        
                                        <td class="input-cell">
                                            <input type="text" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" 
                                                   class="form-input-small" onKeyUp="return totalcalc('<?php echo $sno; ?>');" 
                                                   autocomplete="off" value="<?php echo intval($quantity); ?>" readonly>
                                        </td>
                                        
                                        <td class="qty-cell">
                                            <?php echo $balanceqty; ?>
                                            <input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>">
                                        </td>
                                        
                                        <td class="input-cell">
                                            <input type="text" name="batch[]" id="batch<?php echo $sno; ?>" 
                                                   class="form-input-small" autocomplete="off" 
                                                   value="<?php echo htmlspecialchars($batchnumber); ?>" readonly>
                                        </td>
                                        
                                        <td class="input-cell">
                                            <input type="text" name="expirydate[]" id="expirydate<?php echo $sno; ?>" 
                                                   class="form-input-small" autocomplete="off" 
                                                   value="<?php echo htmlspecialchars($newexpirydate); ?>" readonly>
                                        </td>
                                        
                                        <td class="qty-cell">
                                            <?php echo htmlspecialchars($packagesize); ?>
                                            <input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo htmlspecialchars($packagesize); ?>">
                                        </td>
                                        
                                        <td class="input-cell">
                                            <input type="text" name="free[]" id="free<?php echo $sno; ?>" 
                                                   class="form-input-small" onKeyUp="return totalcalc1('<?php echo $sno; ?>');" 
                                                   autocomplete="off" value="<?php echo intval($free); ?>" readonly>
                                        </td>
                                        
                                        <td class="input-cell">
                                            <input type="text" name="totalquantity[]" id="totalquantity<?php echo $sno; ?>" 
                                                   class="form-input-small" readonly value="<?php echo intval($totalqty); ?>">
                                        </td>
                                        
                                        <td class="qty-cell"><?php echo number_format($quotedprice,2,'.',','); ?></td>
                                        
                                        <td class="input-cell">
                                            <input type="text" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" 
                                                   class="form-input-small" onKeyUp="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');" 
                                                   autocomplete="off" value="<?php echo $rate; ?>" readonly 
                                                   style="<?php echo $error_css; ?>">
                                        </td>
                                        
                                        <td class="input-cell">
                                            <input type="text" name="discount[]" id="discount<?php echo $sno; ?>" 
                                                   class="form-input-small" onKeyUp="return totalamount5('<?php echo $sno; ?>','<?php echo $number; ?>');" 
                                                   autocomplete="off" value="<?php echo $discountpercent; ?>" readonly>
                                        </td>
                                        
                                        <td class="input-cell">
                                            <input type="text" name="tax[]" id="tax<?php echo $sno; ?>" 
                                                   class="form-input-small" onKeyUp="return totalamount20('<?php echo $sno; ?>','<?php echo $number; ?>');" 
                                                   autocomplete="off" value="<?php echo $itemtaxpercentage; ?>" readonly>
                                        </td>
                                        
                                        <td class="input-cell">
                                            <input type="text" name="totalamount[]" id="totalamount<?php echo $sno; ?>" 
                                                   class="form-input-small" readonly value="<?php echo number_format($itemtotalamount,2,'.',','); ?>">
                                        </td>
                                        
                                        <input type="hidden" name="totalamount1[]" id="totalamount<?php echo $sno; ?>" value="<?php echo $itemtotalamount; ?>">
                                        
                                        <td class="input-cell">
                                            <input type="text" name="costprice[]" id="costprice<?php echo $sno; ?>" 
                                                   class="form-input-small" readonly value="<?php echo number_format($costprice,2,'.',','); ?>">
                                        </td>
                                        
                                        <td class="input-cell">
                                            <input type="hidden" name="saleprice1[]" id="saleprice1<?php echo $sno; ?>" value="<?php echo $saleprice; ?>">
                                            <input type="hidden" name="spmarkup" id="spmarkup<?php echo $sno; ?>" value="<?php echo $spmarkup; ?>">
                                            <input type="text" name="saleprice[]" id="saleprice<?php echo $sno; ?>" 
                                                   class="form-input-small" readonly value="<?php echo number_format($saleprice,2,'.',','); ?>">
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Totals Section -->
                <div class="totals-section">
                    <div class="totals-grid">
                        <div class="total-item">
                            <label class="total-label">Total Purchase Cost</label>
                            <input type="text" name="totalpurchaseamount" id="totalpurchaseamount" 
                                   class="total-input" readonly value="<?php echo number_format($grandtotalamount,2,'.',','); ?>">
                            <input type="hidden" name="totalpurchaseamount1" id="totalpurchaseamount" value="<?php echo $grandtotalamount; ?>">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <input type="hidden" name="billnum" value="<?php echo htmlspecialchars($billnumbercode); ?>">
                    <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">
                    <input type="hidden" name="suppliername" value="<?php echo htmlspecialchars($suppliername); ?>">
                    <input type="hidden" name="pono" value="<?php echo htmlspecialchars($billnum); ?>">
                    <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">
                    <input type="hidden" name="store1" id="store1">
                    <input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo htmlspecialchars($suppliercode); ?>">
                    <input type="hidden" name="accountssubid" value="<?php echo $accountssubid; ?>">
                    <input type="hidden" name="supplierbillno1" id="supplierbillno1" value="<?php echo htmlspecialchars($supplierbillnumber); ?>">
                    <input type="hidden" name="frmflag2" value="frmflag2">
                    
                    <button type="submit" class="btn btn-primary btn-large" onClick="return funcsave('<?php echo $number; ?>')">
                        <i class="fas fa-save"></i> Save RFQ Goods Received
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/rfqgoodsreceivednote-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
