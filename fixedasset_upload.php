<?php
ini_set('max_execution_time', '300'); // 300 seconds = 5 minutes
session_start();
error_reporting(0);

include ("db/db_connect.php");
include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetitme = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$suppdateonly = date("Y-m-d");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$pagename = 'FIXED ASSET UPLOAD';
$today_date = date("Y-m-d");
$titlestr = 'FIXED ASSET UPLOAD';
$docno = $_SESSION['docno'];

// Get location information
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$reslocationname = $res["locationname"];
$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where locationname='$reslocationname'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$locationcode = $res3['locationcode'];
$locationname = $res3['locationname'];
$location = $locationcode;

// Handle form submissions
if (isset($_REQUEST["frm1submit1"])) { 
    $frm1submit1 = $_REQUEST["frm1submit1"]; 
} else { 
    $frm1submit1 = ""; 
}

if (isset($_REQUEST["frmflag_upload"])) { 
    $frmflag_upload = $_REQUEST["frmflag_upload"]; 
} else { 
    $frmflag_upload = ""; 
}

// Process file upload
if ($frmflag_upload == 'frmflag_upload') {
    $locationcode = $_REQUEST['locationcode'];
    $locationname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['locationname']);
    
    $uploadResults = [];
    $successCount = 0;
    $errorCount = 0;
    
    if (!empty($_FILES['upload_file'])) {
        $inputFileName = $_FILES['upload_file']['tmp_name'];
        
        include 'phpexcel/Classes/PHPExcel/IOFactory.php';
        
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFileName);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $CurrentWorkSheetIndex = 0;
            
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestDataRow();
                $highestColumn = $worksheet->getHighestDataColumn();
                $rowData = $worksheet->rangeToArray('A1:' . $highestColumn . 1, NULL, TRUE, FALSE)[0];
                
                $dep_datecolumn = $rowData[14];
                $depreciate_datearr = explode("Depreciation ", $dep_datecolumn);
                $depdate = $depreciate_datearr[1];
                
                $ledger_sequence_no = 1;
                
                // Map column headers
                $columnMapping = [];
                foreach($rowData as $key => $value) {
                    switch($value) {
                        case 'ASSET CATEGORY': $columnMapping['asset_category'] = $key; break;
                        case 'DEPARTMENT': $columnMapping['department'] = $key; break;
                        case 'UNIT': $columnMapping['unit'] = $key; break;
                        case 'ASSET NAMES': $columnMapping['assetname'] = $key; break;
                        case 'SERIAL NUMBER': $columnMapping['serialno'] = $key; break;
                        case 'SUPPLIER': $columnMapping['supplier'] = $key; break;
                        case 'ASSET CATEGORY-SECTION': $columnMapping['categorysection'] = $key; break;
                        case 'ASSET ID - FORMER': $columnMapping['assetid_former'] = $key; break;
                        case 'TAG NUMBER - (CURRENT': $columnMapping['assetid'] = $key; break;
                        case 'COST': $columnMapping['purchasecost'] = $key; break;
                        case 'ACQUISITION DATE': $columnMapping['acquisition_date'] = $key; break;
                        case 'LIFE': $columnMapping['life'] = $key; break;
                        case 'DEPRECIATION START YEAR': $columnMapping['depreciation_start_year'] = $key; break;
                        case 'ASSET LEDGER': $columnMapping['asset_ledgerid'] = $key; break;
                        case 'DEPRECIATION LEDGER': $columnMapping['depreciation_ledgerid'] = $key; break;
                        case 'ACC. DEP. LEDGER': $columnMapping['acc_dep_ledgerid'] = $key; break;
                        case 'DEPRECIATION 30/06/19': $columnMapping['depreciation_amount'] = $key; break;
                    }
                }
                
                // Process data rows
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
                    
                    $asset_category_name = trim($rowData[$columnMapping['asset_category']]);
                    $department_name = trim($rowData[$columnMapping['department']]);
                    $asset_unit = trim($rowData[$columnMapping['unit']]);
                    $asset_name = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$columnMapping['assetname']]));
                    $serialno = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$columnMapping['serialno']]));
                    $supplier = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$columnMapping['supplier']]));
                    $section = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$columnMapping['categorysection']]));
                    $assetid_former = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$columnMapping['assetid_former']]));
                    $asset_id = trim($rowData[$columnMapping['assetid']]);
                    $noofyears = trim($rowData[$columnMapping['life']]);
                    $asset_ledger_id = trim($rowData[$columnMapping['asset_ledgerid']]);
                    $depreciation_ledger_id = trim($rowData[$columnMapping['depreciation_ledgerid']]);
                    $acc_depreciation_ledger_id = trim($rowData[$columnMapping['acc_dep_ledgerid']]);
                    $costprice = trim($rowData[$columnMapping['purchasecost']]);
                    $acquisitiondate = trim($rowData[$columnMapping['acquisition_date']]);
                    $acquisitiondate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($acquisitiondate));
                    $dep_start_year = trim($rowData[$columnMapping['depreciation_start_year']]);
                    $dep_start_year = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($dep_start_year));
                    $depreciation_amount = abs(trim($rowData[$columnMapping['depreciation_amount']]));
                    $depreciation_amount = str_replace(',', '', $depreciation_amount);
                    
                    // Process depreciation date
                    $d = date_parse_from_format("Y-m-d", $dep_start_year);
                    $month = $d["month"];
                    $start_year = $d['year'];
                    $date = strtotime($dep_start_year);
                    $mon = date('M', $date);
                    $monthabbr = strtoupper($mon);
                    $process_month = $monthabbr . '-' . $start_year;
                    
                    if ($month < 10) {
                        $month = "0" . $month;
                    }
                    $start_day = '01';
                    $depreciation_start_date = $dep_start_year;
                    
                    $salvage = 0;
                    $dep_percent = 0;
                    $accdepreciationvalue = 0;
                    
                    // Get ledger names
                    $assetledger = "";
                    if ($asset_ledger_id != "") {
                        $assetledger = getLedgerName($asset_ledger_id);
                    }
                    $depreciation = "";
                    if ($depreciation_ledger_id != "") {
                        $depreciation = getLedgerName($depreciation_ledger_id);
                    }
                    $accdepreciation = "";
                    if ($acc_depreciation_ledger_id != "") {
                        $accdepreciation = getLedgerName($acc_depreciation_ledger_id);
                    }
                    $gainlossledger = "Gain/loss on Disposal of Fixed Assets";
                    $gainlossledgercode = "04-1500-1";
                    
                    if ($asset_name != "") {
                        $error_message = "";
                        $error_flag = '0';
                        
                        // Check if asset category exists
                        $query = "select auto_number from master_assetcategory where category='$asset_category_name' and recordstatus=''";
                        $catexec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        $cat_num_rows = mysqli_num_rows($catexec);
                        
                        if ($cat_num_rows) {
                            $category_res = mysqli_fetch_array($catexec);
                            $asset_category_id = $category_res['auto_number'];
                        } else {
                            $query1 = "insert into master_assetcategory (category, ipaddress, recorddate, username, id, salvage, noofyears) values ('$asset_category_name', '$ipaddress', '$updatedatetime', '$username', '', '$salvage', '$noofyears')";
                            mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $asset_category_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
                        }
                        
                        // Check if asset ID already exists
                        $query33 = "select asset_id from assets_register where asset_id = '$asset_id'";
                        $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        $row33 = mysqli_num_rows($exec33);
                        
                        if ($row33 == 0) {
                            // Generate new asset number
                            $query32 = "select auto_number from assets_register order by auto_number desc limit 0,1";
                            $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res32 = mysqli_fetch_array($exec32);
                            $anum = $res32['auto_number'];
                            $assetanum = $anum + 1;
                            $billnumber = 'FAP-' . $assetanum;
                            
                            // Insert into assets_register
                            $query88 = "INSERT INTO assets_register SET `billnumber` = '$billnumber', `itemname` = '$asset_name', `asset_id` = '$asset_id', `asset_category` = '$asset_category_name', `asset_department` = '$department_name', `asset_unit` = '$asset_unit', `asset_period` = '$noofyears', companyanum = '$companyanum', `startyear` = '$process_month', asset_class = '$asset_category_name', dep_percent = '$dep_percent', `depreciationledger` = '$depreciation', `depreciationledgercode` = '$depreciation_ledger_id', `accdepreciationledger` = '$accdepreciation', `accdepreciationledgercode` = '$acc_depreciation_ledger_id', `accdepreciation` = '$accdepreciationvalue', `rate` = '$costprice', `quantity` = '1', `subtotal` = '$costprice', `totalamount` = '$costprice', `coa` = '$asset_ledger_id', `username` = '$username', `ipaddress` = '$ipaddress', `entrydate` = '$acquisitiondate', `itemtotalquantity` = '1', `typeofpurchase` = 'Manual', `locationcode` = '$locationcode', `location` = '$locationname', `assetledger` = '$assetledger', `assetledgercode` = '$asset_ledger_id', `salvage` = '$salvage', `depreciation_start_month` = '$month', `depreciation_start_year` = '$dep_start_year', `depreciation_start_date` = '$depreciation_start_date', `asset_category_id` = '$asset_category_id', `gainloss_ledger` = '$gainlossledger', `gainloss_ledger_code` = '$gainlossledgercode', `serial_number` = '$serialno', `asset_category_section` = '$section', `assetid_former` = '$assetid_former', `supplier` = '$supplier'";
                            
                            $exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            // Insert into purchase_details
                            $query881 = "INSERT INTO purchase_details SET `billnumber` = '$billnumber', `itemcode`='$assetid', `itemname` = '$asset_name', companyanum = '$companyanum', `rate` = '$costprice', `quantity` = '1', `subtotal` = '$costprice', `totalamount` = '$costprice', `costprice` = '$costprice', `coa` = '$asset_ledger_id', `username` = '$username', `ipaddress` = '$ipaddress', `entrydate` = '$acquisitiondate', `itemtotalquantity` = '1', `typeofpurchase` = 'Manual', `purchasetype` = 'Asset', `totalfxamount` = '$costprice', `fxtotamount` = '$costprice', `locationcode` = '$locationcode', `location` = '$locationname', `expense` = '$assetledger', `expensecode` = '$asset_ledger_id', `accdepreciation_ledger` = '$accdepreciation', `accdepreciation_code` = '$acc_depreciation_ledger_id'";
                            
                            $exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die ("Error in Query881" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            // Insert depreciation data
                            $depreciation_prefix = "DEP-";
                            $query2 = "select * from assets_depreciation order by auto_number desc limit 0, 1";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res2 = mysqli_fetch_array($exec2);
                            $billnumber_new = $res2["doc_number"];
                            
                            if ($billnumber_new == '') {
                                $billnumbercode = $depreciation_prefix . '1';
                            } else {
                                $billnumber_new = $res2["doc_number"];
                                $billnumbercode = substr($billnumber_new, 4, 8);
                                $billnumbercode = intval($billnumbercode);
                                $billnumbercode = $billnumbercode + 1;
                                $maxanum = $billnumbercode;
                                $billnumbercode = $depreciation_prefix . $maxanum;
                            }
                            
                            $depreciation_done_date = "2019-06-30";
                            $processmonth = "Jun-2019";
                            
                            $query66 = "SELECT auto_number FROM assets_depreciation WHERE asset_id = '$asset_id' AND processmonth = '$processmonth'";
                            $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $row66 = mysqli_num_rows($exec66);
                            
                            if ($row66 == 0) {
                                // Get asset details for depreciation entry
                                $query34 = "select * from assets_register where asset_id = '$asset_id'";
                                $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $asset_num = mysqli_num_rows($exec34);
                                $res34 = mysqli_fetch_array($exec34);
                                
                                // Extract all necessary fields from res34
                                $bill_autonumber = $res34['bill_autonumber'];
                                $itemname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res34['itemname']);
                                $itemcode = $res34['itemcode'];
                                $totalamount = $res34['totalamount'];
                                $entrydate = $res34['entrydate'];
                                $suppliercode = $res34['suppliercode'];
                                $suppliername = $res34['suppliername'];
                                $anum = $res34['auto_number'];
                                $asset_id = $res34['asset_id'];
                                $asset_category1 = $res34['asset_category'];
                                $asset_class = $res34['asset_class'];
                                $asset_department = $res34['asset_department'];
                                $asset_unit = $res34['asset_unit'];
                                $asset_period = $res34['asset_period'];
                                $startyear = $res34['startyear'];
                                $billnumber = $res34['billnumber'];
                                $companyanum = $res34['companyanum'];
                                
                                // Insert depreciation record
                                $query78 = "INSERT INTO `assets_depreciation`(`bill_autonumber`, `doc_number`, `companyanum`, `billnumber`, `categoryname`, `itemanum`, `itemcode`, `itemname`, `itemdescription`, `unit_abbreviation`, `rate`, `quantity`, `subtotal`, `free`, `itemtaxpercentage`, `itemtaxamount`, `discountpercentage`, `discountrupees`, `openingstock`, `closingstock`, `totalamount`, `coa`, `discountamount`, `recordstatus`, `username`, `ipaddress`, `entrydate`, `batchnumber`, `costprice`, `salesprice`, `expirydate`, `itemfreequantity`, `itemtotalquantity`, `packageanum`, `packagename`, `quantityperpackage`, `allpackagetotalquantity`, `manufactureranum`, `manufacturername`, `suppliername`, `suppliercode`, `supplieranum`, `supplierbillnumber`, `typeofpurchase`, `ponumber`, `itemstatus`, `locationcode`, `store`, `location`, `fifo_code`, `currency`, `fxrate`, `totalfxamount`, `deliverybillno`, `mrnno`, `fxpkrate`, `fxtotamount`, `assetledger`, `assetledgercode`, `assetledgeranum`, `priceperpk`, `fxamount`, `asset_id`, `asset_class`, `asset_category`, `dep_percent`, `asset_department`, `asset_unit`, `asset_period`, `startyear`, `depreciationledger`, `depreciationledgercode`, `accdepreciationledger`, `accdepreciationledgercode`, `accdepreciation`, `depreciation`, `processmonth`, `depreciation_date`) VALUES ('$bill_autonumber', '$billnumbercode', '$companyanum', '$billnumber', '$asset_category1', '$anum', '$itemcode', '$itemname', '', '', '$totalamount', '1', '$totalamount', '0', '0', '0', '0', '0', '0', '0', '$totalamount', '$asset_ledger_id', '0', '', '$username', '$ipaddress', '$updatedatetime', '', '$totalamount', '0', '', '0', '1', '0', '', '0', '0', '0', '', '$suppliername', '$suppliercode', '0', '', 'Manual', '', '', '$locationcode', '', '$locationname', '', '', '0', '$totalamount', '', '', '0', '$totalamount', '$assetledger', '$asset_ledger_id', '0', '0', '0', '$asset_id', '$asset_class', '$asset_category1', '$dep_percent', '$asset_department', '$asset_unit', '$asset_period', '$startyear', '$depreciation', '$depreciation_ledger_id', '$accdepreciation', '$acc_depreciation_ledger_id', '$depreciation_amount', '$depreciation_amount', '$processmonth', '$depreciation_done_date')";
                                
                                $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                $query66 = "DELETE FROM tb WHERE doc_number like 'FAP-%' and transaction_date = '" . $today_date . "' and from_table='purchase_details' ";
                                $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                            
                            $successCount++;
                            $uploadResults[] = [
                                'asset_name' => $asset_name,
                                'asset_id' => $asset_id,
                                'status' => 'success',
                                'message' => 'Asset uploaded successfully'
                            ];
                        } else {
                            $errorCount++;
                            $uploadResults[] = [
                                'asset_name' => $asset_name,
                                'asset_id' => $asset_id,
                                'status' => 'error',
                                'message' => 'Asset ID already exists'
                            ];
                        }
                    }
                }
            }
            
            // Clean up temporary file
            unlink($inputFileName);
            
            // Redirect with success message
            header("location:fixedasset_upload.php?st=success&success_count=" . $successCount . "&error_count=" . $errorCount);
            
        } catch(Exception $e) {
            header("location:fixedasset_upload.php?st=error&message=" . urlencode($e->getMessage()));
        }
    } else {
        header("location:fixedasset_upload.php?st=error&message=" . urlencode("No file uploaded"));
    }
}

// Handle status messages
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

$errmsg = "";
$successCount = 0;
$errorCount = 0;

if ($st == 'success') {
    $successCount = isset($_REQUEST['success_count']) ? $_REQUEST['success_count'] : 0;
    $errorCount = isset($_REQUEST['error_count']) ? $_REQUEST['error_count'] : 0;
    $errmsg = "File uploaded successfully! Assets imported: $successCount, Errors: $errorCount";
    $bgcolorcode = 'success';
} else if ($st == 'error') {
    $errorMessage = isset($_REQUEST['message']) ? $_REQUEST['message'] : 'Upload failed';
    $errmsg = "Upload failed: " . $errorMessage;
    $bgcolorcode = 'error';
} else if ($st == '2') {
    $errmsg = "Failed. New Bill Cannot Be Completed.";
    $bgcolorcode = 'failed';
}

if ($st == '1' && $banum != '') {
    $loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

// Helper function to get ledger name
function getLedgerName($ledgercode) {
    $accountname = "";
    $query61 = "select accountname from master_accountname where id= '$ledgercode'";
    $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res61 = mysqli_fetch_array($exec61);
    $accountname = $res61['accountname'];
    return $accountname;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Asset Upload - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/fixed-asset-upload-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date picker styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Scripts -->
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <link href="js/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
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
        <span>Fixed Asset Upload</span>
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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="assetregister.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Asset Register</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="fixedasset_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Fixed Asset Upload</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'error' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'error' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Fixed Asset Upload</h2>
                    <p>Upload Excel/CSV files to bulk import fixed assets into the system.</p>
                </div>
                <div class="page-header-actions">
                    <div class="location-display">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Location: <strong><?php echo htmlspecialchars($locationname); ?></strong></span>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="downloadTemplate()">
                        <i class="fas fa-download"></i> Download Template
                    </button>
                    <button type="button" class="btn btn-outline" onclick="viewInstructions()">
                        <i class="fas fa-question-circle"></i> Instructions
                    </button>
                </div>
            </div>

            <!-- Upload Form Section -->
            <div class="upload-form-section">
                <div class="upload-form-header">
                    <i class="fas fa-cloud-upload-alt upload-form-icon"></i>
                    <h3 class="upload-form-title">Bulk Asset Upload</h3>
                </div>
                
                <form name="cbform1" method="post" action="fixedasset_upload.php" enctype="multipart/form-data" class="upload-form" onSubmit="return validcheck()">
                    <!-- File Upload Area -->
                    <div class="file-upload-container">
                        <div class="file-upload-area" id="fileUploadArea">
                            <div class="file-upload-content">
                                <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                                <h4>Drop your Excel file here or click to browse</h4>
                                <p>Supported formats: .xlsx, .xls, .csv</p>
                                <div class="file-input-wrapper">
                                    <input type="file" name="upload_file" id="upload_file" accept=".xlsx,.xls,.csv" class="file-input">
                                    <label for="upload_file" class="file-input-label">
                                        <i class="fas fa-folder-open"></i> Choose File
                                    </label>
                                </div>
                            </div>
                            <div class="file-preview" id="filePreview" style="display: none;">
                                <div class="file-info">
                                    <i class="fas fa-file-excel file-icon"></i>
                                    <div class="file-details">
                                        <span class="file-name" id="fileName"></span>
                                        <span class="file-size" id="fileSize"></span>
                                    </div>
                                    <button type="button" class="remove-file-btn" id="removeFile">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Options -->
                    <div class="upload-options">
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="validateData" checked>
                                <span class="checkmark"></span>
                                Validate data before upload
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="skipDuplicates">
                                <span class="checkmark"></span>
                                Skip duplicate asset IDs
                            </label>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="locationcode" id="locationcode" value="<?php echo htmlspecialchars($locationcode); ?>">
                    <input type="hidden" name="locationname" id="locationname" value="<?php echo htmlspecialchars($locationname); ?>">
                    <input type="hidden" name="frmflag_upload" id="frmflag_upload" value="frmflag_upload">

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="uploadBtn">
                            <i class="fas fa-upload"></i> Upload Assets
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Instructions Section -->
            <div class="instructions-section">
                <div class="instructions-header">
                    <i class="fas fa-info-circle instructions-icon"></i>
                    <h3 class="instructions-title">Upload Instructions</h3>
                </div>
                
                <div class="instructions-content">
                    <div class="instruction-item">
                        <div class="instruction-number">1</div>
                        <div class="instruction-text">
                            <h4>Download Template</h4>
                            <p>Download the Excel template with the correct column structure.</p>
                        </div>
                    </div>
                    
                    <div class="instruction-item">
                        <div class="instruction-number">2</div>
                        <div class="instruction-text">
                            <h4>Fill Asset Data</h4>
                            <p>Complete all required fields including Asset ID, Name, Category, Department, and Cost.</p>
                        </div>
                    </div>
                    
                    <div class="instruction-item">
                        <div class="instruction-number">3</div>
                        <div class="instruction-text">
                            <h4>Upload File</h4>
                            <p>Select your completed Excel file and click Upload Assets to process.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Required Fields Section -->
            <div class="required-fields-section">
                <div class="required-fields-header">
                    <i class="fas fa-list-ul required-fields-icon"></i>
                    <h3 class="required-fields-title">Required Excel Columns</h3>
                </div>
                
                <div class="fields-grid">
                    <div class="field-item required">
                        <i class="fas fa-tag"></i>
                        <span>ASSET ID</span>
                    </div>
                    <div class="field-item required">
                        <i class="fas fa-file-signature"></i>
                        <span>ASSET NAMES</span>
                    </div>
                    <div class="field-item required">
                        <i class="fas fa-layer-group"></i>
                        <span>ASSET CATEGORY</span>
                    </div>
                    <div class="field-item required">
                        <i class="fas fa-building"></i>
                        <span>DEPARTMENT</span>
                    </div>
                    <div class="field-item required">
                        <i class="fas fa-dollar-sign"></i>
                        <span>COST</span>
                    </div>
                    <div class="field-item required">
                        <i class="fas fa-calendar-alt"></i>
                        <span>ACQUISITION DATE</span>
                    </div>
                    <div class="field-item required">
                        <i class="fas fa-clock"></i>
                        <span>LIFE</span>
                    </div>
                    <div class="field-item required">
                        <i class="fas fa-calendar-check"></i>
                        <span>DEPRECIATION START YEAR</span>
                    </div>
                    <div class="field-item optional">
                        <i class="fas fa-barcode"></i>
                        <span>SERIAL NUMBER</span>
                    </div>
                    <div class="field-item optional">
                        <i class="fas fa-truck"></i>
                        <span>SUPPLIER</span>
                    </div>
                    <div class="field-item optional">
                        <i class="fas fa-sitemap"></i>
                        <span>ASSET CATEGORY-SECTION</span>
                    </div>
                    <div class="field-item optional">
                        <i class="fas fa-id-card"></i>
                        <span>ASSET ID - FORMER</span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <h3>Processing Upload</h3>
            <p>Please be patient while we process your file...</p>
            <div class="loading-progress">
                <div class="progress-bar" id="progressBar"></div>
            </div>
        </div>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/fixed-asset-upload-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript functions -->
    <script type="text/javascript">
        function validcheck() {
            if (document.getElementById('upload_file').value == '') {
                alert('Select Excel/CSV file to Upload');
                return false;
            }
            
            var alert1 = confirm('Are you sure, Do you want to Save Data?');
            if (alert1 === true) {
                FuncPopup();
                document.cbform1.submit();
            }
            if (alert1 === false) {
                return false;
            }
        }
        
        function FuncPopup() {
            window.scrollTo(0, 0);
            document.getElementById("loadingOverlay").style.display = "block";
        }
        
        function downloadTemplate() {
            // TODO: Implement template download
            alert('Template download will be implemented soon');
        }
        
        function viewInstructions() {
            // TODO: Implement instructions modal
            alert('Instructions will be shown in a modal');
        }
    </script>
</body>
</html>
