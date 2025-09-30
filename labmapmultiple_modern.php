<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
$companyname = $_SESSION['companyname'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$rateperunit = "0";
$purchaseprice = "0";
$checkboxnumber = '';

if (isset($_POST["searchflag1"])) { $searchflag1 = $_POST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_POST["search1"])) { $search1 = $_POST["search1"]; } else { $search1 = ""; }
if (isset($_POST["search2"])) { $search2 = $_POST["search2"]; } else { $search2 = ""; }
if (isset($_POST["location"])) { $location = $_POST["location"]; } else { $location = ""; }
if (isset($_POST["store"])) { $store = $_POST["store"]; } else { $store = ""; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Item Map Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/lab-map-multiple-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for datepicker -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Legacy CSS for autocomplete -->
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
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
        <span>Lab Item Map Master</span>
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
                        <a href="labmapmultiple.php" class="nav-link">
                            <i class="fas fa-link"></i>
                            <span>Lab Item Mapping</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeecategory.php" class="nav-link">
                            <i class="fas fa-user-tag"></i>
                            <span>Employee Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeedesignation.php" class="nav-link">
                            <i class="fas fa-id-badge"></i>
                            <span>Employee Designation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeeinfo.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="editemployeeinfo1.php" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeelist1.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Employee List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="labmapmultiple.php" class="nav-link">
                            <i class="fas fa-map"></i>
                            <span>Lab Item Map Master</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">🔗 Lab Item Map Master</h1>
                <div class="page-actions">
                    <button class="btn btn-primary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Alert Container -->
            <div id="alertContainer"></div>

            <?php
            if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
            
            if ($st == 'success') {
            ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Item Mapping To Supplier Completed Successfully!
            </div>
            <?php
            }
            ?>

            <!-- Search Container -->
            <div class="search-container">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Search Lab Items</h3>
                </div>
                
                <form name="form1" id="form1" action="labmapmultiple.php" method="post">
                    <div class="search-form">
                        <div class="search-input-group">
                            <label for="location" class="search-label">Location</label>
                            <select name="location" id="location" class="form-select">
                                <option value="">Select Location</option>
                                <?php
                                $query7 = "select * from master_location where status <> 'deleted'";
                                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res7 = mysqli_fetch_array($exec7)) {
                                    $res7locationcode = $res7['locationcode'];
                                    $res7locationname = $res7['locationname'];
                                ?>
                                <option value="<?php echo $res7locationcode; ?>" <?php if($location == $res7locationcode) { echo "selected"; } ?>><?php echo $res7locationname; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="search-input-group">
                            <label for="search1" class="search-label">Lab Item</label>
                            <input name="search1" type="text" id="search1" class="search-input" 
                                   value="<?php echo htmlspecialchars($search1); ?>" 
                                   placeholder="Type lab item name..." 
                                   onFocus="return auditypeearch()">
                            <input type="hidden" name="searchitemcode" id="searchitemcode" value="">
                            <input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="Submit2" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Search Items
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                                Clear
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            if ($searchflag1 == 'searchflag1') {
                $items_build = "''";
                $search1 = $_REQUEST["search1"];
                
                $query1 = "select itemcode,categoryname,itemname,rateperunit,sampletype from master_lab where itemname like '%$search1%' and status <> 'deleted' and externallab = 'yes' order by itemname";
                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                $resultCount = mysqli_num_rows($exec1);
            ?>
            
            <!-- Results Container -->
            <div class="results-container">
                <div class="results-header">
                    <h3 class="results-title">Lab Items Found</h3>
                    <span class="results-count"><?php echo $resultCount; ?> items</span>
                </div>
                
                <?php if ($resultCount > 0) { ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>ID / Code</th>
                                <th>Category</th>
                                <th>Test Name</th>
                                <th>Rate</th>
                                <th>Supplier</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $checkboxnumber = 0;
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $itemcode = $res1["itemcode"];
                                $itemname = $res1["itemname"];
                                $categoryname = $res1["categoryname"];
                                $rateperunit = $res1["rateperunit"];
                                $sampletype = $res1["sampletype"];
                                
                                $supplierq = "select suppliercode from lab_supplierlink where itemcode = '$itemcode' and fav_supplier='1'";
                                $execq = mysqli_query($GLOBALS["___mysqli_ston"], $supplierq) or die("Error in SupplierQ".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $resq = mysqli_fetch_array($execq);
                                $suppliercode = $resq['suppliercode'];
                                
                                $query20 = "select accountname from master_accountname where id = '$suppliercode' ";
                                $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res20 = mysqli_fetch_array($exec20);
                                $suppliername = $res20['accountname'];
                                
                                $checkboxnumber++;
                            ?>
                            <tr>
                                <td align="center"><?php echo $checkboxnumber; ?></td>
                                <td><?php echo htmlspecialchars($itemcode); ?></td>
                                <td><?php echo htmlspecialchars($categoryname); ?></td>
                                <td><?php echo htmlspecialchars($itemname); ?></td>
                                <td align="right"><?php echo number_format($rateperunit, 2); ?></td>
                                <td><?php echo htmlspecialchars($suppliername); ?></td>
                                <td>
                                    <a href='javascript:return false;' 
                                       onClick="javascript:coasearch('7','<?php echo $itemcode;?>','<?php echo $rateperunit;?>');" 
                                       class="action-link map-action" 
                                       data-item-code="<?php echo $itemcode; ?>" 
                                       data-rate="<?php echo $rateperunit; ?>">
                                        <i class="fas fa-link"></i>
                                        Map
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>No Items Found</h3>
                    <p>No lab items found matching your search criteria. Please try a different search term.</p>
                </div>
                <?php } ?>
            </div>
            
            <?php
            }
            ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/lab-map-multiple-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for autocomplete -->
    <script>
    function auditypeearch() {
        var search1 = document.getElementById('search1').value;
        
        $('#search1').autocomplete({
            source: "ajax_labmapmultiple_search.php?pid=" + search1,
            minLength: 1,
            html: true,
            select: function(event, ui) {
                var mobile = ui.item.value;
                var excessnov = ui.item.mobile;
                
                $("#search1").val(mobile);
                $("#searchitemcode").val(excessnov);
            }
        });
    }
    
    function coasearch(varCallFrom, item) {
        var varCallFrom = varCallFrom;
        var item = item;
        
        window.open("popup_labmapmultiple.php?callfrom=" + varCallFrom + '&item=' + item, "Window2", 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
        return false;
    }
    
    function form1valid() {
        if (document.getElementById("location").value == "") {
            alert('Select Location');
            document.getElementById("location").focus();
            return false;
        }
    }
    
    function form2Valid() {
        if (document.getElementById("locationcode").value == "") {
            alert('Select Location');
            document.getElementById("locationcode").focus();
            return false;
        }
    }
    </script>
</body>
</html>
