<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
    $categoryname = $_REQUEST["categoryname"];
    $categoryname = strtoupper($categoryname);
    $categoryname = trim($categoryname);
    $length=strlen($categoryname);
    if ($length<=100)
    {
        $query2 = "select * from master_categorylab where categoryname = '$categoryname'";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_num_rows($exec2);
        if ($res2 == 0)
        {
            $query1 = "insert into master_categorylab(categoryname, ipaddress, updatetime)
            values ('$categoryname', '$ipaddress', '$updatedatetime')";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $errmsg = "Success. New Lab Category Updated.";
            $bgcolorcode = 'success';
        }
        else
        {
            $errmsg = "Failed. Lab Category Already Exists.";
            $bgcolorcode = 'failed';
        }
    }
    else
    {
        $errmsg = "Failed. Only 100 Characters Are Allowed.";
        $bgcolorcode = 'failed';
    }
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_categorylab set status = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_categorylab set status = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if (isset($_REQUEST["defaultstatus"])) { $defaultstatus = $_REQUEST["defaultstatus"]; } else { $defaultstatus = ""; }
if ($defaultstatus == 'setdefault')
{
    $delanum = $_REQUEST["anum"];
    $query4 = "update master_categorylab set defaultstatus = '' where auto_number = '$delanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($defaultstatus == 'removedefault')
{
    $delanum = $_REQUEST["anum"];
    $query4 = "update master_categorylab set defaultstatus = 'deleted' where auto_number = '$delanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
    $errmsg = "Please Add lab Category To Proceed For Billing.";
    $bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Category Master - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/labcategory1-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
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
    
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Lab Category Master</span>
    </nav>
    
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="main-container-with-sidebar">
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
                        <a href="labcategory1.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Lab Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1interpret.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1temp.php" class="nav-link">
                            <i class="fas fa-file-medical"></i>
                            <span>Lab Templates</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lab_dataimport.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Data Import</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="alert-container">
                <?php if ($errmsg != "") { ?>
                    <div class="alert <?php echo $bgcolorcode; ?>">
                        <?php echo htmlspecialchars($errmsg); ?>
                    </div>
                <?php } ?>
            </div>
            
            <div class="page-header">
                <h1 class="page-title">Lab Category Master</h1>
                <p class="page-subtitle">Manage laboratory test categories and classifications</p>
            </div>
            
            <div class="form-section">
                <h2 class="form-title">Add New Category</h2>
                <form method="post" action="">
                    <input type="hidden" name="frmflag1" value="frmflag1">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="categoryname" class="form-label">Category Name *</label>
                            <input type="text" 
                                   id="categoryname" 
                                   name="categoryname" 
                                   class="form-input" 
                                   placeholder="Enter category name"
                                   maxlength="100"
                                   required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Add Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="data-section">
                <div class="data-header">
                    <h2 class="data-title">Active Categories</h2>
                    <div class="search-container">
                        <form method="get" action="">
                            <input type="text" 
                                   name="search1" 
                                   class="search-input" 
                                   placeholder="Search categories..."
                                   value="<?php echo htmlspecialchars($search1); ?>">
                            <button type="submit" name="searchflag1" value="searchflag1" class="search-btn">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Default Status</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($searchflag1 == 'searchflag1') {
                                $query1 = "select * from master_categorylab where categoryname like '%$search1%' and status <> 'deleted' order by auto_number desc";
                            } else {
                                $query1 = "select * from master_categorylab where status <> 'deleted' order by auto_number desc";
                            }
                            
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if (mysqli_num_rows($exec1) > 0) {
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $categoryname = $res1["categoryname"];
                                    $defaultstatus = $res1["defaultstatus"];
                                    $updatetime = $res1["updatetime"];
                                    $auto_number = $res1["auto_number"];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td><?php echo htmlspecialchars($categoryname); ?></td>
                                <td>
                                    <?php if ($defaultstatus == '') { ?>
                                        <span class="status-badge status-active">Default</span>
                                    <?php } else { ?>
                                        <span class="status-badge status-deleted">Not Default</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo date('M d, Y H:i', strtotime($updatetime)); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($defaultstatus == '') { ?>
                                            <a href="labcategory1.php?defaultstatus=removedefault&&anum=<?php echo $auto_number; ?>" 
                                               class="btn btn-sm btn-outline"
                                               onclick="return confirmRemoveDefault('<?php echo htmlspecialchars($categoryname); ?>', this.href)">
                                                <i class="fas fa-star"></i>
                                                Remove Default
                                            </a>
                                        <?php } else { ?>
                                            <a href="labcategory1.php?defaultstatus=setdefault&&anum=<?php echo $auto_number; ?>" 
                                               class="btn btn-sm btn-success"
                                               onclick="return confirmSetDefault('<?php echo htmlspecialchars($categoryname); ?>', this.href)">
                                                <i class="fas fa-star"></i>
                                                Set Default
                                            </a>
                                        <?php } ?>
                                        <a href="labcategory1.php?st=del&&anum=<?php echo $auto_number; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirmDelete('<?php echo htmlspecialchars($categoryname); ?>', this.href)">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-tags"></i>
                                    <h3>No Categories Found</h3>
                                    <p>No lab categories match your search criteria.</p>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="data-section">
                <div class="data-header">
                    <h2 class="data-title">Deleted Categories</h2>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Deleted Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query2 = "select * from master_categorylab where status = 'deleted' order by auto_number desc";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if (mysqli_num_rows($exec2) > 0) {
                                while ($res2 = mysqli_fetch_array($exec2)) {
                                    $categoryname = $res2["categoryname"];
                                    $updatetime = $res2["updatetime"];
                                    $auto_number = $res2["auto_number"];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td><?php echo htmlspecialchars($categoryname); ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($updatetime)); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="labcategory1.php?st=activate&&anum=<?php echo $auto_number; ?>" 
                                           class="btn btn-sm btn-success"
                                           onclick="return confirmActivate('<?php echo htmlspecialchars($categoryname); ?>', this.href)">
                                            <i class="fas fa-undo"></i>
                                            Activate
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="3" class="empty-state">
                                    <i class="fas fa-trash"></i>
                                    <h3>No Deleted Categories</h3>
                                    <p>There are no deleted categories to display.</p>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script src="js/labcategory1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>