<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
include ("includes/loginverify.php");
include ("includes/check_user_access.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$balanceamount = 0;
$cashamount21 = '';
$cardamount21 = '';
$onlineamount21 = '';
$chequeamount21 = '';
$tdsamount21 = '';
$writeoffamount21 = '';
$taxamount21 = '';
$titlestr = 'GOODS RETURNS';

$docno = $_SESSION["docno"];

$query01 = "select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01 = mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];

$query018 = "select auto_number from master_location where locationcode='$main_locationcode'";
$exc018 = mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018 = mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

if (isset($_REQUEST["frmflag2"])) { 
    $frmflag2 = $_REQUEST["frmflag2"]; 
} else { 
    $frmflag2 = ""; 
}

// Process form submission
if ($frmflag2 == 'frmflag2') {
    $billnumber = $_REQUEST['billnum'];
    $billdate = $_REQUEST['billdate'];
    $suppliername = $_REQUEST['suppliername'];
    
    $query101 = "select * from master_accountname where accountname = '$suppliername'";
    $exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die ("Error in Query101".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res101 = mysqli_fetch_array($exec101);
    $suppliercode = $res101['id'];
    
    $query1 = "select * from master_accountname where id='$suppliercode'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_num_rows());
    $res1 = mysqli_fetch_array($exec1);
    $accountssubanum = $res1['accountssub'];
    
    $query11 = "select * from master_accountssub where auto_number='$accountssubanum'";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res11 = mysqli_fetch_array($exec11);
    $accountssubid = $res11['id'];
    
    $grnnumber = $_REQUEST['grnno'];
    
    $query231 = "select * from master_employee where username='$username'";
    $exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res231 = mysqli_fetch_array($exec231);
    $res7locationanum1 = $res231['location'];
    
    $query551 = "select * from master_location where auto_number='$res7locationanum1'";
    $exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res551 = mysqli_fetch_array($exec551);
    $location1 = $res551['locationname'];
    
    $res7storeanum1 = $res231['store'];
    
    $query751 = "select * from master_store where auto_number='$res7storeanum1'";
    $exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res751 = mysqli_fetch_array($exec751);
    $store1 = $res751['store'];
    
    $locationcode = $_REQUEST['locationcode'];
    $locationname = $_REQUEST['locationname'];
    $storeanum = $_REQUEST['store'];
    
    $query751 = "select * from master_financialintegration where field='grt'";
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
        
        foreach($_POST['returncheckbox'] as $check) {
            $acknow = $check;
            if($acknow == $itemcode) {
                $rate = $_POST['costprice'][$key];
                $quantity = $_POST['returnqty'][$key];
                $amount = $_POST['totalamount'][$key];
                $itemdiscountpercent = $_POST['discount'][$key];
                $balqty = $_POST['balqty'][$key];
                $fifo_code = $_POST['fifo_code'][$key];
                
                if($balqty == $quantity) {
                    $itemstatus = 'received';
                } else {
                    $itemstatus = '';
                }
                
                $batchnumber = $_POST['batch'][$key];
                $salesprice = $_POST['saleprice'][$key];
                $expirydate = $_POST['expirydate'][$key];
                $packagename = $_POST['packsize'][$key];
                $ledgeranum = $_POST['ledgeranum'][$key];
                $ledgercode = $_POST['ledgercode'][$key];
                $ledgername = $_POST['ledgername'][$key];
                $incomeledger = $_POST['incomeledger'][$key];
                $incomeledgercode = $_POST['incomeledgercode'][$key];
                
                $query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
                $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res31 = mysqli_fetch_array($exec31);
                $itemunitabb = $res31['unitname_abbreviation'];
                $res31packageanum = $res31['auto_number'];
                $categoryname = $res31['categoryname'];
                
                $query32 = "select * from master_packagepharmacy where auto_number = '$res31packageanum'";
                $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res32 = mysqli_fetch_array($exec32);
                $packageanum = $res32['auto_number'];
                $quantityperpackage = $res32['quantityperpackage'];
                
                $returnqty = $quantity; 
                $itemsubtotal = $quantity * $rate;
                
                if(($returnqty != '') && ($returnqty != 0)) {
                    $querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode'";
                    $execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $rescumstock2 = mysqli_fetch_array($execcumstock2);
                    $cum_quantity = $rescumstock2["cum_quantity"];
                    $cum_quantity = $cum_quantity - $returnqty;
                    
                    if($cum_quantity == '0') { 
                        $cum_stockstatus = '0'; 
                    } else { 
                        $cum_stockstatus = '1'; 
                    }
                    
                    if($cum_quantity >= '0') {
                        $querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and fifo_code='$fifo_code' and storecode='$storeanum'";
                        $execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $resbatstock2 = mysqli_fetch_array($execbatstock2);
                        $bat_quantity = $resbatstock2["batch_quantity"];
                        $bat_quantity = $bat_quantity - $returnqty;
                        
                        if($bat_quantity == '0') { 
                            $batch_stockstatus = '0'; 
                        } else { 
                            $batch_stockstatus = '1'; 
                        }
                        
                        if($bat_quantity >= '0') {
                            $queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode' and fifo_code='$fifo_code' and storecode='$storeanum'";
                            $execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            $queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode'";
                            $execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            $stockquery2 = "insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description, batchnumber, batch_quantity, transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode) values ('$fifo_code','purchasereturn_details','$itemcode', '$itemname', '$dateonly','0', 'Purchase Return', '$batchnumber', '$bat_quantity', '$returnqty', '$cum_quantity', '$billnumber', '','$cum_stockstatus','$batch_stockstatus', '$locationcode','','$storeanum', '', '$username', '$ipaddress','$dateonly','$timeonly','$updatedatetime','$rate','$itemsubtotal','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
                            $stockexecquery2 = mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            $query4 = "insert into purchasereturn_details (bill_autonumber, companyanum, billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, batchnumber, expirydate,typeofreturn,suppliername,suppliercode,packagequantity,location,store,grnbillnumber,accountssubcode,grtcoa,categoryname,locationcode,locationname,fifo_code,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode) values ('$billautonumber', '$companyanum', '$billnumber', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', '$itemsubtotal', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$openingstock', '$closingstock', '$itemsubtotal', '$discountamount', '$username', '$ipaddress', '$billdate', '$itemtaxpercent', '$itemtaxamount', '$itemunitabb', '$batchnumber', '$expirydate','Process','$suppliername','$suppliercode','$returnqty','$locationname','$storeanum','$grnnumber','$accountssubid','$coa','$categoryname','$locationcode','$locationname','$fifo_code','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
                            $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            $test = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
                            $query56 = "update purchase_details set itemstatus='$itemstatus' where billnumber='$grnnumber' and itemcode='$itemcode'";
                            $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            header("location:mainmenu1.php");
                        }
                    }
                }
            }
        }
    }
    
    if($test != '') {
        echo '<script type="text/javascript">funcPrintReceipt1();window.location = "mainmenu1.php";</script>';
        exit;
    }
    header("location:mainmenu1.php");
}

// Handle GRN search
if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $searchgrn = $_POST['grn'];
    $searchgrn = trim($searchgrn);
    
    $query5 = "select * from materialreceiptnote_details where billnumber = '$searchgrn' order by billnumber";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while ($res5 = mysqli_fetch_array($exec5)) {
        $billnum = $res5["billnumber"];
        $suppliername = $res5['suppliername'];
        $suppliercode = $res5['suppliercode'];
        $suppliername = strtoupper($suppliername);
        $billdate = $res5['entrydate'];
        $locationcode = $res5['locationcode'];
        $storecode1 = $res5['store']; 
        
        $query6 = "select * from master_location where locationcode = '$locationcode'";
        $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res6 = mysqli_fetch_array($exec6);
        $locationname = $res6['locationname'];
        
        $query61 = "select * from master_store where storecode = '$storecode1'";
        $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res61 = mysqli_fetch_array($exec61);
        $store = $res61['store'];
        $storecode = $res61['storecode'];
        
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
    
    $query2b = "select * from master_purchase where mrnno = '$searchgrn'";
    $exec2b = mysqli_query($GLOBALS["___mysqli_ston"], $query2b) or die ("Error in Query2b".mysqli_error($GLOBALS["___mysqli_ston"]));
    $rowcount2b = mysqli_num_rows($exec2b);
    $number = mysqli_num_rows($exec2b);
    $res2b = mysqli_fetch_array($exec2b);
    $suppliername = $res2b['suppliername'];
    $suppliercode = $res2b['suppliercode'];
    $anum = $res2b['auto_number'];
    $billnumber1 = $res2b['billnumber'];
    $supplierbillnumber = $res2b['supplierbillnumber'];
    $billnumberprefix = $res2b['billnumberprefix'];
    $billnumberpostfix = $res2b['billnumberpostfix'];
    $billdate = $res2b['billdate'];
    $billtotalamount = $res2b['totalamount'];
    $billtotalfxamount = $res2b['totalfxamount'];
    $mrnno = $res2b['mrnno'];
    $approved_amount = 0;
    
    $query3 = "select sum(approved_amount) as approved_amount from master_transactionpharmacy where transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT' and billnumber = '$billnumber1' and companyanum='$companyanum' and approved_payment = '1'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $num = mysqli_num_rows($exec3);
    
    $query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber1' and companyanum='$companyanum' and recordstatus = 'allocated'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $num = mysqli_num_rows($exec3);
    
    while ($res3 = mysqli_fetch_array($exec3)) {
        $cashamount1 = $res3['cashamount'];
        $onlineamount1 = $res3['onlineamount'];
        $chequeamount1 = $res3['chequeamount'];
        $cardamount1 = $res3['cardamount'];
        $tdsamount1 = $res3['tdsamount'];
        $writeoffamount1 = $res3['writeoffamount'];
        $taxamount1 = $res3['taxamount'];
        
        $cashamount21 = $cashamount21 + $cashamount1;
        $cardamount21 = $cardamount21 + $cardamount1;
        $onlineamount21 = $onlineamount21 + $onlineamount1;
        $chequeamount21 = $chequeamount21 + $chequeamount1;
        $tdsamount21 = $tdsamount21 + $tdsamount1;
        $writeoffamount21 = $writeoffamount21 + $writeoffamount1;
        $taxamount21 = $taxamount21 + $taxamount1;
    }
    
    $query38 = "select totalamount from purchasereturn_details where grnbillnumber = '$mrnno'";
    $exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));
    $num = mysqli_num_rows($exec38);
    $totalreturn = 0;
    
    while($res38 = mysqli_fetch_array($exec38)) {
        $return = $res38['totalamount'];
        $totalreturn = $totalreturn + $return;
    }
    
    $totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;
    $netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
    $balanceamount = $billtotalamount - $netpayment - $approved_amount - $totalreturn;
    $balanceamount = number_format($balanceamount, 2, '.', '');
}

// Get bill number
$query3 = "select * from bill_formats where description = 'goods_returns'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
$paynowbillprefix1 = strlen($paynowbillprefix);

$query2 = "select * from purchasereturn_details where typeofreturn='Process' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit = strlen($billnumber);

if ($billnumber == '') {
    $billnumbercode = $paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
    $openingbalance = '0.00';
} else {
    $billnumber = $res2["billnumber"];
    $maxcount = split("-", $billnumber);
    $maxcount1 = $maxcount[1];
    $maxanum = $maxcount1 + 1;
    $billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
    $openingbalance = '0.00';
}

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

include("autocompletebuild_grn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Returns - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/goodsreturns-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
    
    <!-- JavaScript files -->
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
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
        <a href="inventory.php">📦 Inventory</a>
        <span>→</span>
        <span>Goods Returns</span>
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
                        <a href="goodsreturns.php" class="nav-link">
                            <i class="fas fa-undo"></i>
                            <span>Goods Returns</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="materialreceivednote.php" class="nav-link">
                            <i class="fas fa-clipboard-check"></i>
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
                    <h2>Goods Returns</h2>
                    <p>Process goods returns against purchase orders and update inventory.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="materialreceivednote.php" class="btn btn-outline">
                        <i class="fas fa-clipboard-check"></i> Material Received
                    </a>
                </div>
            </div>

            <!-- GRN Search Form -->
            <div class="grn-search-section">
                <div class="grn-search-header">
                    <i class="fas fa-search grn-search-icon"></i>
                    <h3 class="grn-search-title">Search GRN for Returns</h3>
                </div>
                
                <form name="cbform1" method="post" action="goodsreturns.php" class="grn-search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="grn" class="form-label">GRN Number</label>
                            <input type="text" name="grn" id="grn" class="form-input" 
                                   value="<?php echo htmlspecialchars($billnum); ?>" 
                                   placeholder="Search GRN number..." autocomplete="off" />
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search GRN
                        </button>
                    </div>
                </form>
            </div>

            <!-- Goods Returns Form -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="goods-returns-section">
                <div class="goods-returns-header">
                    <i class="fas fa-undo goods-returns-icon"></i>
                    <h3 class="goods-returns-title">Goods Returns Details</h3>
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
                            <label class="info-label">GRN Number</label>
                            <span class="info-value"><?php echo htmlspecialchars($billnum); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Supplier</label>
                            <span class="info-value"><?php echo htmlspecialchars($suppliername); ?></span>
                            <input name="supplier" id="supplier" value="<?php echo htmlspecialchars($suppliername); ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">GRN Date</label>
                            <span class="info-value"><?php echo htmlspecialchars($billdate); ?></span>
                            <input name="lpodate" id="lpodate" value="<?php echo htmlspecialchars($billdate); ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Return Date</label>
                            <span class="info-value"><?php echo $dateonly; ?></span>
                            <input name="grndate" id="grndate" value="<?php echo $dateonly; ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Time</label>
                            <span class="info-value"><?php echo $timeonly; ?></span>
                            <input name="time" id="time" value="<?php echo $timeonly; ?>" type="hidden"/>
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
                            <span class="info-value"><?php echo htmlspecialchars($locationname); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Store</label>
                            <span class="info-value"><?php echo htmlspecialchars($store); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Location Code</label>
                            <span class="info-value"><?php echo htmlspecialchars($locationcode); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Balance Amount</label>
                            <span class="info-value balance-amount"><?php echo number_format($balanceamount, 2); ?></span>
                            <input type="hidden" name="balanceamt" id="balanceamt" value="<?php echo $balanceamount; ?>">
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="items-table-section">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Return</th>
                                    <th>S.No</th>
                                    <th>Item</th>
                                    <th>Recd.Qty</th>
                                    <th>Ret.Qty</th>
                                    <th>Free</th>
                                    <th>Bal.Qty</th>
                                    <th>Batch</th>
                                    <th>Exp.Dt</th>
                                    <th>Cost Price</th>
                                    <th>Disc %</th>
                                    <th>Total Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $colorloopcount = '';
                                $sno = 0;
                                $totalamount = 0;
                                
                                $query76 = "select * from materialreceiptnote_details where billnumber='$billnum' and billnumber<>'' and itemstatus=''";
                                $exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $number = mysqli_num_rows($exec76);
                                
                                while($res76 = mysqli_fetch_array($exec76)) {
                                    $totalreceivedqty = 0;
                                    $itemname = $res76['itemname'];
                                    $itemcode = $res76['itemcode'];
                                    $rate = $res76['rate'];
                                    $quantity = $res76['quantity'];
                                    $amount = $res76['totalamount'];
                                    $packagequantity = $res76['packagequantity'];
                                    $batch = $res76['batchnumber'];
                                    $expirydate = $res76['expirydate'];
                                    $costprice = $res76['costprice'];
                                    $discountpercentage = $res76['discountpercentage'];
                                    $totalamount = $res76['totalamount'];
                                    $allpackagetotalquantity = $res76['allpackagetotalquantity'];
                                    $itemfreeqty = $res76['itemfreequantity'];
                                    $fifo_code = $res76['fifo_code'];
                                    $ledgeranum = $res76['ledgeranum'];
                                    $ledgercode = $res76['ledgercode'];
                                    $ledgername = $res76['ledgername'];
                                    $incomeledger = $res76['incomeledger'];
                                    $incomeledgercode = $res76['incomeledgercode'];
                                    
                                    $query444 = "select * from purchasereturn_details where itemcode='$itemcode' and grnbillnumber='$billnum' limit 0,10";
                                    $exec444 = mysqli_query($GLOBALS["___mysqli_ston"], $query444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $num444 = mysqli_num_rows($exec444);
                                    
                                    while($res444 = mysqli_fetch_array($exec444)) {
                                        $receivedqty = $res444['packagequantity'];
                                        $totalreceivedqty = $totalreceivedqty + $receivedqty;
                                    }
                                    
                                    $balanceqty = $allpackagetotalquantity - $totalreceivedqty;
                                    
                                    $query77 = "select * from master_medicine where itemcode='$itemcode' limit 0,10";
                                    $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res77 = mysqli_fetch_array($exec77);
                                    $packagesize = $res77['packagename'];
                                    $spmarkup = $res77['spmarkup'];
                                    
                                    $sno = $sno + 1; ?>
                                    <tr class="item-row">
                                        <td class="checkbox-cell">
                                            <input type="checkbox" id="returncheckbox<?php echo $sno; ?>" name="returncheckbox[]" 
                                                   value="<?php echo htmlspecialchars($itemcode); ?>" 
                                                   onChange="checkBox('<?php echo $sno; ?>')">
                                        </td>
                                        <td class="sno-cell"><?php echo $sno; ?></td>
                                        <td class="item-cell"><?php echo htmlspecialchars($itemname); ?></td>
                                        
                                        <input type="hidden" name="itemname[]" value="<?php echo htmlspecialchars($itemname); ?>">
                                        <input type="hidden" name="itemcode[]" value="<?php echo htmlspecialchars($itemcode); ?>">
                                        <input type="hidden" name="rate[]" value="<?php echo $rate; ?>">
                                        <input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">
                                        <input type="hidden" name="fifo_code[]" value="<?php echo $fifo_code; ?>">
                                        <input type="hidden" name="ledgeranum[]" value="<?php echo $ledgeranum; ?>">
                                        <input type="hidden" name="ledgercode[]" value="<?php echo $ledgercode; ?>">
                                        <input type="hidden" name="ledgername[]" value="<?php echo htmlspecialchars($ledgername); ?>">
                                        <input type="hidden" name="incomeledger[]" value="<?php echo $incomeledger; ?>">
                                        <input type="hidden" name="incomeledgercode[]" value="<?php echo $incomeledgercode; ?>">
                                        
                                        <td class="qty-cell"><?php echo intval($allpackagetotalquantity); ?></td>
                                        <td class="input-cell">
                                            <input type="text" readonly name="returnqty[]" id="returnqty<?php echo $sno; ?>" 
                                                   class="form-input-small" autocomplete="off" 
                                                   onKeyUp="amt('<?php echo $sno; ?>','<?php echo $number; ?>');">
                                        </td>
                                        <td class="qty-cell"><?php echo $itemfreeqty; ?></td>
                                        <td class="qty-cell">
                                            <?php echo $balanceqty; ?>
                                            <input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>">
                                        </td>
                                        <td class="qty-cell">
                                            <?php echo htmlspecialchars($batch); ?>
                                            <input type="hidden" name="batch[]" id="batch<?php echo $sno; ?>" value="<?php echo htmlspecialchars($batch); ?>">
                                        </td>
                                        <td class="qty-cell">
                                            <?php echo htmlspecialchars($expirydate); ?>
                                            <input type="hidden" name="expirydate[]" id="expirydate<?php echo $sno; ?>" value="<?php echo htmlspecialchars($expirydate); ?>">
                                        </td>
                                        <td class="qty-cell">
                                            <?php echo number_format($costprice, 2); ?>
                                            <input type="hidden" name="costprice[]" id="costprice<?php echo $sno; ?>" value="<?php echo $costprice; ?>">
                                        </td>
                                        <td class="qty-cell">
                                            <?php echo $discountpercentage; ?>
                                            <input type="hidden" name="discount[]" id="discount<?php echo $sno; ?>" value="<?php echo $discountpercentage; ?>">
                                        </td>
                                        <td class="input-cell">
                                            <input type="text" name="totalamount[]" id="totalamount<?php echo $sno; ?>" 
                                                   class="form-input-small" readonly>
                                        </td>
                                        
                                        <input type="hidden" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" value="">
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
                            <label class="total-label">Total Return Value</label>
                            <input type="text" name="value" id="value" class="total-input" readonly>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <input type="hidden" name="billnum" value="<?php echo htmlspecialchars($billnumbercode); ?>">
                    <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">
                    <input type="hidden" name="suppliername" value="<?php echo htmlspecialchars($suppliername); ?>">
                    <input type="hidden" name="grnno" value="<?php echo htmlspecialchars($billnum); ?>">
                    <input type="hidden" name="locationcode" value="<?php echo htmlspecialchars($locationcode); ?>">
                    <input type="hidden" name="locationname" value="<?php echo htmlspecialchars($locationname); ?>">
                    <input type="hidden" name="store" value="<?php echo $storecode; ?>">
                    <input type="hidden" name="frmflag2" value="frmflag2">
                    
                    <button type="submit" class="btn btn-primary btn-large" onClick="return funcsave('<?php echo $number; ?>')">
                        <i class="fas fa-save"></i> Save Goods Return
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/goodsreturns-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
