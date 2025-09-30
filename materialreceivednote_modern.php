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
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$locationprefix = '';

$titlestr = 'MATERIAL RECEIVED NOTE';

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

if(isset($_REQUEST['locationcode'])) { 
    $locationcode = $_REQUEST['locationcode']; 
} else { 
    $locationcode = ''; 
}

if (isset($_SESSION["materialreceivednotesession"])) { 
    $materialreceivednotesession = $_SESSION["materialreceivednotesession"]; 
} else { 
    $materialreceivednotesession = ""; 
}

// Process form submission
if ($frmflag2 == 'frmflag2') {
    if($materialreceivednotesession == 'pending') {
        $_SESSION['materialreceivednotesession'] = 'completed';
        $store = $_REQUEST['store1'];
        $job_title = $_REQUEST['jobtitle'];
        $billdate = $_REQUEST['billdate'];
        $suppliername = $_REQUEST['suppliername'];
        $suppliercode = $_REQUEST['suppliercode'];
        $accountssubid = $_REQUEST['accountssubid'];
        $supplierbillno = $_REQUEST['supplierbillno1'];
        $amount = $_REQUEST['totalpurchaseamount'];
        $currency = $_REQUEST['currency'];
        $fxrate = $_REQUEST['fxrate'];
        $deliverybillno = $_REQUEST['deliverybillno1'];
        $totalfxamount = $_REQUEST['totalfxamount'];
        $purchasetype = $_REQUEST['purchasetype'];

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

        $locationcode = $_REQUEST['location'];
        $locationname = $_REQUEST['locationname'];
        if($_REQUEST['store1'] == '') {
            $store1 = "STO1";
        } else {
            $store1 = $_REQUEST['store1'];
        }

        $query66 = "select * from master_location where locationcode = '$locationcode'";
        $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res66 = mysqli_fetch_array($exec66);
        $locationprefix = $res66['prefix'];

        $query3 = "select * from bill_formats where description = 'material_receivednote'";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res3 = mysqli_fetch_array($exec3);
        $paynowbillprefix = $res3['prefix'];
        $paynowbillprefix1 = strlen($paynowbillprefix);
        $query2 = "select * from materialreceiptnote_details where typeofpurchase='Process' and billnumber like '%$paynowbillprefix-%' order by auto_number desc limit 0, 1";
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

        // Process each item
        foreach($_POST['itemname'] as $key => $value) {
            $itemname = $_POST['itemname'][$key];
            $itemcode = $_POST['itemcode'][$key];
            $selectitemcode = $_POST['selectitemcode'][$key];
            $ponumber = $_POST['ponumber'][$key];
            
            foreach($_POST['selectitem'] as $check => $value1) {
                $selectitem = $_POST['selectitem'][$check];
                
                if($selectitemcode == $selectitem) {
                    $query5 = "select * from master_itempharmacy where itemcode = '$itemcode'";
                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res5 = mysqli_fetch_array($exec5);
                    $itemanum = $res5['auto_number'];
                    
                    $rate = $_POST['rate'][$key];
                    $quantity = $_POST['receivedquantity'][$key];
                    $allpackagetotalquantity = $_POST['totalquantity'][$key];
                    $free = $_POST['free'][$key];
                    $itemdiscountpercent = $_POST['discount'][$key];
                    $totalamount = $_POST['totalamount1'][$key];
                    $itemtaxpercent = $_POST['taxper'][$key];
                    $itemtaxamount = $_POST['tax'][$key];
                    $batchnumber = $_POST['batch'][$key];
                    $batchnumber = str_replace("", "", $batchnumber);
                    $batchnumber = trim($batchnumber);
                    $salesprice = $_POST['saleprice'][$key];
                    $costprice = $_POST['costprice'][$key];
                    $expirydate = $_POST['expirydate'][$key];
                    $fxamount1 = $_POST['fxamount'][$key];
                    $totalfxpuramount = $_POST['totalfxamount1'][$key];
                    $expirymonth = substr($expirydate, 0, 2);
                    $expiryyear = substr($expirydate, 3, 2);
                    $expiryday = '01';
                    $expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
                    $priceperpack = $_POST['priceperpack'][$key];
                    $packagename = $_POST['packsize'][$key];
                    $balqty = $_POST['balqty'][$key];
                    $store1 = $_POST['store_id'][$key];
                    
                    if($balqty == $quantity) {
                        $itemstatus = 'received';
                    } else {
                        $itemstatus = '';
                    }

                    // Get item details
                    $query31 = "select unitname_abbreviation, packageanum, categoryname from master_itempharmacy where itemcode = '$itemcode'"; 
                    $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res31 = mysqli_fetch_array($exec31);
                    $itemunitabb = $res31['unitname_abbreviation'];
                    $res31packageanum = $res31['packageanum'];
                    $categoryname = $res31['categoryname'];

                    $query32 = "select auto_number, quantityperpackage from master_packagepharmacy where auto_number = '$res31packageanum'";
                    $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res32 = mysqli_fetch_array($exec32);
                    $packageanum = $res32['auto_number'];
                    $quantityperpackage = $res32['quantityperpackage'];

                    $query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode from master_medicine where itemcode = '$itemcode'"; 
                    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res6 = mysqli_fetch_array($exec6);
                    $ledgername = $res6['ledgername'];
                    $ledgercode = $res6['ledgercode'];
                    $ledgeranum = $res6['ledgerautonumber'];
                    $incomeledger = $res6['incomeledger'];
                    $incomeledgercode = $res6['incomeledgercode'];

                    // Stock management logic
                    $querystock2 = "select fifo_code from transaction_stock where docstatus='New Batch' order by auto_number desc limit 0, 1";
                    $execstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querystock2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $resstock2 = mysqli_fetch_array($execstock2);
                    $fifo_code = $resstock2["fifo_code"];
                    
                    if ($fifo_code == '') {
                        $fifo_code = '1';
                        $queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode'";
                        $execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        $stockquery2 = "insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description, batchnumber, batch_quantity, transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode) values ('$fifo_code','purchase_details','$itemcode', '$itemname', '$updatedate','1', 'Purchase', '$batchnumber', '$allpackagetotalquantity', '$allpackagetotalquantity', '$allpackagetotalquantity', '$billnumbercode', 'New Batch','1','1', '$locationcode','','$store1', '', '$username', '$ipaddress','$updatedate','$updatetime','$updatedatetime','$costprice','$totalamount','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
                        $stockexecquery2 = mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    } else {
                        $querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode'";
                        $execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $rescumstock2 = mysqli_fetch_array($execcumstock2);
                        $cum_quantity = $rescumstock2["cum_quantity"];
                        $cum_quantity = $allpackagetotalquantity + $cum_quantity;
                        $fifo_code = $fifo_code + 1;
                        
                        $queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode'";
                        $execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        $stockquery2 = "insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description, batchnumber, batch_quantity, transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode) values ('$fifo_code','purchase_details','$itemcode', '$itemname', '$updatedate','1', 'Purchase', '$batchnumber', '$allpackagetotalquantity', '$allpackagetotalquantity', '$cum_quantity', '$billnumbercode', 'New Batch','1','1', '$locationcode','','$store1', '', '$username', '$ipaddress','$updatedate','$updatetime','$updatedatetime','$costprice','$totalamount','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
                        $stockexecquery2 = mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    }

                    // Insert material receipt note details
                    $query4 = "insert into materialreceiptnote_details (bill_autonumber, companyanum, billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, packageanum, packagename, quantityperpackage, allpackagetotalquantity, manufactureranum, manufacturername,typeofpurchase,suppliername,suppliercode,ponumber,supplierbillnumber,costprice,locationcode,store,coa,categoryname,fifo_code,totalfxamount,fxpkrate,priceperpk,deliverybillno,currency,fxamount,ledgeranum,ledgercode,ledgername ,incomeledger,incomeledgercode,purchasetype,job_title) values ('$billautonumber', '$companyanum', '$billnumbercode', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', '$totalamount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$openingstock', '$closingstock', '$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', '$itemtaxpercent', '$itemtaxamount', '$itemunitabb', '$batchnumber', '$costprice', '$expirydate', '$free', '$quantity', '$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', '$manufactureranum', '$manufacturername','Process','$suppliername','$suppliercode','$ponumber','$supplierbillno','$costprice','$locationcode','$store1','$coa','$categoryname','$fifo_code','$totalfxpuramount','$fxamount1','$priceperpack','$deliverybillno','$currency','$fxrate','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$purchasetype','$job_title')";
                    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    // Update purchase order details
                    $condn = "";
                    if($purchasetype == 'ASSETS') {
                        $poidres = explode("|", $selectitemcode);
                        $po_auto_number = $poidres[0];
                        if($po_auto_number > 0) {
                            $condn = " and auto_number = '$po_auto_number' ";
                        }
                    }
                    $query56 = "update purchaseorder_details set goodsstatus='$itemstatus' where billnumber='$ponumber' and itemcode='$itemcode' $condn ";
                    $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                
                    $query561 = "update master_itempharmacy set rateperunit='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";
                    $exec561 = mysqli_query($GLOBALS["___mysqli_ston"], $query561) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    $locationrate = $locationcode.'_rateperunit';
                    $query562 = "update master_medicine set rateperunit='$salesprice',`$locationrate`='$salesprice' where itemcode='$itemcode'";
                    $exec562 = mysqli_query($GLOBALS["___mysqli_ston"], $query562) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
        }
    }
    header("location:materialreceivednote.php?mrn=$billnumbercode&&locationcode=$locationcode");
}

// Handle supplier search
if (isset($_REQUEST["cbfrmflag1"])) { 
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
} else { 
    $cbfrmflag1 = ""; 
}

if ($cbfrmflag1 == 'cbfrmflag1') {
    $storecodeget = '';
    $supplier_code = $_POST['srchsuppliercode'];
    
    $query5 = "select * from purchaseorder_details where suppliercode='$supplier_code' and (recordstatus='autogenerated' || recordstatus='generated') and locationcode='$main_locationcode' order by auto_number desc limit 1";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while ($res5 = mysqli_fetch_array($exec5)) {
        $billnum = $res5["billnumber"];
        $suppliername = $res5['suppliername'];
        $suppliercode = $res5['suppliercode'];
        $suppliername = strtoupper($suppliername);
        $srchsupplieranum = $res5['supplieranum'];
        $billdate = $res5['billdate'];
        $res5locationcode = $res5['locationcode'];
        $res5locationname = $res5['locationname'];
        $currency = $res5['currency'];
        $fxamount = $res5['fxamount'];	
        $purchaseindentdocno = $res5['purchaseindentdocno'];
        
        if($currency == '') {
            $currency = 'UGX';
            $fxamount = '1';
        }
        
        $storename = $res5['storename'];	
        $storecodeget = $res5['storecode'];
        
        $query47 = "select * from purchase_indent where docno = '$purchaseindentdocno'";
        $exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die ("Error in Query47".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res47 = mysqli_fetch_array($exec47);
        $purchasetype = $res47['purchasetype'];
        
        $query66 = "select * from master_location where locationcode = '$res5locationcode'";
        $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res66 = mysqli_fetch_array($exec66);
        $locationprefix = $res66['prefix'];
        
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
$query3 = "select * from bill_formats where description = 'material_receivednote'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
$paynowbillprefix1 = strlen($paynowbillprefix);
$query2 = "select * from materialreceiptnote_details where typeofpurchase='Process' and billnumber like '%$paynowbillprefix-%' order by auto_number desc limit 0, 1";
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

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where locationcode='$main_locationcode'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$locationname = $res55['locationname'];
$locationanum = $res55['auto_number'];

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

include("autocompletebuild_purchaseorder.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Received Note - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/materialreceivednote-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- AutoComplete styles -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
    
    <!-- JavaScript files -->
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/autocomplete_purchaseorder.js"></script>
    <script type="text/javascript" src="js/autosuggestpurchaseorder.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    
    <?php include ("js/dropdownlist1scriptingpurchaseorder.php"); ?>
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
        <span>Material Received Note</span>
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
                        <a href="materialreceivednote.php" class="nav-link">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Material Received</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="purchaseorder.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
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
                    <h2>Material Received Note</h2>
                    <p>Process material receipts against purchase orders and update inventory.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <a href="purchaseorder.php" class="btn btn-outline">
                        <i class="fas fa-shopping-cart"></i> Purchase Orders
                    </a>
                </div>
            </div>

            <!-- Supplier Search Form -->
            <div class="supplier-search-section">
                <div class="supplier-search-header">
                    <i class="fas fa-search supplier-search-icon"></i>
                    <h3 class="supplier-search-title">Search Supplier & Purchase Orders</h3>
                </div>
                
                <form name="cbform1" id="cbform1" method="post" action="materialreceivednote.php" class="supplier-search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="supplier" class="form-label">Supplier</label>
                            <input type="text" name="supplier" id="supplier" class="form-input" 
                                   value="<?php echo htmlspecialchars($suppliername); ?>" 
                                   placeholder="Search supplier..." autocomplete="off" />
                            <input type="hidden" name="srchsuppliercode" id="srchsuppliercode" value="<?php echo htmlspecialchars($suppliercode); ?>">
                            <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $srchsupplieranum ?>" />
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search Orders
                        </button>
                    </div>
                </form>
            </div>

            <!-- Material Receipt Form -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="material-receipt-section">
                <div class="material-receipt-header">
                    <i class="fas fa-clipboard-check material-receipt-icon"></i>
                    <h3 class="material-receipt-title">Material Receipt Details</h3>
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
                            <label class="info-label">Supplier</label>
                            <span class="info-value"><?php echo htmlspecialchars($suppliername); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">LPO Date</label>
                            <span class="info-value"><?php echo htmlspecialchars($billdate); ?></span>
                            <input name="lpodate" id="lpodate" value="<?php echo htmlspecialchars($billdate); ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">MRN Date</label>
                            <span class="info-value"><?php echo $dateonly; ?></span>
                            <input name="grndate" id="grndate" value="<?php echo $dateonly; ?>" type="hidden"/>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Location</label>
                            <span class="info-value"><?php echo htmlspecialchars($res5locationname); ?></span>
                        </div>
                        
                        <div class="info-item">
                            <label class="info-label">Currency</label>
                            <span class="info-value"><?php echo htmlspecialchars($currency.' , '.$fxamount); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Invoice Information -->
                <div class="invoice-info-section">
                    <div class="invoice-info-grid">
                        <div class="form-group">
                            <label for="invoiceamount" class="form-label">Invoice Amount</label>
                            <input type="text" name="invoiceamount" id="invoiceamount" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="supplierbillno" class="form-label">Invoice No</label>
                            <input name="supplierbillno" id="supplierbillno" class="form-input" 
                                   placeholder="Enter invoice number..." autocomplete="off" 
                                   onKeyUp="return billnotransfer()" />
                        </div>
                        
                        <div class="form-group">
                            <label for="deliverybillno" class="form-label">DC No</label>
                            <input name="deliverybillno" id="deliverybillno" class="form-input" 
                                   placeholder="Enter delivery number..." autocomplete="off" 
                                   onKeyUp="return billnotransfer()" />
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="items-table-section">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Check</th>
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
                                    <th>FX (Units)</th>
                                    <th>Disc %</th>
                                    <th>Tax %</th>
                                    <th>Tax.Amt</th>
                                    <th>Total FX</th>
                                    <th>Price (Units)</th>
                                    <th>Total Value</th>
                                    <th>Store</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $colorloopcount = '';
                                $sno = 0;
                                $totalamount = 0;
                                
                                if ($cbfrmflag1 == 'cbfrmflag1') {
                                    $suppliercode = $_POST['srchsuppliercode'];
                                    if(trim($suppliercode) != "") {
                                        $query76 = "select billnumber from purchaseorder_details where suppliercode='$suppliercode' and (recordstatus='autogenerated' || recordstatus='generated') and goodsstatus='' and itemstatus <> 'deleted' and locationcode='$main_locationcode' group by billnumber order by auto_number DESC";
                                        
                                        $ponumber_arr = array();
                                        $exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

                                        $totitems_qry = "select auto_number from purchaseorder_details where suppliercode='$suppliercode' and (recordstatus='autogenerated' || recordstatus='generated') and goodsstatus='' and itemstatus <> 'deleted' and locationcode='$main_locationcode' ";
                                        $exec_itemscnt = mysqli_query($GLOBALS["___mysqli_ston"], $totitems_qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $number = mysqli_num_rows($exec_itemscnt);
                                        
                                        while($respo = mysqli_fetch_array($exec76)) {
                                            $po_number = $respo['billnumber'];
                                            
                                            $qry_pos = "select * from purchaseorder_details where billnumber='$po_number' and (recordstatus='autogenerated' || recordstatus='generated') and goodsstatus='' and itemstatus <> 'deleted' and locationcode='$main_locationcode' ";
                                            $exec_po = mysqli_query($GLOBALS["___mysqli_ston"], $qry_pos) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $numrows = mysqli_num_rows($exec_po);

                                            if($numrows) { ?>
                                                <tr class="po-header">
                                                    <td colspan="2" class="po-number">
                                                        <i class="fas fa-file-alt"></i>
                                                        <?php echo htmlspecialchars($po_number); ?>
                                                    </td>
                                                    <td colspan="17" class="po-spacer">&nbsp;</td>
                                                </tr>
                                            <?php 
                                            }
                                            
                                            while($res76 = mysqli_fetch_array($exec_po)) {
                                                $_SESSION['materialreceivednotesession'] = 'pending';
                                                $totalreceivedqty = 0;
                                                $itemname = $res76['itemname'];
                                                $itemcode = $res76['itemcode'];
                                                $rate = $res76['rate'];
                                                $fxpkrate = $res76['fxpkrate'];
                                                $packagesize = $res76['packsize'];
                                                $job_title = $res76['job_title'];
                                                $taxamount = $res76['itemtaxamount'];
                                                $tax_percentage = $res76['itemtaxpercentage'];
                                                $suppliercodee = $res76['suppliercode'];
                                                $locationcode_row = $res76['locationcode'];
                                                $quantity = 0;
                                                $amount = 0;
                                                $packagequantity = 0;
                                                $fxtotamount = 0; 
                                                $assetspackqty = 0;
                                                $itemanum = $res76['auto_number']; 
                                                
                                                // Get purchase type
                                                $query55 = "select purchaseindentdocno from purchaseorder_details where suppliercode='$suppliercodee' and billnumber='$po_number' order by auto_number desc limit 1";
                                                $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res55 = mysqli_fetch_array($exec55);
                                                $purchaseindentdocno1 = $res55['purchaseindentdocno'];
                                                $query477 = "select purchasetype from purchase_indent where docno = '$purchaseindentdocno1'";
                                                $exec477 = mysqli_query($GLOBALS["___mysqli_ston"], $query477) or die ("Error in Query477".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res477 = mysqli_fetch_array($exec477);
                                                $purchasetypee = $res477['purchasetype'];

                                                $condn = "";
                                                if($purchasetypee == 'ASSETS') {
                                                    $condn = " and auto_number = '$itemanum' ";
                                                }
                                                
                                                $query767 = "select * from purchaseorder_details where billnumber='$po_number' and itemcode = '$itemcode' $condn and (recordstatus='autogenerated' || recordstatus='generated') and goodsstatus='' and itemstatus <> 'deleted' and auto_number = '$itemanum'";
                                                $exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $number7 = mysqli_num_rows($exec767);
                                                
                                                while($res767 = mysqli_fetch_array($exec767)) {
                                                    $quantity = $quantity + $res767['quantity'];
                                                    $amount = $amount + $res767['totalamount'];
                                                    $packagequantity = $packagequantity + $res767['packagequantity'];
                                                    if($purchasetypee == 'ASSETS') {
                                                        $assetspackqty = $assetspackqty + $res767['quantity'];
                                                    }
                                                    $fxtotamount = $fxtotamount + $res767['fxtotamount']; 
                                                }
                                                
                                                $fxtotamount = number_format($fxtotamount, 2, '.', '');
                                                $amount = number_format($amount, 2, '.', '');
                                                
                                                $qty_condn = "";
                                                if($purchasetypee == 'ASSETS') {
                                                    $qty_condn = " and itemname = '$itemname' ";
                                                }
                                                
                                                $query444 = "select * from materialreceiptnote_details where itemcode='$itemcode' and ponumber='$po_number' $qty_condn ";
                                                $exec444 = mysqli_query($GLOBALS["___mysqli_ston"], $query444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $num444 = mysqli_num_rows($exec444);
                                                
                                                while($res444 = mysqli_fetch_array($exec444)) {
                                                    $receivedqty = $res444['quantity'];
                                                    $totalreceivedqty = $totalreceivedqty + $receivedqty;
                                                }
                                                
                                                if($purchasetypee == 'ASSETS') {
                                                    $packagequantity = $assetspackqty;
                                                }
                                                $balanceqty = $packagequantity - $totalreceivedqty;
                                                
                                                $query77 = "select * from master_medicine where itemcode='$itemcode'";
                                                $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res77 = mysqli_fetch_array($exec77);
                                                
                                                if($packagesize == '') {
                                                    $packagesize = $res77['packagename'];
                                                }
                                                $spmarkup = $res77['spmarkup'];
                                                $type = $res77['type'];
                                                $storecolumn = 'nondrug_store';
                                                
                                                if($type == 'DRUGS') {
                                                    $storecolumn = 'drugs_store';
                                                } elseif($type == 'NON DRUGS') {
                                                    $storecolumn = 'nondrug_store';
                                                } elseif($type == 'ASSETS') {
                                                    $storecolumn = 'asset_store';
                                                }
                                                
                                                $query7a = "select $storecolumn as store from master_location where locationcode='$locationcode_row'";
                                                $exec7a = mysqli_query($GLOBALS["___mysqli_ston"], $query7a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res7a = mysqli_fetch_array($exec7a);
                                                $storecode = $res7a['store'];
                                                
                                                $query75 = "select store from master_store where storecode='$storecode'";
                                                $exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res75 = mysqli_fetch_array($exec75);
                                                $store_name = $res75['store'];
                                                
                                                if($purchasetypee == 'ASSETS' || $purchasetypee == 'non-medical') {
                                                    $packagesize = 1;
                                                } elseif($packagesize == '' || $packagesize == 0) {
                                                    $packagesize = '1S';
                                                }
                                                
                                                $sno = $sno + 1; ?>
                                                <tr class="item-row">
                                                    <td class="checkbox-cell">
                                                        <input type="checkbox" class="selectitem" name="selectitem[]" 
                                                               id="selectitem<?php echo $sno; ?>" 
                                                               value="<?php echo $itemanum.'|'.$itemcode; ?>" 
                                                               onClick="enabletext('<?php echo $sno; ?>','<?php echo $number; ?>')">
                                                    </td>
                                                    <td class="sno-cell"><?php echo $sno; ?></td>
                                                    <td class="item-cell"><?php echo htmlspecialchars($itemname); ?></td>
                                                    
                                                    <input type="hidden" name="itemname[]" value="<?php echo htmlspecialchars($itemname); ?>">
                                                    <input type="hidden" name="itemcode[]" value="<?php echo htmlspecialchars($itemcode); ?>">
                                                    <input type="hidden" name="selectitemcode[]" value="<?php echo $itemanum.'|'.$itemcode; ?>">
                                                    <input type="hidden" name="ponumber[]" value="<?php echo htmlspecialchars($po_number); ?>">
                                                    <input type="hidden" name="purchasetype<?php echo $sno; ?>" id="purchasetype<?php echo $sno; ?>" value="<?php echo htmlspecialchars($purchasetypee); ?>">
                                                    <input type="hidden" name="rate[]" value="<?php echo $rate; ?>">
                                                    <input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">
                                                    <input type="hidden" name="totalamount[]" value="<?php echo $amount; ?>">
                                                    <input type="hidden" name="jobtitle" value="<?php echo htmlspecialchars($job_title); ?>">
                                                    
                                                    <td class="qty-cell"><?php echo $packagequantity; ?></td>
                                                    <td class="input-cell">
                                                        <input type="text" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" 
                                                               onKeyUp="return totalcalc('<?php echo $sno; ?>');" 
                                                               onBlur="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');" readonly>
                                                    </td>
                                                    <td class="qty-cell">
                                                        <?php echo $balanceqty; ?>
                                                        <input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>">
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="batch[]" id="batch<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" readonly>
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="expirydate[]" id="expirydate<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" readonly>
                                                    </td>
                                                    <td class="qty-cell">
                                                        <?php echo $packagesize; ?>
                                                        <input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo $packagesize; ?>">
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="free[]" id="free<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" 
                                                               onKeyUp="return totalcalc1('<?php echo $sno; ?>');" readonly>
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="totalquantity[]" id="totalquantity<?php echo $sno; ?>" 
                                                               class="form-input-small" readonly>
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="fxamount[]" id="fxamount<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" readonly 
                                                               value="<?php echo number_format($fxpkrate, 2, '.', ''); ?>">
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="discount[]" id="discount<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" readonly>
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="taxper[]" id="taxper<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" readonly 
                                                               value="<?php echo $tax_percentage; ?>">
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="tax[]" id="tax<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" readonly 
                                                               value="<?php echo $taxamount; ?>">
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="totalfxamount1[]" id="totalfxamount<?php echo $sno; ?>" 
                                                               class="form-input-small" readonly value="<?php echo $fxtotamount; ?>">
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" 
                                                               class="form-input-small" autocomplete="off" readonly 
                                                               value="<?php echo $rate; ?>">
                                                    </td>
                                                    <td class="input-cell">
                                                        <input type="text" name="totalamount1[]" id="totalamount<?php echo $sno; ?>" 
                                                               class="form-input-small" readonly value="<?php echo $amount; ?>">
                                                    </td>
                                                    <td class="store-cell">
                                                        <?php echo htmlspecialchars($store_name); ?>
                                                        <input type="hidden" name="store_id[]" id="store_id<?php echo $sno; ?>" value="<?php echo $storecode; ?>">
                                                    </td>
                                                    
                                                    <input type="hidden" name="costprice[]" id="costprice<?php echo $sno; ?>" value="">
                                                    <input type="hidden" name="spmarkup" id="spmarkup<?php echo $sno; ?>" value="<?php echo $spmarkup; ?>">
                                                    <input type="hidden" name="saleprice[]" id="saleprice<?php echo $sno; ?>" value="">
                                                </tr>
                                            <?php 
                                            }
                                        }
                                    }
                                }
                                ?>
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
                                   class="total-input" readonly>
                        </div>
                        <div class="total-item">
                            <label class="total-label">Total FX Purchase Cost</label>
                            <input type="text" name="totalfxamount" id="totalfxamount" 
                                   class="total-input" readonly>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <input type="hidden" name="billnum" value="<?php echo htmlspecialchars($billnumbercode); ?>">
                    <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">
                    <input type="hidden" name="suppliername" value="<?php echo htmlspecialchars($suppliername); ?>">
                    <input type="hidden" name="location" value="<?php echo htmlspecialchars($res5locationcode); ?>">
                    <input type="hidden" name="locationname" value="<?php echo htmlspecialchars($res5locationname); ?>">
                    <input type="hidden" name="store1" id="store1" value="<?php echo $storecodeget; ?>">
                    <input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo htmlspecialchars($suppliercode); ?>">
                    <input type="hidden" name="accountssubid" value="<?php echo $accountssubid; ?>">
                    <input type="hidden" name="supplierbillno1" id="supplierbillno1">
                    <input name="deliverybillno1" id="deliverybillno1" type="hidden">
                    <input name="fxrate" id="fxrate" value="<?php echo $fxamount; ?>" type="hidden"/>
                    <input name="currency" id="currency" value="<?php echo $currency; ?>" type="hidden"/>
                    <input type="hidden" name="purchasetype" id="purchasetype" value="<?php echo $purchasetype; ?>">
                    <input type="hidden" name="frmflag2" value="frmflag2">
                    
                    <button type="submit" class="btn btn-primary btn-large" id="savebutton" 
                            onClick="return funcsave('<?php echo $number; ?>')">
                        <i class="fas fa-save"></i> Save Material Receipt
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/materialreceivednote-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
