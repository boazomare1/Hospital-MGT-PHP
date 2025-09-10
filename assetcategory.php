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

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $category = $_REQUEST["category"];
    $id = $_REQUEST["id"];
    $salvage = 0;
    $noofyears = $_REQUEST['noofyears'];
    
    $category = strtoupper($category);
    $category = trim($category);
    $length = strlen($category);
    
    if ($length <= 100) {
        $query2 = "select * from master_assetcategory where category = '$category'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_num_rows($exec2);
        
        if ($res2 == 0) { 
            $query1 = "insert into master_assetcategory (category, ipaddress, recorddate, username, id, salvage, noofyears) 
                       values ('$category', '$ipaddress', '$updatedatetime', '$username', '$id', '$salvage', '$noofyears')";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $errmsg = "Success. New Asset Category Added.";
            $bgcolorcode = 'success';
        } else {
            $errmsg = "Failed. Asset Category Already Exists.";
            $bgcolorcode = 'failed';
        }
    } else {
        $errmsg = "Failed. Only 100 Characters Are Allowed.";
        $bgcolorcode = 'failed';
    }
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_assetcategory set recordstatus = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: assetcategory.php?msg=deleted");
    exit();
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_assetcategory set recordstatus = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: assetcategory.php?msg=activated");
    exit();
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        $errmsg = "Asset category deleted successfully.";
        $bgcolorcode = 'success';
    } elseif ($_GET['msg'] == 'activated') {
        $errmsg = "Asset category activated successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Category Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/assetcategory-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link href="js/jquery-ui.css" rel="stylesheet">
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
        <span>Asset Category Master</span>
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
                        <a href="assetcategory.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Asset Category</span>
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
                    <h2>Asset Category Master</h2>
                    <p>Manage asset categories and their depreciation settings.</p>
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

            <!-- Add Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-plus-circle add-form-icon"></i>
                    <h3 class="add-form-title">Add New Asset Category</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="assetcategory.php" onSubmit="return addward1process1()" class="add-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="id" class="form-label">Category ID</label>
                            <input name="id" id="id" class="form-input" 
                                   placeholder="Enter category ID" style="text-transform:uppercase" />
                        </div>

                        <div class="form-group">
                            <label for="category" class="form-label">Category Name</label>
                            <input name="category" id="category" class="form-input" 
                                   placeholder="Enter category name" style="text-transform:uppercase" />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="noofyears" class="form-label">Depreciation Years</label>
                            <input name="noofyears" id="noofyears" class="form-input" 
                                   placeholder="Enter number of years" style="text-transform:uppercase" />
                        </div>

                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div class="form-actions">
                                <input type="hidden" name="frmflag" value="addnew" />
                                <input type="hidden" name="frmflag1" value="frmflag1" />
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Existing Asset Categories</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Salvage Value</th>
                            <th>Depreciation Years</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="assetCategoryTableBody">
                        <?php
                        $query1 = "select * from master_assetcategory where recordstatus <> 'deleted' order by category";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $colorloopcount = 0;
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $category = $res1["category"];
                            $auto_number = $res1["auto_number"];
                            $id = $res1["id"];
                            $salvage = $res1['salvage'];
                            $noofyears = $res1['noofyears'];
                            
                            $colorloopcount++;
                            ?>
                            <tr>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="confirmDelete('<?php echo htmlspecialchars($category); ?>', '<?php echo $auto_number; ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="category-id-badge"><?php echo htmlspecialchars($id); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($category); ?></td>
                                <td>
                                    <span class="salvage-badge"><?php echo number_format($salvage, 2); ?></span>
                                </td>
                                <td>
                                    <span class="years-badge"><?php echo htmlspecialchars($noofyears); ?> years</span>
                                </td>
                                <td>
                                    <a href="editassetcategory.php?st=edit&&anum=<?php echo $auto_number; ?>" 
                                       class="action-btn edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Deleted Items Section -->
            <div class="deleted-items-section">
                <div class="deleted-items-header">
                    <i class="fas fa-archive deleted-items-icon"></i>
                    <h3 class="deleted-items-title">Deleted Asset Categories</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Category Name</th>
                        </tr>
                    </thead>
                    <tbody id="deletedAssetCategoryTableBody">
                        <?php
                        $query1 = "select * from master_assetcategory where recordstatus = 'deleted' order by category";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $category = $res1["category"];
                            $auto_number = $res1["auto_number"];
                            ?>
                            <tr>
                                <td>
                                    <button class="action-btn activate" 
                                            onclick="confirmActivate('<?php echo htmlspecialchars($category); ?>', '<?php echo $auto_number; ?>')"
                                            title="Activate">
                                        <i class="fas fa-undo"></i> Activate
                                    </button>
                                </td>
                                <td><?php echo htmlspecialchars($category); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/assetcategory-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
    
    <script language="javascript">
    $(document).ready(function(){
        $('#noofyears').keypress(function (event) {
            return isOnlyNumber(event, this)
        });
    });

    function isOnlyNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 48 || charCode > 57))
            return false;
        return true;
    } 

    function addward1process1() {
        if (document.form1.id.value == "") {
            alert("Please Enter ID");
            document.form1.id.focus();
            return false;
        }
        if (document.form1.category.value == "") {
            alert("Please Enter Category Name.");
            document.form1.category.focus();
            return false;
        }
        if (document.form1.noofyears.value == "") {
            alert("Please Enter No Of Years.");
            document.form1.noofyears.focus();
            return false;
        }
    }

    function funcDeletePaymentType(varPaymentTypeAutoNumber) {
        var varPaymentTypeAutoNumber = varPaymentTypeAutoNumber;
        var fRet;
        fRet = confirm('Are you sure want to delete this asset category '+varPaymentTypeAutoNumber+'?');
        
        if (fRet == true) {
            alert("Asset Category Entry Delete Completed.");
        }
        if (fRet == false) {
            alert("Asset Category Entry Delete Not Completed.");
            return false;
        }
    }
    </script>
</body>
</html>



