<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

// Get location details
$locationdetails = "select locationcode, locationname from login_locationdetails where username='$username' and docno='$docno'";
$exeloc = mysqli_query($GLOBALS["___mysqli_ston"], $locationdetails);
$resloc = mysqli_fetch_array($exeloc);
$locationcode = $resloc['locationcode'];
$locationname = $resloc['locationname'];

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $itemname = $_REQUEST['itemname'];
    $itemname = strtoupper($itemname);
    $assetid = $_REQUEST['assetid'];
    $costprice = $_REQUEST['costprice']; 
    $costprice = str_replace(',','',$costprice);
    $salvage = $_REQUEST['salvage']; 
    $salvage = str_replace(',','',$salvage);
    $entrydate = $_REQUEST['entrydate'];
    $category1 = $_REQUEST['category'];
    $asset_category_id = $_REQUEST['category_id'];
    $dep_percent = $_REQUEST['dep_percent'];
    $category = $category1; 
    $department = $_REQUEST['department'];
    $department = ucfirst($department);
    $assetclass = $_REQUEST['assetclass'];
    $assetclass = ucfirst($assetclass);
    $assetclassid = $_REQUEST['assetclassid'];
    $unit = $_REQUEST['unit'];
    $period = $_REQUEST['period'];
    $startyear = $_REQUEST['startyear'];
    $startyear = strtoupper($startyear);
    $assetanum = $_REQUEST['assetanum'];
    $assetledger = $_REQUEST['assetledger'];
    $assetledgercode = $_REQUEST['assetledgercode'];
    $depreciation = $_REQUEST['depreciation'];
    $depreciationcode = $_REQUEST['depreciationcode'];
    $accdepreciation = $_REQUEST['accdepreciation'];
    $accdepreciationcode = $_REQUEST['accdepreciationcode'];
    $accdepreciationvalue = $_REQUEST['accdepreciationvalue'];
    $accdepreciationvalue = str_replace(',','',$accdepreciationvalue);
    $gainlossledger = $_REQUEST['gainlossledger'];
    $gainlossledgercode = $_REQUEST['gainlossledgercode'];
    
    // Process depreciation start year
    $depriciation_startyear = explode('-', $startyear);
    $start_month = $depriciation_startyear[0];
    
    switch ($start_month) {
        case 'JAN': $month = 1; break;
        case 'FEB': $month = 2; break;
        case 'MAR': $month = 3; break;
        case 'APR': $month = 4; break;
        case 'MAY': $month = 5; break;
        case 'JUN': $month = 6; break;
        case 'JUL': $month = 7; break;
        case 'AUG': $month = 8; break;
        case 'SEP': $month = 9; break;
        case 'OCT': $month = 10; break;
        case 'NOV': $month = 11; break;
        case 'DEC': $month = 12; break;
        default: break;
    }
    
    if($month < 10) {
        $month = "0".$month;
    }
    $start_day = '01';
    $start_year = $depriciation_startyear[1];
    $depreciation_start_date = $start_year.'-'.$month.'-'.$start_day;
    
    // Generate asset ID
    $idlen = strlen($assetclassid);
    $query7 = "select asset_id from assets_register where asset_id LIKE '$assetclassid%' order by asset_id desc limit 1";
    $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res7 = mysqli_fetch_array($exec7);
    $asset_id = $res7['asset_id'];
    $asset_idlen = strlen($asset_id);
    $assetid = substr($asset_id,$idlen,$asset_idlen);
    $assetid = intval($assetid) + 1;
    $anumlen = strlen($assetid);
    
    if($anumlen == 1) { $assetid = '000'.$assetid; }
    else if($anumlen == 2) { $assetid = '00'.$assetid; }
    else if($anumlen == 3) { $assetid = '0'.$assetid; }
    else { $assetid = $assetid; }
    
    $assetid = $assetclassid.$assetid;
    
    // Check if asset ID already exists
    $query33 = "select asset_id from assets_register where asset_id = '$assetid'";
    $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res33 = mysqli_num_rows($exec33);
    
    if ($res33 == 0) {
        // Insert new asset
        $query1 = "insert into assets_register (asset_id, itemname, costprice, salvage, entrydate, category, asset_category_id, dep_percent, department, assetclass, assetclassid, unit, period, startyear, depreciation_start_date, assetanum, assetledger, assetledgercode, depreciation, depreciationcode, accdepreciation, accdepreciationcode, accdepreciationvalue, gainlossledger, gainlossledgercode, ipaddress, recorddate, username, locationcode, locationname) values ('$assetid', '$itemname', '$costprice', '$salvage', '$entrydate', '$category', '$asset_category_id', '$dep_percent', '$department', '$assetclass', '$assetclassid', '$unit', '$period', '$startyear', '$depreciation_start_date', '$assetanum', '$assetledger', '$assetledgercode', '$depreciation', '$depreciationcode', '$accdepreciation', '$accdepreciationcode', '$accdepreciationvalue', '$gainlossledger', '$gainlossledgercode', '$ipaddress', '$updatedatetime', '$username', '$locationcode', '$locationname')";
        
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $errmsg = "Success. New Asset Added Successfully.";
        $bgcolorcode = 'success';
    } else {
        $errmsg = "Failed. Asset ID Already Exists.";
        $bgcolorcode = 'failed';
    }
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        $errmsg = "Asset added successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset New Entry - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/asset_newentry-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
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
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($locationname); ?></span>
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
        <span>Asset New Entry</span>
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
                        <a href="assetcategory.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Asset Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addassetdepartmentunit.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Asset Department</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="asset_newentry.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>New Asset Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="assetentrylist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Asset List</span>
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
                    <h2>Asset New Entry</h2>
                    <p>Add new assets to the system with complete details and depreciation settings.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="clearForm()">
                        <i class="fas fa-undo"></i> Clear Form
                    </button>
                </div>
            </div>

            <!-- Asset Entry Form -->
            <div class="asset-form-section">
                <div class="asset-form-header">
                    <i class="fas fa-plus-circle asset-form-icon"></i>
                    <h3 class="asset-form-title">Asset Information</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="asset_newentry.php" onSubmit="return addward1process1()" class="asset-form">
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h4 class="section-title">Basic Information</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="itemname" class="form-label">Item Name *</label>
                                <input name="itemname" id="itemname" class="form-input" 
                                       placeholder="Enter item name" style="text-transform:uppercase" required />
                            </div>
                            <div class="form-group">
                                <label for="assetid" class="form-label">Asset ID</label>
                                <input name="assetid" id="assetid" class="form-input" 
                                       placeholder="Auto-generated" readonly />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="costprice" class="form-label">Cost Price *</label>
                                <input name="costprice" id="costprice" class="form-input" 
                                       placeholder="Enter cost price" required />
                            </div>
                            <div class="form-group">
                                <label for="salvage" class="form-label">Salvage Value</label>
                                <input name="salvage" id="salvage" class="form-input" 
                                       placeholder="Enter salvage value" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="entrydate" class="form-label">Entry Date *</label>
                                <input name="entrydate" id="entrydate" class="form-input" 
                                       type="date" required />
                            </div>
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                    <?php
                                    $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $res1location = $res1["locationname"];
                                        $selected = ($locationname == $res1location) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo htmlspecialchars($res1location); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1location); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Category and Department -->
                    <div class="form-section">
                        <h4 class="section-title">Category & Department</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="category" class="form-label">Asset Category *</label>
                                <select name="category" id="category" class="form-input" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $query2 = "select * from master_assetcategory where recordstatus <> 'deleted' order by category";
                                    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res2 = mysqli_fetch_array($exec2)) {
                                        $category_name = $res2["category"];
                                        $category_id = $res2["id"];
                                        ?>
                                        <option value="<?php echo htmlspecialchars($category_name); ?>" data-id="<?php echo $category_id; ?>"><?php echo htmlspecialchars($category_name); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="category_id" id="category_id" />
                            </div>
                            <div class="form-group">
                                <label for="department" class="form-label">Department</label>
                                <select name="department" id="department" class="form-input">
                                    <option value="">Select Department</option>
                                    <?php
                                    $query3 = "select distinct department from master_assetdepartment where recordstatus <> 'deleted' order by department";
                                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res3 = mysqli_fetch_array($exec3)) {
                                        $dept_name = $res3["department"];
                                        ?>
                                        <option value="<?php echo htmlspecialchars($dept_name); ?>"><?php echo htmlspecialchars($dept_name); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="assetclass" class="form-label">Asset Class</label>
                                <input name="assetclass" id="assetclass" class="form-input" 
                                       placeholder="Enter asset class" style="text-transform:capitalize" />
                            </div>
                            <div class="form-group">
                                <label for="assetclassid" class="form-label">Asset Class ID</label>
                                <input name="assetclassid" id="assetclassid" class="form-input" 
                                       placeholder="Enter asset class ID" />
                            </div>
                        </div>
                    </div>

                    <!-- Depreciation Settings -->
                    <div class="form-section">
                        <h4 class="section-title">Depreciation Settings</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dep_percent" class="form-label">Depreciation Percentage</label>
                                <input name="dep_percent" id="dep_percent" class="form-input" 
                                       placeholder="Enter depreciation percentage" />
                            </div>
                            <div class="form-group">
                                <label for="period" class="form-label">Depreciation Period</label>
                                <select name="period" id="period" class="form-input">
                                    <option value="">Select Period</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Quarterly">Quarterly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="startyear" class="form-label">Start Year *</label>
                                <select name="startyear" id="startyear" class="form-input" required>
                                    <option value="">Select Start Year</option>
                                    <?php
                                    $current_year = date('Y');
                                    for ($i = $current_year - 5; $i <= $current_year + 5; $i++) {
                                        $year_option = "JAN-$i";
                                        $selected = ($startyear == $year_option) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $year_option; ?>" <?php echo $selected; ?>><?php echo $year_option; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="unit" class="form-label">Unit</label>
                                <select name="unit" id="unit" class="form-input">
                                    <option value="">Select Unit</option>
                                    <?php
                                    $query4 = "select distinct unit from master_assetdepartment where recordstatus <> 'deleted' order by unit";
                                    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res4 = mysqli_fetch_array($exec4)) {
                                        $unit_name = $res4["unit"];
                                        ?>
                                        <option value="<?php echo htmlspecialchars($unit_name); ?>"><?php echo htmlspecialchars($unit_name); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Ledger Information -->
                    <div class="form-section">
                        <h4 class="section-title">Ledger Information</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="assetledger" class="form-label">Asset Ledger</label>
                                <input name="assetledger" id="assetledger" class="form-input" 
                                       placeholder="Enter asset ledger" />
                            </div>
                            <div class="form-group">
                                <label for="assetledgercode" class="form-label">Asset Ledger Code</label>
                                <input name="assetledgercode" id="assetledgercode" class="form-input" 
                                       placeholder="Enter asset ledger code" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="depreciation" class="form-label">Depreciation Ledger</label>
                                <input name="depreciation" id="depreciation" class="form-input" 
                                       placeholder="Enter depreciation ledger" />
                            </div>
                            <div class="form-group">
                                <label for="depreciationcode" class="form-label">Depreciation Code</label>
                                <input name="depreciationcode" id="depreciationcode" class="form-input" 
                                       placeholder="Enter depreciation code" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="accdepreciation" class="form-label">Accumulated Depreciation</label>
                                <input name="accdepreciation" id="accdepreciation" class="form-input" 
                                       placeholder="Enter accumulated depreciation" />
                            </div>
                            <div class="form-group">
                                <label for="accdepreciationcode" class="form-label">Acc. Depreciation Code</label>
                                <input name="accdepreciationcode" id="accdepreciationcode" class="form-input" 
                                       placeholder="Enter acc. depreciation code" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="accdepreciationvalue" class="form-label">Acc. Depreciation Value</label>
                                <input name="accdepreciationvalue" id="accdepreciationvalue" class="form-input" 
                                       placeholder="Enter acc. depreciation value" />
                            </div>
                            <div class="form-group">
                                <label for="gainlossledger" class="form-label">Gain/Loss Ledger</label>
                                <input name="gainlossledger" id="gainlossledger" class="form-input" 
                                       placeholder="Enter gain/loss ledger" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="gainlossledgercode" class="form-label">Gain/Loss Ledger Code</label>
                                <input name="gainlossledgercode" id="gainlossledgercode" class="form-input" 
                                       placeholder="Enter gain/loss ledger code" />
                            </div>
                            <div class="form-group">
                                <label for="assetanum" class="form-label">Asset Number</label>
                                <input name="assetanum" id="assetanum" class="form-input" 
                                       placeholder="Enter asset number" />
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Asset
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <a href="assetentrylist.php" class="btn btn-outline">
                            <i class="fas fa-list"></i> View Assets
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/asset_newentry-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/datetimepicker1_css.js"></script>
    
    <script language="javascript">
    // Legacy JavaScript functions for compatibility
    function ajaxlocationfunction(val) { 
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
            }
        }
        
        xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
        xmlhttp.send();
    }

    function addward1process1() {
        if (document.form1.itemname.value == "") {
            alert("Please Enter Item Name.");
            document.form1.itemname.focus();
            return false;
        }
        if (document.form1.costprice.value == "") {
            alert("Please Enter Cost Price.");
            document.form1.costprice.focus();
            return false;
        }
        if (document.form1.entrydate.value == "") {
            alert("Please Enter Entry Date.");
            document.form1.entrydate.focus();
            return false;
        }
        if (document.form1.category.value == "") {
            alert("Please Select Category.");
            document.form1.category.focus();
            return false;
        }
        if (document.form1.startyear.value == "") {
            alert("Please Select Start Year.");
            document.form1.startyear.focus();
            return false;
        }
    }

    function formatMoney(number, places, thousand, decimal) {
        number = number || 0;
        places = !isNaN(places = Math.abs(places)) ? places : 2;
        
        thousand = thousand || ",";
        decimal = decimal || ".";
        var negative = number < 0 ? "-" : "",
            i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
    }

    function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode != 46 || $(element).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $(document).ready(function(){
        $('#costprice').keypress(function (event) {
            return isNumber(event, this)
        });

        $('#salvage').keypress(function (event) {
            return isNumber(event, this)
        });

        // Category change handler
        $('#category').change(function() {
            var selectedOption = $(this).find('option:selected');
            var categoryId = selectedOption.data('id');
            $('#category_id').val(categoryId);
        });

        // Cost price validation
        $("#costprice").blur(function() {
            var costprice = document.getElementById("costprice").value.replace(/[^0-9\.]+/g,"");
            var salvage = document.getElementById("salvage").value.replace(/[^0-9\.]+/g,"");
            
            if(parseFloat(costprice) < parseFloat(salvage)) {
                alert('Purchase Price cannot be less than Salvage');
                $(this).val('');
                $('#costprice').focus();
            } else {
                document.getElementById("costprice").value = formatMoney(costprice);
            }
        });

        // Salvage validation
        $("#salvage").blur(function() {
            var salvage = document.getElementById("salvage").value.replace(/[^0-9\.]+/g,"");
            var costprice = document.getElementById("costprice").value.replace(/[^0-9\.]+/g,"");
            
            if(parseFloat(salvage) > parseFloat(costprice)) {
                alert('Salvage cannot be more than Purchase Price');
                $(this).val('');
                $('#salvage').focus();
            } else {
                document.getElementById("salvage").value = formatMoney(salvage);
            }
        });
    });
    </script>
</body>
</html>



