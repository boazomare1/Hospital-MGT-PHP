<?php
// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");

session_start();

include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d H:i:s');

// Sanitize location input
$locationcode = isset($_REQUEST['location']) ? trim($_REQUEST['location']) : '';

// Validate location code
if (!empty($locationcode) && !preg_match('/^[a-zA-Z0-9_-]+$/', $locationcode)) {
    header("location:openingstockentry.php?st=invalid_location");
    exit();
}

// Get location details using prepared statement
if (!empty($locationcode)) {
    $query233 = "SELECT * FROM master_location WHERE locationcode = ?";
    $stmt233 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query233);
    if ($stmt233) {
        mysqli_stmt_bind_param($stmt233, "s", $locationcode);
        mysqli_stmt_execute($stmt233);
        $result233 = mysqli_stmt_get_result($stmt233);
        if ($result233 && $res233 = mysqli_fetch_array($result233)) {
            $location = $res233['locationname'];
        } else {
            $location = '';
        }
        mysqli_stmt_close($stmt233);
    } else {
        $location = '';
    }
} else {
    $location = '';
}

// Get employee details using prepared statement
$query23 = "SELECT * FROM master_employee WHERE username = ?";
$stmt23 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query23);
if ($stmt23) {
    mysqli_stmt_bind_param($stmt23, "s", $username);
    mysqli_stmt_execute($stmt23);
    $result23 = mysqli_stmt_get_result($stmt23);
    if ($result23 && $res23 = mysqli_fetch_array($result23)) {
        $res7locationanum = $res23['location'];
        $res7storeanum = $res23['store'];
    } else {
        $res7locationanum = '';
        $res7storeanum = '';
    }
    mysqli_stmt_close($stmt23);
} else {
    $res7locationanum = '';
    $res7storeanum = '';
}

// Get store details using prepared statement
if (!empty($res7storeanum)) {
    $query75 = "SELECT * FROM master_store WHERE auto_number = ?";
    $stmt75 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query75);
    if ($stmt75) {
        mysqli_stmt_bind_param($stmt75, "s", $res7storeanum);
        mysqli_stmt_execute($stmt75);
        $result75 = mysqli_stmt_get_result($stmt75);
        if ($result75 && $res75 = mysqli_fetch_array($result75)) {
            $store = $res75['store'];
        } else {
            $store = '';
        }
        mysqli_stmt_close($stmt75);
    } else {
        $store = '';
    }
} else {
    $store = '';
}

// Process form submission
if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
    // Start transaction for data integrity
    mysqli_autocommit($GLOBALS["___mysqli_ston"], FALSE);
    
    try {
        $billnumber = trim($_REQUEST['docnumber']);
        $serial = intval($_REQUEST['serialnumber']);
        $storecode = trim($_REQUEST['store']);
        
        // Validate inputs
        if (empty($billnumber) || $serial <= 0 || empty($storecode)) {
            throw new Exception("Invalid input data provided");
        }
        
        // Check stocktaking status
        include("store_stocktaking_chk1.php");
        if ($num_stocktaking > 0) {
            throw new Exception($stocktake_err);
        }
        
        $number = $serial - 1;
        $success_count = 0;
        $error_count = 0;
    
        for ($p = 1; $p <= $number; $p++) {
            $medicinename = isset($_REQUEST['medicinename'.$p]) ? trim($_REQUEST['medicinename'.$p]) : '';
            $medicinecode = isset($_REQUEST['medicinecode'.$p]) ? trim($_REQUEST['medicinecode'.$p]) : '';
            $salesrate = isset($_REQUEST['salesrate'.$p]) ? floatval($_REQUEST['salesrate'.$p]) : 0;
            $quantity = isset($_REQUEST['quantity'.$p]) ? intval($_REQUEST['quantity'.$p]) : 0;
            $batch = isset($_REQUEST['batch'.$p]) ? trim($_REQUEST['batch'.$p]) : '';
            $expirydate = isset($_REQUEST['expirydate'.$p]) ? trim($_REQUEST['expirydate'.$p]) : '';
            
            // Validate and sanitize medicine name
            if (empty($medicinename)) {
                $error_count++;
                continue;
            }
            
            // Remove potentially dangerous characters and limit length
            $medicinename = preg_replace('/[<>"\']/', '', $medicinename);
            $medicinename = substr($medicinename, 0, 100); // Limit to 100 characters
            
            if (empty($medicinename)) {
                $error_count++;
                continue;
            }
            
            // Validate other fields
            if (empty($medicinecode) || $salesrate <= 0 || $quantity <= 0 || empty($batch) || empty($expirydate)) {
                $error_count++;
                continue;
            }
            
            // Clean and sanitize batch number
            $batch = str_replace("", "", $batch);
            $batch = trim($batch);
            $batch = preg_replace('/[^a-zA-Z0-9\-_]/', '', $batch); // Only allow alphanumeric, hyphens, and underscores
            
            // Get item details using prepared statement
            $query23 = "SELECT * FROM master_itempharmacy WHERE itemcode = ?";
            $stmt23 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query23);
            if ($stmt23) {
                mysqli_stmt_bind_param($stmt23, "s", $medicinecode);
                mysqli_stmt_execute($stmt23);
                $result23 = mysqli_stmt_get_result($stmt23);
                if ($result23 && $res23 = mysqli_fetch_array($result23)) {
                    $categoryname = $res23['categoryname'];
                } else {
                    $error_count++;
                    continue;
                }
                mysqli_stmt_close($stmt23);
            } else {
                $error_count++;
                continue;
            }
            
            // Parse expiry date
            if (preg_match('/^(\d{2})\/(\d{2})$/', $expirydate, $matches)) {
                $expirymonth = $matches[1];
                $expiryyear = $matches[2];
                $expiryday = '01';
                $expirydate = '20'.$expiryyear.'-'.$expirymonth.'-'.$expiryday;
            } else {
                $error_count++;
                continue;
            }
            
            $itemsubtotal = $salesrate * $quantity;
            
            if (!empty($medicinename)) {
                // Get FIFO code using prepared statement
                $querystock2 = "SELECT fifo_code FROM transaction_stock WHERE docstatus='New Batch' ORDER BY auto_number DESC LIMIT 0, 1";
                $execstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querystock2) or die("Error in Query2: " . mysqli_error($GLOBALS["___mysqli_ston"]));
                $resstock2 = mysqli_fetch_array($execstock2);
                $fifo_code = $resstock2["fifo_code"];
                
                if (empty($fifo_code)) {
                    $fifo_code = '1';
                    
                    // Update cumulative stock status using prepared statement
                    $querycumstock2 = "UPDATE transaction_stock SET cum_stockstatus='0' WHERE itemcode=? AND locationcode=?";
                    $stmtcumstock2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $querycumstock2);
                    if ($stmtcumstock2) {
                        mysqli_stmt_bind_param($stmtcumstock2, "ss", $medicinecode, $locationcode);
                        mysqli_stmt_execute($stmtcumstock2);
                        mysqli_stmt_close($stmtcumstock2);
                    }
                    
                    // Insert stock transaction using prepared statement
                    $stockquery2 = "INSERT INTO transaction_stock (fifo_code,tablename,itemcode,itemname,transaction_date,transactionfunction,description,batchnumber,batch_quantity,transaction_quantity,cum_quantity,entrydocno,docstatus,cum_stockstatus,batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,expirydate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmtstock2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $stockquery2);
                    if ($stmtstock2) {
                        $tablename = 'purchase_details';
                        $transactionfunction = '1';
                        $description = 'OPENINGSTOCK';
                        $docstatus = 'New Batch';
                        $cum_stockstatus = '1';
                        $batch_stockstatus = '1';
                        $locationname = '';
                        $storename = '';
                        
                        mysqli_stmt_bind_param($stmtstock2, "ssssssssssssssssssssssssss", $fifo_code, $tablename, $medicinecode, $medicinename, $updatedatetime, $transactionfunction, $description, $batch, $quantity, $quantity, $quantity, $billnumber, $docstatus, $cum_stockstatus, $batch_stockstatus, $locationcode, $locationname, $store, $storename, $username, $ipaddress, $updatedatetime, $updatetime, $updatedate, $salesrate, $itemsubtotal, $expirydate);
                        if (mysqli_stmt_execute($stmtstock2)) {
                            $success_count++;
                        } else {
                            $error_count++;
                        }
                        mysqli_stmt_close($stmtstock2);
                    }
                } else {
                    // Get cumulative quantity using prepared statement
                    $querycumstock2 = "SELECT SUM(batch_quantity) as cum_quantity FROM transaction_stock WHERE batch_stockstatus='1' AND itemcode=? AND locationcode=?";
                    $stmtcumstock2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $querycumstock2);
                    if ($stmtcumstock2) {
                        mysqli_stmt_bind_param($stmtcumstock2, "ss", $medicinecode, $locationcode);
                        mysqli_stmt_execute($stmtcumstock2);
                        $resultcumstock2 = mysqli_stmt_get_result($stmtcumstock2);
                        if ($resultcumstock2 && $rescumstock2 = mysqli_fetch_array($resultcumstock2)) {
                            $cum_quantity = $rescumstock2["cum_quantity"];
                            $cum_quantity = $quantity + $cum_quantity;
                        } else {
                            $cum_quantity = $quantity;
                        }
                        mysqli_stmt_close($stmtcumstock2);
                    } else {
                        $cum_quantity = $quantity;
                    }
                    
                    $fifo_code = intval($fifo_code) + 1;
                    
                    // Update cumulative stock status using prepared statement
                    $queryupdatecumstock2 = "UPDATE transaction_stock SET cum_stockstatus='0' WHERE itemcode=? AND locationcode=?";
                    $stmtupdatecumstock2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $queryupdatecumstock2);
                    if ($stmtupdatecumstock2) {
                        mysqli_stmt_bind_param($stmtupdatecumstock2, "ss", $medicinecode, $locationcode);
                        mysqli_stmt_execute($stmtupdatecumstock2);
                        mysqli_stmt_close($stmtupdatecumstock2);
                    }
                    
                    // Insert stock transaction using prepared statement
                    $stockquery2 = "INSERT INTO transaction_stock (fifo_code,tablename,itemcode,itemname,transaction_date,transactionfunction,description,batchnumber,batch_quantity,transaction_quantity,cum_quantity,entrydocno,docstatus,cum_stockstatus,batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,expirydate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmtstock2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $stockquery2);
                    if ($stmtstock2) {
                        $tablename2 = 'purchase_details';
                        $transactionfunction2 = '1';
                        $description2 = 'OPENINGSTOCK';
                        $docstatus2 = 'New Batch';
                        $cum_stockstatus2 = '1';
                        $batch_stockstatus2 = '1';
                        $locationname2 = '';
                        $storename2 = '';
                        
                        mysqli_stmt_bind_param($stmtstock2, "ssssssssssssssssssssssssss", $fifo_code, $tablename2, $medicinecode, $medicinename, $updatedatetime, $transactionfunction2, $description2, $batch, $quantity, $quantity, $cum_quantity, $billnumber, $docstatus2, $cum_stockstatus2, $batch_stockstatus2, $locationcode, $locationname2, $store, $storename2, $username, $ipaddress, $updatedatetime, $updatetime, $updatedate, $salesrate, $itemsubtotal, $expirydate);
                        if (mysqli_stmt_execute($stmtstock2)) {
                            $success_count++;
                        } else {
                            $error_count++;
                        }
                        mysqli_stmt_close($stmtstock2);
                    }
                }
                
                // Insert purchase details using prepared statement
                $medicinequery1 = "INSERT INTO purchase_details (itemcode,itemname,entrydate,suppliername,suppliercode,quantity,allpackagetotalquantity,totalamount,username,ipaddress,rate,subtotal,companyanum,batchnumber,expirydate,location,locationcode,store,billnumber,categoryname,fifo_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmtmedicine1 = mysqli_prepare($GLOBALS["___mysqli_ston"], $medicinequery1);
                if ($stmtmedicine1) {
                    $suppliername = 'OPENINGSTOCK';
                    $suppliercode = 'OPSE-1';
                    
                    mysqli_stmt_bind_param($stmtmedicine1, "ssssssssssssssssssss", $medicinecode, $medicinename, $updatedatetime, $suppliername, $suppliercode, $quantity, $quantity, $itemsubtotal, $username, $ipaddress, $salesrate, $itemsubtotal, $companyanum, $batch, $expirydate, $location, $locationcode, $store, $billnumber, $categoryname, $fifo_code);
                    if (mysqli_stmt_execute($stmtmedicine1)) {
                        $success_count++;
                    } else {
                        $error_count++;
                    }
                    mysqli_stmt_close($stmtmedicine1);
                }
                
                // Insert opening stock entry using prepared statement
                $medicinequery2 = "INSERT INTO openingstock_entry (itemcode,itemname,transactiondate,transactionmodule,transactionparticular,billnumber,quantity,username,ipaddress,rateperunit,totalrate,companyanum,companyname,batchnumber,expirydate,store,location,locationcode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmtmedicine2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $medicinequery2);
                if ($stmtmedicine2) {
                    $transactionmodule = 'OPENINGSTOCK';
                    $transactionparticular = 'BY STOCK ADD';
                    
                    mysqli_stmt_bind_param($stmtmedicine2, "ssssssssssssssssss", $medicinecode, $medicinename, $updatedatetime, $transactionmodule, $transactionparticular, $billnumber, $quantity, $username, $ipaddress, $salesrate, $itemsubtotal, $companyanum, $companyname, $batch, $expirydate, $store, $location, $locationcode);
                    if (mysqli_stmt_execute($stmtmedicine2)) {
                        $success_count++;
                    } else {
                        $error_count++;
                    }
                    mysqli_stmt_close($stmtmedicine2);
                }
            }
        }
        
        // Commit transaction if all operations successful
        if ($error_count == 0) {
            mysqli_commit($GLOBALS["___mysqli_ston"]);
            mysqli_autocommit($GLOBALS["___mysqli_ston"], TRUE);
            header("location:openingstockentry.php?st=success&count=" . $success_count);
        } else {
            // Rollback transaction if there were errors
            mysqli_rollback($GLOBALS["___mysqli_ston"]);
            mysqli_autocommit($GLOBALS["___mysqli_ston"], TRUE);
            header("location:openingstockentry.php?st=partial&success=" . $success_count . "&errors=" . $error_count);
        }
        exit();
        
    } catch (Exception $e) {
        // Rollback transaction on any exception
        mysqli_rollback($GLOBALS["___mysqli_ston"]);
        mysqli_autocommit($GLOBALS["___mysqli_ston"], TRUE);
        
        // Log error for debugging
        error_log("Opening stock entry error: " . $e->getMessage() . " for user: " . $username . " at " . date('Y-m-d H:i:s'));
        
        if (strpos($e->getMessage(), 'Stock Take in process') !== false) {
            echo "<script>alert('".addslashes($e->getMessage())."');history.back();</script>";
        } else {
            header("location:openingstockentry.php?st=error&message=" . urlencode($e->getMessage()));
        }
        exit();
    }
}

// Get company details using prepared statement
$query3 = "SELECT * FROM master_company WHERE companystatus = 'Active'";
$stmt3 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query3);
if ($stmt3) {
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    if ($result3) {
        $res3 = mysqli_fetch_array($result3);
    } else {
        $res3 = array();
    }
    mysqli_stmt_close($stmt3);
} else {
    $res3 = array();
}

$paynowbillprefix = 'OPS-';
$paynowbillprefix1 = strlen($paynowbillprefix);

// Get last bill number using prepared statement
$query2 = "SELECT * FROM openingstock_entry WHERE billnumber LIKE ? ORDER BY auto_number DESC LIMIT 0, 1";
$stmt2 = mysqli_prepare($GLOBALS["___mysqli_ston"], $query2);
if ($stmt2) {
    $like_pattern = '%OPS-%';
    mysqli_stmt_bind_param($stmt2, "s", $like_pattern);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    if ($result2 && $res2 = mysqli_fetch_array($result2)) {
        $billnumber = $res2["billnumber"];
    } else {
        $billnumber = '';
    }
    mysqli_stmt_close($stmt2);
} else {
    $billnumber = '';
}

$billdigit = strlen($billnumber);

if (empty($billnumber)) {
    $billnumbercode = 'OPS-1';
    $openingbalance = '0.00';
} else {
    $billnumbercode = substr($billnumber, $paynowbillprefix1, $billdigit);
    $billnumbercode = intval($billnumbercode);
    $billnumbercode = $billnumbercode + 1;
    $maxanum = $billnumbercode;
    $billnumbercode = 'OPS-' . $maxanum;
    $openingbalance = '0.00';
}

// Display status messages
$status_message = '';
$status_type = '';
if (isset($_GET['st'])) {
    switch ($_GET['st']) {
        case 'success':
            $count = isset($_GET['count']) ? intval($_GET['count']) : 0;
            $status_message = 'Successfully added ' . $count . ' items to opening stock.';
            $status_type = 'success';
            break;
        case 'partial':
            $success = isset($_GET['success']) ? intval($_GET['success']) : 0;
            $errors = isset($_GET['errors']) ? intval($_GET['errors']) : 0;
            $status_message = 'Partially successful: ' . $success . ' items added, ' . $errors . ' errors occurred.';
            $status_type = 'warning';
            break;
        case 'invalid_input':
            $status_message = 'Invalid input data provided.';
            $status_type = 'error';
            break;
        case 'invalid_location':
            $status_message = 'Invalid location code provided.';
            $status_type = 'error';
            break;
        case 'error':
            $message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'An error occurred';
            $status_message = 'Error: ' . $message;
            $status_type = 'error';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opening Stock Entry - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/openingstock-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Include existing scripts -->
    <?php include("autocompletebuild_stockmedicine.php"); ?>
    <script type="text/javascript" src="js/autosuggeststockmedicine1.js"></script>
    <?php include("js/dropdownlist1scriptingstockmedicine.php"); ?>
    <script type="text/javascript" src="js/autocomplete_stockmedicine.js"></script>
    <script type="text/javascript" src="js/insertnewitem41.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
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
        <span>Opening Stock Entry</span>
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
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="openingstockentry.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Opening Stock Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockintake.php" class="nav-link">
                            <i class="fas fa-arrow-down"></i>
                            <span>Stock Intake</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockadjustment.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Stock Adjustment</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbydate1.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Stock Reports</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($status_message)): ?>
                    <div class="alert alert-<?php echo $status_type; ?>">
                        <i class="fas fa-<?php echo $status_type === 'success' ? 'check-circle' : ($status_type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($status_message); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Opening Stock Entry</h2>
                    <p>Add new items to opening stock with batch tracking and expiry date management.</p>
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

            <!-- Main Form Section -->
            <div class="main-form-section">
                <div class="main-form-header">
                    <i class="fas fa-plus-circle main-form-icon"></i>
                    <h3 class="main-form-title">Opening Stock Entry Form</h3>
                </div>
                
                <form name="cbform1" method="post" action="openingstockentry.php" onSubmit="return validcheck()" class="main-form">
                    <!-- Document Information -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-file-alt"></i>
                            Document Information
                        </h4>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="date" class="form-label">Date</label>
                                <input type="text" name="date" id="date" class="form-input" 
                                       value="<?php echo $updatedatetime; ?>" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label for="docnumber" class="form-label">Document Number</label>
                                <input type="text" name="docnumber" id="docnumber" class="form-input" 
                                       value="<?php echo $billnumbercode; ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Location and Store Selection -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-map-marker-alt"></i>
                            Location & Store
                        </h4>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="location" class="form-label">Location <span class="required">*</span></label>
                                <select name="location" id="location" class="form-input" onChange="storefunction(this.value);">
                                    <option value="">-Select Location-</option>
                                    <?php
                                    // Get location details using prepared statement
                                    $query = "SELECT * FROM login_locationdetails WHERE username=? AND docno=? GROUP BY locationname ORDER BY locationname";
                                    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);
                                    if ($stmt) {
                                        mysqli_stmt_bind_param($stmt, "ss", $username, $docno);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        if ($result) {
                                            while ($res = mysqli_fetch_array($result)) {
                                                $reslocation = $res["locationname"];
                                                $reslocationanum = $res["locationcode"];
                                                $selected = (!empty($location) && $location == $reslocationanum) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo htmlspecialchars($reslocationanum); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($reslocation); ?></option>
                                                <?php 
                                            }
                                        }
                                        mysqli_stmt_close($stmt);
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="store" class="form-label">Store <span class="required">*</span></label>
                                <select name="store" id="store" class="form-input" onChange="storechk(this.value);">
                                    <option value="">-Select Store-</option>
                                </select>
                            </div>
                        </div>
                        
                        <input type="hidden" name="locationnamenew" value="<?php echo isset($location) ? htmlspecialchars($location) : ''; ?>">
                        <input type="hidden" name="locationcodenew" value="<?php echo isset($locationcode) ? htmlspecialchars($locationcode) : ''; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                    </div>

                    <!-- Item Entry Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-pills"></i>
                            Item Entry
                        </h4>
                        
                        <div class="item-entry-table">
                            <div class="item-entry-header">
                                <div class="item-entry-row">
                                    <div class="item-entry-cell header">Medicine Name</div>
                                    <div class="item-entry-cell header">Cost Price</div>
                                    <div class="item-entry-cell header">Quantity</div>
                                    <div class="item-entry-cell header">Batch</div>
                                    <div class="item-entry-cell header">Expiry Date</div>
                                    <div class="item-entry-cell header">Action</div>
                                </div>
                            </div>
                            
                            <div class="item-entry-body" id="insertrow">
                                <!-- Dynamic items will be inserted here -->
                            </div>
                            
                            <div class="item-entry-row">
                                <div class="item-entry-cell">
                                    <input name="medicinename" type="text" id="medicinename" class="form-input" 
                                           placeholder="Enter medicine name" autocomplete="off" 
                                           onKeyDown="return StateSuggestionspharm4()" 
                                           onKeyUp="return funcCustomerDropDownSearch4()" required>
                                </div>
                                <div class="item-entry-cell">
                                    <input name="salesrate" type="text" id="salesrate" class="form-input" 
                                           placeholder="Cost price" readonly>
                                </div>
                                <div class="item-entry-cell">
                                    <input name="quantity" type="text" id="quantity" class="form-input" 
                                           placeholder="Quantity" onchange="validateNumeric(this, 1)" required>
                                </div>
                                <div class="item-entry-cell">
                                    <input name="batch" type="text" id="batch" class="form-input" 
                                           placeholder="Batch number" required>
                                </div>
                                <div class="item-entry-cell">
                                    <input name="expirydate" type="text" id="expirydate" class="form-input" 
                                           placeholder="MM/YY" onchange="validateExpiryDate(this)" required>
                                </div>
                                <div class="item-entry-cell">
                                    <button type="button" name="Add" id="Add" class="btn btn-primary" 
                                            onClick="return insertitem10()">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="serialnumber" id="serialnumber" value="1">
                        <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <input type="hidden" name="codevalue" id="codevalue" value="0">
                        <input type="hidden" name="h" id="h" value="0">
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-success" id="savebutton">
                            <i class="fas fa-save"></i> Save Opening Stock
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="button" class="btn btn-outline" onclick="clearAllItems()">
                            <i class="fas fa-trash"></i> Clear All Items
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/openingstock-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Include existing scripts -->
    <script src="js/datetimepicker_css.js"></script>
</body>
</html>



