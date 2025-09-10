<?php
session_start();
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
$colorloopcount = "";
$dummy = '';
$costcenteridsdb = array();

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1') {
    $accountname = $_REQUEST["accountname"];
    $accountname = strtoupper($accountname);
    $accountname = trim($accountname);
    $length = strlen($accountname);
    
    $expirydate = $_REQUEST['expirydate'];
    $recordstatus = $_REQUEST['recordstatus'];
    $address = $_REQUEST['address'];
    $accountsmaintype = $_REQUEST['accountsmaintype'];
    $accountssub = $_REQUEST['accountssub'];
    $paymenttype = '';
    $subtype = '';
    $misreport = 0;
    
    if($accountssub == '2') {
        $paymenttype = $_REQUEST['paymenttype'];
    }
    
    $openingbalancecredit = $_REQUEST['openingbalancecredit'];
    $openingbalancedebit = $_REQUEST['openingbalancedebit'];
    
    if(isset($_REQUEST['is_receivable'])) {
        $is_receivable = $_REQUEST['is_receivable'];
    } else {
        $is_receivable = '';
    }
    
    $id = $_REQUEST['id'];
    $contact = $_REQUEST['contact'];
    $phone = trim($_REQUEST['phone']);
    $locationcode = $_REQUEST['location'];
    $currency = $_REQUEST['currency'];
    $fxrate = $_REQUEST['fxrate'];
    
    if(isset($_REQUEST['grnbackdate'])) {
        $grnbackdate = $_REQUEST['grnbackdate'];
    } else {
        $grnbackdate = '';
    }
    
    if(isset($_REQUEST['iscapitation'])) {
        $iscapitation = $_REQUEST['iscapitation'];
        $capitationservicename = $_REQUEST['capitationservicename'];
        $capitationservicecode = $_REQUEST['capitationservicecode'];
    } else {
        $iscapitation = '';
        $capitationservicename = '';
        $capitationservicecode = '';
    }
    
    if($accountsmaintype == '' || $accountssub == '') {
        $errmsg = "Failed. Account Main and Account Sub Not selected properly.";
        $bgcolorcode = 'failed';
    } else {
        $query8 = "select * from master_location where locationcode = '$locationcode'";
        $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res8 = mysqli_fetch_array($exec8);
        $locationname = $res8['locationname'];
        $cc_name = "";
        
        if ($length <= 100) {
            $query2 = "select * from master_accountname where (accountname = '$accountname' or id = '$id')";
            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res2 = mysqli_num_rows($exec2);
            
            if ($res2 == 0) {
                if($accountssub == '2') {
                    $currency = "KSHS";
                    $fxrate = '1';
                    $query_su = "insert into master_subtype (maintype, subtype, subtype_ledger, ipaddress, recorddate, username, currency, fxrate) 
                    values ('$paymenttype', '$accountname', '$id', '$ipaddress', '$updatedatetime', '$username', '".$currency."', '".$fxrate."')";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_su) or die ("Error in query_su".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    $query21 = "select auto_number from master_subtype where subtype_ledger='$id'";
                    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res21 = mysqli_fetch_array($exec21);
                    $subtype = $res21['auto_number'];
                }
                
                $query1 = "insert into master_accountname (accountname, recordstatus, paymenttype, subtype, expirydate, ipaddress, recorddate, username, address, accountsmain, accountssub, misreport, openingbalancecredit, openingbalancedebit, id, contact, locationcode, locationname, currency, fxrate, iscapitation, serviceitemcode, phone, is_receivable, cost_center, grn_backdate) 
                values ('$accountname', '$recordstatus', '$paymenttype', '$subtype', '$expirydate', '$ipaddress', '$updatedatetime', '$username', '$address', '$accountsmaintype', '$accountssub', '$misreport', '$openingbalancecredit', '$openingbalancedebit', '$id', '$contact', '$locationcode', '$locationname', '$currency', '$fxrate', '$iscapitation', '$capitationservicecode', '$phone', '$is_receivable', '$cc_name', '$grnbackdate')";
                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                $errmsg = "Success. New Account Name Updated.";
                $bgcolorcode = 'success';
                
                if($accountssub == '2') {
                    $query22 = "select auto_number from master_accountname where id='$id'";
                    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res22 = mysqli_fetch_array($exec22);
                    $ledgeranum = $res22['auto_number'];
                    
                    $query1 = "update master_subtype set ledger_anum = '$ledgeranum' where auto_number = '$subtype'";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            } else {
                $errmsg = "Failed. Account Name or ID Already Exists.";
                $bgcolorcode = 'failed';
            }
        } else {
            $errmsg = "Failed. Only 100 Characters Are Allowed.";
            $bgcolorcode = 'failed';
        }
    }
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_accountname set recordstatus = 'DELETED' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_accountname set recordstatus = 'ACTIVE' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default') {
    $delanum = $_REQUEST["anum"];
    $query4 = "update master_accountname set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $query5 = "update master_accountname set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault') {
    $delanum = $_REQUEST["anum"];
    $query6 = "update master_accountname set defaultstatus = '' where auto_number = '$delanum'";
    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry') {
    $errmsg = "Please Add Account Name To Proceed For Billing.";
    $bgcolorcode = 'failed';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account Name - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addaccountname1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker Styles -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- External JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/autoaccountanumsearch.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
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
        <span>Account Management</span>
        <span>→</span>
        <span>Add Account Name</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Account Name Master</h2>
                <p>Add new account names and manage chart of accounts for billing and financial management.</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if ($errmsg != "") { ?>
        <div class="alert alert-<?php echo ($bgcolorcode == 'success') ? 'success' : (($bgcolorcode == 'failed') ? 'error' : 'info'); ?>">
            <i class="fas fa-<?php echo ($bgcolorcode == 'success') ? 'check-circle' : (($bgcolorcode == 'failed') ? 'exclamation-triangle' : 'info-circle'); ?>"></i>
            <span><?php echo htmlspecialchars($errmsg); ?></span>
        </div>
        <?php } ?>

        <!-- Add New Account Form -->
        <div class="form-section">
            <div class="form-section-header">
                <i class="fas fa-plus-circle form-section-icon"></i>
                <h3 class="form-section-title">Add New Account</h3>
            </div>
            
            <form name="form1" id="form1" method="post" action="addaccountname1.php" onSubmit="return Process()">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="location" class="form-label">Select Location *</label>
                        <select name="location" id="location" class="form-select" required>
                            <option value="">Select Location</option>
                            <?php
                            $query50 = "select * from master_location where status <> 'deleted' order by locationname";
                            $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die ("Error in Query50".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res50 = mysqli_fetch_array($exec50)) {
                                $locationname = $res50["locationname"];
                                $locationcode = $res50["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode; ?>"><?php echo htmlspecialchars($locationname); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="accountsmaintype" class="form-label">Account Main Type *</label>
                        <select name="accountsmaintype" id="accountsmaintype" class="form-select" onChange="return funcAccountsMainTypeChange1()" required>
                            <option value="">Select Type</option>
                            <?php
                            $query5 = "select * from master_accountsmain where recordstatus = '' order by accountsmain";
                            $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res5 = mysqli_fetch_array($exec5)) {
                                $res5accountsmainanum = $res5["auto_number"];
                                $res5accountsmain = $res5["accountsmain"];
                                ?>
                                <option value="<?php echo $res5accountsmainanum; ?>"><?php echo htmlspecialchars($res5accountsmain); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="accountssub" class="form-label">Account Sub Type *</label>
                        <select name="accountssub" id="accountssub" class="form-select" onChange="return accountsearchanum()" required>
                            <option value="">Select Sub Type</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="paymenttype" class="form-label">Main Type</label>
                        <select name="paymenttype" id="paymenttype" class="form-select" onChange="return funcPaymentTypeChange1()">
                            <option value="">Select Type</option>
                            <?php
                            $query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
                            $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res5 = mysqli_fetch_array($exec5)) {
                                $res5anum = $res5["auto_number"];
                                $res5paymenttype = $res5["paymenttype"];
                                ?>
                                <option value="<?php echo $res5anum; ?>"><?php echo htmlspecialchars($res5paymenttype); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id" class="form-label">ID *</label>
                        <input name="id" id="id" class="form-input" style="text-transform:uppercase" readonly required />
                    </div>

                    <div class="form-group">
                        <label for="accountname" class="form-label">Account Name *</label>
                        <input name="accountname" id="accountname" class="form-input" style="text-transform:uppercase" required />
                    </div>

                    <div class="form-group">
                        <label for="recordstatus" class="form-label">Account Status</label>
                        <select name="recordstatus" id="recordstatus" class="form-select" style="text-transform:uppercase">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="DELETED">INACTIVE</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="currency" class="form-label">Currency *</label>
                        <select name="currency" id="currency" class="form-select" required>
                            <option value="KSH" selected>Kshs</option>
                            <?php 
                            $query10 = "select * from master_currency where recordstatus != 'deleted'";
                            $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res10 = mysqli_fetch_array($exec10)) {
                                $currencyid = $res10['auto_number'];
                                $currency = $res10['currency'];
                                ?>
                                <option value="<?php echo $currency; ?>"><?php echo htmlspecialchars($currency); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="expirydate" class="form-label">Account Validity End</label>
                        <input type="text" name="expirydate" id="expirydate" class="form-input" value="<?php echo date('Y-m-d'); ?>" onFocus="return funcexpiry();" readonly />
                    </div>

                    <div class="form-group">
                        <label for="fxrate" class="form-label">FX Rate *</label>
                        <input type="text" name="fxrate" id="fxrate" class="form-input" value="1.00" style="text-transform:uppercase" required />
                    </div>

                    <div class="form-group">
                        <label for="openingbalancedebit" class="form-label">Opening Balance Debit</label>
                        <input type="text" name="openingbalancedebit" id="openingbalancedebit" class="form-input" />
                    </div>

                    <div class="form-group">
                        <label for="openingbalancecredit" class="form-label">Opening Balance Credit</label>
                        <input type="text" name="openingbalancecredit" id="openingbalancecredit" class="form-input" />
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-textarea" style="text-transform:uppercase" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-input" style="text-transform:uppercase" />
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-input" style="text-transform:uppercase" />
                    </div>
                </div>

                <!-- Cost Center Section -->
                <div id="non_multicc">
                    <div class="form-group">
                        <label class="form-label">Cost Centers</label>
                        <div class="cost-center-grid">
                            <?php
                            $i = 0;
                            $j = 0;
                            $ccchk = '';
                            $query5 = "select * from master_costcenter where recordstatus <> 'deleted' order by name";
                            $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res5 = mysqli_fetch_array($exec5)) {
                                $ccid = $res5["auto_number"];
                                $ccname = $res5["name"];
                                $i = $i + 1;
                                $j = $j + 1;
                                if(in_array($ccid, $costcenteridsdb)) {
                                    $ccchk = "checked";
                                } else {
                                    $ccchk = "";
                                }
                                ?>
                                <div class="cost-center-item">
                                    <input type="checkbox" name="costcenter[]" id="costcenter<?= $j; ?>" <?php echo $ccchk; ?> value="<?php echo $ccid; ?>">
                                    <label for="costcenter<?= $j; ?>"><?php echo htmlspecialchars($ccname); ?></label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Capitation Section -->
                <div class="form-group">
                    <div class="form-checkbox">
                        <input type="checkbox" name="iscapitation" id="iscapitation" value="1" onClick="displayService()">
                        <label for="iscapitation">Is Capitation</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="capitationservice" class="form-label" id="servtext" style="display: none;">Select Service</label>
                    <input type="text" name="capitationservice" id="capitationservice" class="form-input" style="display: none;" />
                    <input type="hidden" name="capitationservicecode" id="capitationservicecode" />
                    <input type="hidden" name="capitationservicename" id="capitationservicename" />
                </div>

                <!-- Additional Options -->
                <div class="form-group">
                    <div class="form-checkbox">
                        <input type="checkbox" name="is_receivable" id="is_receivable" value="1">
                        <label for="is_receivable">Is Receivable</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-checkbox">
                        <input type="checkbox" name="grnbackdate" id="grnbackdate" value="1">
                        <label for="grnbackdate">GRN Back Date</label>
                    </div>
                </div>

                <div class="form-actions">
                    <input type="hidden" name="frmflag" value="addnew" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input type="hidden" name="scrollfunc" id="scrollfunc" value="getdata">
                    <input type="hidden" name="serialno" id="serialno" value="50">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Chart of Accounts Search -->
        <div class="form-section">
            <div class="form-section-header">
                <i class="fas fa-search form-section-icon"></i>
                <h3 class="form-section-title">Chart of Accounts - Search</h3>
            </div>
            
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-filter search-icon"></i>
                    <h4 class="search-title">Search Accounts</h4>
                </div>
                
                <div class="search-controls">
                    <input type="text" id="accountsearch" name="accountsearch" class="search-input" placeholder="Account Search" />
                    <input type="hidden" id="hiddenaccountsearch" name="hiddenaccountsearch" value="">
                    
                    <select name="accountsmaintype1" id="accountsmaintype1" class="search-select" onChange="return funcAccountsMainTypeChange()">
                        <option value="">Select Main Type</option>
                        <?php
                        $query5 = "select * from master_accountsmain where recordstatus = '' order by id";
                        $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res5 = mysqli_fetch_array($exec5)) {
                            $res5accountsmainanum = $res5["auto_number"];
                            $res5accountsmain = $res5["accountsmain"];
                            ?>
                            <option value="<?php echo $res5accountsmainanum; ?>"><?php echo htmlspecialchars($res5accountsmain); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    
                    <select name="accountssub1" id="accountssub1" class="search-select">
                        <option value="">Select Sub Type</option>
                    </select>
                    
                    <button type="button" id="accountsearchbutton" name="accountsearchbutton" class="search-button" onClick="return funcaccountsearch();">
                        <i class="fas fa-search"></i> Search
                    </button>
                    
                    <button type="button" class="export-button" onClick="return xcelcreation()">
                        <i class="fas fa-file-excel"></i>
                    </button>
                </div>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Accounts Main</th>
                        <th>Code</th>
                        <th>Accounts Sub</th>
                        <th>ID</th>
                        <th>Account Name</th>
                        <th>Main Type</th>
                        <th>Sub Type</th>
                        <th>Cost Center</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id='insertchartofaccounts'>
                    <!-- Search results will be inserted here via AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Deleted Accounts -->
        <div class="form-section">
            <div class="form-section-header">
                <i class="fas fa-trash form-section-icon"></i>
                <h3 class="form-section-title">Deleted Accounts</h3>
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Main Type</th>
                        <th>Account Name</th>
                        <th>Sub Type</th>
                        <th>Expiry Date</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query1 = "select * from master_accountname where recordstatus = 'deleted' order by paymenttype ";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while ($res1 = mysqli_fetch_array($exec1)) {
                        $accountname = $res1["accountname"];
                        $auto_number = $res1["auto_number"];
                        $paymenttypeanum = $res1['paymenttype'];
                        $subtypeanum = $res1['subtype'];
                        $expirydate = $res1['expirydate'];
                        
                        $query2 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res2 = mysqli_fetch_array($exec2);
                        $paymenttype = $res2['paymenttype'];
                        
                        $query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
                        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res3 = mysqli_fetch_array($exec3);
                        $subtype = $res3['subtype'];
                        
                        $colorloopcount = $colorloopcount + 1;
                        $showcolor = ($colorloopcount & 1); 
                        $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                    ?>
                    <tr class="<?php echo $rowclass; ?>">
                        <td class="modern-cell">
                            <a href="addaccountname1.php?st=activate&anum=<?php echo $auto_number; ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-check"></i> Activate
                            </a>
                        </td>
                        <td class="modern-cell"><?php echo htmlspecialchars($paymenttype); ?></td>
                        <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                        <td class="modern-cell"><?php echo htmlspecialchars($subtype); ?></td>
                        <td class="modern-cell"><?php echo $expirydate; ?></td>
                        <td class="modern-cell">
                            <a href="editaccountname1.php?st=edit&anum=<?php echo $auto_number; ?>" class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/addaccountname1-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- PHP Generated JavaScript Functions -->
    <script language="javascript">
    function funcPaymentTypeChange1() {
        <?php 
        $query12 = "select * from master_paymenttype where recordstatus = ''";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res12 = mysqli_fetch_array($exec12)) {
            $res12paymenttypeanum = $res12["auto_number"];
            $res12paymenttype = $res12["paymenttype"];
            ?>
            if(document.getElementById("paymenttype").value=="<?php echo $res12paymenttypeanum; ?>") {
                document.getElementById("subtype").options.length=null; 
                var combo = document.getElementById('subtype'); 	
                <?php 
                $loopcount=0;
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
                <?php
                $query10 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = ''";
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res10 = mysqli_fetch_array($exec10)) {
                    $loopcount = $loopcount+1;
                    $res10subtypeanum = $res10['auto_number'];
                    $res10subtype = $res10["subtype"];
                    ?>
                    combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10subtype;?>", "<?php echo $res10subtypeanum;?>"); 
                    <?php 
                }
                ?>
            }
            <?php
        }
        ?>	
    }
    
    function funcAccountsMainTypeChange1() {
        <?php 
        $query12 = "select * from master_accountsmain where recordstatus = ''";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res12 = mysqli_fetch_array($exec12)) {
            $res12accountsmainanum = $res12["auto_number"];
            $res12accountsmain = $res12["accountsmain"];
            ?>
            if(document.getElementById("accountsmaintype").value=="<?php echo $res12accountsmainanum; ?>") {
                document.getElementById("accountssub").options.length=null; 
                var combo = document.getElementById('accountssub'); 	
                <?php 
                $loopcount=0;
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
                <?php
                $query10 = "select * from master_accountssub where accountsmain = '$res12accountsmainanum' and recordstatus = ''";
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res10 = mysqli_fetch_array($exec10)) {
                    $loopcount = $loopcount+1;
                    $res10accountssubanum = $res10['auto_number'];
                    $res10accountssub = $res10["accountssub"];
                    ?>
                    combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountssub;?>", "<?php echo $res10accountssubanum;?>"); 
                    <?php 
                }
                ?>
            }
            <?php
        }
        ?>	
        
        if(document.getElementById("accountsmaintype").value == 6) {
            $('#non_multicc').hide();
            $('#multicc').show();
        } else {
            $('#non_multicc').show();
            $('#multicc').hide();
        }
    }
    
    function funcAccountsMainTypeChange() {
        <?php 
        $query12 = "select * from master_accountsmain where recordstatus = ''";
        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res12 = mysqli_fetch_array($exec12)) {
            $res12accountsmainanum = $res12["auto_number"];
            $res12accountsmain = $res12["accountsmain"];
            ?>
            if(document.getElementById("accountsmaintype1").value=="<?php echo $res12accountsmainanum; ?>") {
                document.getElementById("accountssub1").options.length=null; 
                var combo = document.getElementById('accountssub1'); 	
                <?php 
                $loopcount=0;
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
                <?php
                $query10 = "select * from master_accountssub where accountsmain = '$res12accountsmainanum' and recordstatus = ''";
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res10 = mysqli_fetch_array($exec10)) {
                    $loopcount = $loopcount+1;
                    $res10accountssubanum = $res10['auto_number'];
                    $res10accountssub = $res10["accountssub"];
                    ?>
                    combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountssub;?>", "<?php echo $res10accountssubanum;?>"); 
                    <?php 
                }
                ?>
            }
            <?php
        }
        ?>	
    }
    
    function SelCurrency(val) {
        var val = val;
        <?php 
        $query1sub = "select * from master_subtype where recordstatus = ''";
        $exec1sub = mysqli_query($GLOBALS["___mysqli_ston"], $query1sub) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($res1sub = mysqli_fetch_array($exec1sub)) {
            $res1subanum = $res1sub["auto_number"];
            $res1subcurrency = $res1sub["currency"];
            $res1subfxrate = $res1sub["fxrate"];
            ?>
            if(val =="<?php echo $res1subanum; ?>") {
                document.getElementById("currency").value = "<?php echo $res1subcurrency; ?>";
                document.getElementById("fxrate").value = "<?php echo $res1subfxrate; ?>";
            }
            <?php
        }
        ?>
    }
    </script>
    
    <!-- Autocomplete Scripts -->
    <script type="text/javascript">
    $(document).ready(function(e) {
        $('#capitationservice').autocomplete({
            source:"autosearchservices.php",
            matchContains: true,
            minLength:1,
            html: true, 
            select: function(event,ui){
                var itemname=ui.item.itemname;
                var itemcode=ui.item.itemcode;
                $("#capitationservicecode").val(itemcode);
                $("#capitationservicename").val(itemname);
            },
        });	
    });

    $(function() {
        $('#accountsearch').autocomplete({
            source:'ajaxaccountnamesearch.php', 
            minLength:2,
            delay: 0,
            html: true, 
            select: function(event,ui){
                var saccountid=ui.item.saccountid;
                $('#hiddenaccountsearch').val(saccountid);	
            }
        });
    });
    </script>
</body>
</html>