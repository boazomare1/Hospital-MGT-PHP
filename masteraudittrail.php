<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["itemname"])) { $itemname = $_REQUEST["itemname"]; } else { $itemname = ''; }
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ''; }
if (isset($_REQUEST["auditype"])) { $auditype = $_REQUEST["auditype"]; } else { $auditype = ''; }

// Get default location
$query19 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res19 = mysqli_fetch_array($exec19)) {
    $locationname = $res19["locationname"];
    $locationcode = $res19["locationcode"];
}

$errmsg = "";
$bgcolorcode = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Audit Trail - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/masteraudittrail-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
    <link rel="stylesheet" href="css/main.css" type="text/css" />
    <link rel="stylesheet" href="css/field.css" type="text/css" />
    <link href="css/datepicker.css" rel="stylesheet">
    <link href="css/autocomplete.css" rel="stylesheet">
    <link href="css/jquery-ui.min_jqueryui1.11.2.css" rel="stylesheet">
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
        <span>Master Audit Trail</span>
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
                    <li class="nav-item active">
                        <a href="masteraudittrail.php" class="nav-link">
                            <i class="fas fa-history"></i>
                            <span>Master Audit Trail</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : 'info'; ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : 'info-circle'; ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Master Audit Trail</h2>
                    <p>Track changes and modifications to master data across different departments.</p>
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
                    <h3 class="search-form-title">Search Audit Records</h3>
                </div>
                
                <form name="cbform1" method="post" action="masteraudittrail.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="auditype" class="form-label">Select Audit Type</label>
                            <select name="auditype" id="auditype" class="form-input" onChange="return disabletype();">
                                <option value="">Select Audit</option>
                                <option value="1" <?php if($auditype==1) echo 'selected'; ?>>Pharmacy</option>
                                <option value="2" <?php if($auditype==2) echo 'selected'; ?>>Laboratory</option>
                                <option value="3" <?php if($auditype==3) echo 'selected'; ?>>Radiology</option>
                                <option value="4" <?php if($auditype==4) echo 'selected'; ?>>Services</option>
                                <option value="5" <?php if($auditype==5) echo 'selected'; ?>>Plan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="itemname" class="form-label">Item Name</label>
                            <input name="itemname" type="text" id="itemname" class="form-input" 
                                   value="<?php echo htmlspecialchars($itemname); ?>" 
                                   placeholder="Enter item name to search" 
                                   autocomplete="off" onFocus="return auditypeearch()">
                            <input name="itemcode" type="hidden" id="itemcode" value="<?php echo htmlspecialchars($itemcode); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                   class="form-input date-input" readonly="readonly" 
                                   onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                 style="cursor:pointer; margin-left: 5px;" alt="Calendar" />
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                   class="form-input date-input" readonly="readonly" 
                                   onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                 style="cursor:pointer; margin-left: 5px;" alt="Calendar" />
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Audit Records</h3>
                </div>

                <div id="auditTableContainer">
                    <?php
                    if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
                        if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; }
                        if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; }
                        
                        // Include the audit table display logic here
                        include("includes/audit_table_display.php");
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/masteraudittrail-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <script>
    function auditypeearch(){
        var pid = document.getElementById('auditype').value;
        var itemname = document.getElementById('itemname').value;
        
        $('#itemname').autocomplete({	
            source: "ajax_masteraudittrail_itemsearch.php?pid="+pid+"&&term="+itemname,
            minLength: 1,
            html: true,
            select: function(event,ui) {
                var mobile = ui.item.value;
                var excessnov = ui.item.mobile;
                
                $("#itemname").val(mobile);
                $("#itemcode").val(excessnov);
            }, 
        });
    }

    function disableEnterKey(varPassed) {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode;
            return false;
        }
        
        var key;
        if(window.event) {
            key = window.event.keyCode;
        } else {
            key = e.which;
        }

        if(key == 13) {
            return false;
        } else {
            return true;
        }
    }

    function disabletype() {
        // Function to handle audit type change
        return true;
    }
    </script>
</body>
</html>

