<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

date_default_timezone_set('Asia/Calcutta'); 

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = '';

//To populate the autocompetelist_services1.js
$transactiondatefrom = date('2014-01-01');
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
    if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
    if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Category Issues - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/drugcategoryissues-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Auto Suggest CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript Files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
    <script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <?php include ("js/dropdownlist1scripting1stock1.php"); ?>
</head>

<body onLoad="return funcCustomerDropDownSearch1();">
    <!-- Alert Container -->
    <div id="alertContainer"></div>

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
        <span>Drug Category Issues</span>
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
                    <li class="nav-item active">
                        <a href="drugcategoryissues.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Drug Category Issues</span>
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
                    <h2>Drug Category Issues</h2>
                    <p>Track and analyze drug category issues and pharmacy sales by category.</p>
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
                    <h3 class="search-form-title">Search Drug Category Issues</h3>
                </div>
                
                <form name="drugs" action="drugcategoryissues.php" method="post" class="search-form" onKeyDown="return disableEnterKey()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="categoryname" class="form-label">Category</label>
                            <select name="categoryname" id="categoryname" class="form-input">
                                <?php
                                $categoryname = $_REQUEST['categoryname'];
                                if ($categoryname != '') {
                                    ?>
                                    <option value="<?php echo htmlspecialchars($categoryname); ?>" selected="selected"><?php echo htmlspecialchars($categoryname); ?></option>
                                    <option value="">Show All Categories</option>
                                    <?php
                                } else {
                                    ?>
                                    <option selected="selected" value="">Show All Categories</option>
                                    <?php
                                }
                                ?>
                                <?php
                                $query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
                                $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res42 = mysqli_fetch_array($exec42)) {
                                    $categoryname_option = $res42['categoryname'];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($categoryname_option); ?>"><?php echo htmlspecialchars($categoryname_option); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-input">
                                <option value="">Select Type</option>
                                <option value="TABLETS">TABLETS AND CAPSULES</option>
                                <option value="INJECTIONS">INJECTABLES</option>
                                <option value="SYRUPS & SUSP">SYRUPS AND SUSPENSIONS</option>
                                <option value="VACCINES">VACCINES</option>
                                <option value="EXTERNAL PREP">EXTERNAL PREPARATIONS</option>
                                <option value="SUNDRIES">SUNDRIES</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                       class="form-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     style="cursor:pointer" class="date-picker-icon" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                       class="form-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     style="cursor:pointer" class="date-picker-icon" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="itemname" class="form-label">Medicine</label>
                        <input name="itemname" type="text" id="itemname" value="<?php echo htmlspecialchars($searchitemname); ?>" 
                               class="form-input" placeholder="Enter medicine name" autocomplete="off">
                        <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
                        <input type="hidden" name="searchitemcode" id="searchitemcode" value="<?php echo htmlspecialchars($searchitemcode); ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                </form>
            </div>

            <!-- Results Section -->
            <?php
            if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
            if ($frmflag1 == 'frmflag1') {
                if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
                if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
                ?>
                <div class="results-section">
                    <div class="results-header">
                        <i class="fas fa-list results-icon"></i>
                        <h3 class="results-title">Search Results</h3>
                        <div class="results-actions">
                            <?php $url = "ADate1=$ADate1&&ADate2=$ADate2&&frmflag1=frmflag1&&categoryname=$categoryname&&type=$type&&searchitemcode=$searchitemcode" ?>
                            <a href="print_drugcategoryissues.php?<?php echo $url; ?>" target='_blank' class="btn btn-outline">
                                <i class="fas fa-file-pdf"></i> Print PDF
                            </a>
                        </div>
                    </div>

                    <div class="results-content">
                        <?php
                        if(true) {
                            $query9 = "select categoryname, itemcode from master_medicine where status <> 'deleted' and categoryname LIKE '%$categoryname%' and itemcode LIKE '%$searchitemcode%' order by itemname";
                            $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while($res9 = mysqli_fetch_array($exec9)) {
                                $sno=0;
                                $total=0;
                                $categoryname = $res9['categoryname']; 
                                $catitemcode = $res9['itemcode']; 

                                $query7 = "select * from pharmacysales_details where itemcode = '$catitemcode' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";
                                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num7 = mysqli_num_rows($exec7);
                                
                                if($num7!=0){
                                    ?>
                                    <div class="category-section">
                                        <div class="category-header">
                                            <h4><?php echo htmlspecialchars($categoryname); ?></h4>
                                        </div>
                                        
                                        <table class="data-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Patient Name</th>
                                                    <th>Dept/Ward</th>
                                                    <th>Drug Name</th>
                                                    <th>Quantity</th>
                                                    <th>Date of Issue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while($res7 = mysqli_fetch_array($exec7)) {
                                                    $billdate6 = $res7['entrydate'];
                                                    $quantity6 = $res7['quantity'];
                                                    $patientname6 = $res7['patientname'];
                                                    $itemname = $res7['itemname'];
                                                    $itemcode = $res7['itemcode'];
                                                    $issuedfrom = $res7['issuedfrom']; 
                                                    $visitcode = $res7['visitcode'];

                                                    if($issuedfrom ==''){
                                                        $sqlq = "SELECT departmentname FROM `master_visitentry` WHERE `visitcode` = '$visitcode'";
                                                        $sqlexc = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq);
                                                        $sqlnum = mysqli_num_rows($sqlexc);
                                                        $sqlres = mysqli_fetch_array($sqlexc);
                                                        if($sqlnum > 0){
                                                            $dept_ward = $sqlres['departmentname'];
                                                        }else{
                                                            $dept_ward = '';
                                                        }
                                                    }else{
                                                        $sqlq1 = "SELECT ward FROM `ip_bedallocation` WHERE `visitcode` = '$visitcode'";
                                                        $sqlexc1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq1);
                                                        $sqlnum1 = mysqli_num_rows($sqlexc1);
                                                        $sqlres1 = mysqli_fetch_array($sqlexc1);
                                                        if($sqlnum1 > 0){
                                                            $dept_wardautono = $sqlres1['ward'];
                                                            $sqlq2 = "SELECT ward FROM `master_ward` WHERE `auto_number` = '$dept_wardautono' ";
                                                            $sqlexc2 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq2);
                                                            $sqlnum2 = mysqli_num_rows($sqlexc2);
                                                            $sqlres2 = mysqli_fetch_array($sqlexc2);
                                                            if($sqlnum2 > 0){
                                                                $dept_ward = $sqlres2['ward'];
                                                            }else{
                                                                $dept_ward = '';
                                                            }
                                                        }else{
                                                            $dept_ward = '';
                                                        }
                                                    }

                                                    $colorloopcount = $colorloopcount + 1;
                                                    $showcolor = ($colorloopcount & 1); 
                                                    
                                                    if($type==''){
                                                        $num='1';
                                                    }else{
                                                        $query9 = "select * from master_medicine where incomeledger like '%$type%' and itemcode='$itemcode' and status = '' group by itemcode order by categoryname";
                                                        $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                                        $num=mysqli_num_rows($exec9);	
                                                    }
                                                    
                                                    if($num!=0){
                                                        $total=$total+$quantity6;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sno=$sno+1; ?></td>
                                                            <td><?php echo htmlspecialchars($patientname6); ?></td>
                                                            <td><?php echo htmlspecialchars($dept_ward); ?></td>
                                                            <td><?php echo htmlspecialchars($itemname); ?></td>
                                                            <td><?php echo intval($quantity6); ?></td>
                                                            <td><?php echo $billdate6; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <tr class="total-row">
                                                    <td colspan="3"></td>
                                                    <td><strong>Total</strong></td>
                                                    <td><strong><?php echo intval($total); ?></strong></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/drugcategoryissues-modern.js?v=<?php echo time(); ?>"></script>
    
    <script language="javascript">
        function disableEnterKey() {
            if (event.keyCode==8) {
                event.keyCode=0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;     //IE
            } else {
                key = e.which;     //firefox
            }
            
            if(key == 13) // if enter key press
            {
                return false;
            } else {
                return true;
            }
        }

        function clrcode() {
            document.getElementById('searchitemcode').value='';
        }

        function refreshPage() {
            location.reload();
        }

        function exportToExcel() {
            // Simple CSV export functionality
            const tables = document.querySelectorAll('.data-table');
            let csv = [];
            
            tables.forEach(table => {
                const rows = Array.from(table.querySelectorAll('tr'));
                rows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('th, td'));
                    const rowData = cells.map(cell => `"${cell.textContent.trim()}"`).join(',');
                    csv.push(rowData);
                });
            });
            
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'drug_category_issues.csv';
            a.click();
            window.URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>