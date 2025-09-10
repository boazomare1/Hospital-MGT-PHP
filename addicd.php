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

$rec_limit = 20;
$st = isset($_REQUEST['st']) ? $_REQUEST['st'] : '';
$anum = isset($_REQUEST['anum']) ? $_REQUEST['anum'] : '';
$cbfrmflag1 = isset($_REQUEST['cbfrmflag1']) ? $_REQUEST['cbfrmflag1'] : '';

if($cbfrmflag1 == "cbfrmflag1") {
    $disease = $_REQUEST['disease'];
    $chapter = $_REQUEST['chapter'];
    $icdname = $_REQUEST['icdname'];
    $icdcode = $_REQUEST['icdcode'];
    $recordstatus = 'active';
    $recordtime = date('Y-m-d H:i:s');
    
    $check_icdcode = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "select icdcode from master_icd where icdcode='$icdcode'"));
    
    if($check_icdcode == 0) {
        $insert = mysqli_query($GLOBALS["___mysqli_ston"], "insert into master_icd(disease,chapter,icdcode,description,recordstatus,recorddate,username,ipaddress) values('$disease','$chapter','$icdcode','$icdname','$recordstatus','$recordtime','$username','$ipaddress')") or die("Error in Insert".mysqli_error($GLOBALS["___mysqli_ston"]));
        $bgcolorcode = 'success';
        $errmsg = "ICD added successfully!";
    } else {
        $bgcolorcode = 'error';
        $errmsg = "ICD code already exists.";
    }
}

if($st == "del") {
    $delquery = mysqli_query($GLOBALS["___mysqli_ston"], "update master_icd set recordstatus='' where auto_number='$anum'");
    header("Location: addicd.php");
    exit();
}

if($st == "act") {
    $delquery = mysqli_query($GLOBALS["___mysqli_ston"], "update master_icd set recordstatus='active' where auto_number='$anum'");
    header("Location: addicd.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICD Master - MedStar Hospital</title>
    <link rel="stylesheet" href="css/addicd-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/jquery-1.11.1.min.js"></script>
</head>
<body>
    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">MedStar Hospital</h1>
        <p class="hospital-subtitle">Healthcare Management System</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($username); ?></span>
            <span class="location-info"><?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="logout.php" class="btn btn-outline">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">Home</a>
        <span>/</span>
        <span>ICD Master</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside class="left-sidebar">
            <div class="sidebar-header">
                <h3>Navigation</h3>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addicd.php" class="nav-link active">
                            <i class="fas fa-stethoscope"></i>
                            ICD Master
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            Generic Names
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            Blood Groups
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-allergies"></i>
                            Food Allergies
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>ICD Master</h2>
                    <p>Manage International Classification of Diseases (ICD) codes and categories</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-outline" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset Form
                    </button>
                    <button class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Add Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-plus-circle add-form-icon"></i>
                    <h3 class="add-form-title">Add New ICD Entry</h3>
                </div>

                <form name="form1" id="form1" method="post" action="addicd.php" class="add-form">
                    <div class="form-group">
                        <label for="disease" class="form-label">Group Name *</label>
                        <input name="disease" id="disease" class="form-input" type="text" maxlength="100" required />
                    </div>

                    <div class="form-group">
                        <label for="chapter" class="form-label">Group Code *</label>
                        <input name="chapter" id="chapter" class="form-input" type="text" maxlength="10" required />
                    </div>

                    <div class="form-group">
                        <label for="icdname" class="form-label">ICD Name *</label>
                        <input name="icdname" id="icdname" class="form-input" type="text" maxlength="100" required />
                    </div>

                    <div class="form-group">
                        <label for="icdcode" class="form-label">ICD Code *</label>
                        <input name="icdcode" id="icdcode" class="form-input" type="text" maxlength="10" required />
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-save"></i> Submit
                    </button>
                </form>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <div class="search-header">
                    <i class="fas fa-search search-icon"></i>
                    <h3 class="search-title">Search ICD Entries</h3>
                </div>

                <div class="search-form">
                    <input type="text" id="icdsearch" name="icdsearch" class="search-input" placeholder="Enter ICD name, code, or group to search..." />
                    <button type="button" id="searchbutton" name="searchbutton" class="search-btn" onclick="searchICDs(document.getElementById('icdsearch').value)">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="button" class="search-btn btn-secondary" onclick="clearSearch()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            </div>

            <!-- Active ICD Entries Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Active ICD Entries</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Group Name</th>
                            <th>Group Code</th>
                            <th>ICD Name</th>
                            <th>ICD Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="icdTableBody">
                        <?php
                        $query2 = "select * from master_icd where recordstatus ='active' order by auto_number desc";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $colorloopcount = 0;
                        
                        while ($res2 = mysqli_fetch_array($exec2)) {
                            $res2disease = $res2['disease'];
                            $res2description = $res2['description'];
                            $res2icdcode = $res2['icdcode'];
                            $res2chapter = $res2['chapter'];
                            $res2auto_number = $res2["auto_number"];
                            $colorloopcount++;
                            ?>
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td><?php echo htmlspecialchars($res2disease); ?></td>
                                <td><?php echo htmlspecialchars($res2chapter); ?></td>
                                <td><?php echo htmlspecialchars($res2description); ?></td>
                                <td><?php echo htmlspecialchars($res2icdcode); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="confirmDelete('<?php echo htmlspecialchars($res2description); ?>', '<?php echo $res2auto_number; ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div id="paginationContainer"></div>
            </div>

            <!-- Deleted ICD Entries Section -->
            <div class="deleted-items-section">
                <div class="deleted-items-header">
                    <i class="fas fa-archive deleted-items-icon"></i>
                    <h3 class="deleted-items-title">Deleted ICD Entries</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Group Name</th>
                            <th>Group Code</th>
                            <th>ICD Name</th>
                            <th>ICD Code</th>
                        </tr>
                    </thead>
                    <tbody id="deletedGenericNameTableBody">
                        <?php
                        $query21 = "select * from master_icd where recordstatus ='' order by auto_number desc";
                        $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res21 = mysqli_fetch_array($exec21)) {
                            $res2disease1 = $res21['disease'];
                            $res2description1 = $res21['description'];
                            $res2icdcode1 = $res21['icdcode'];
                            $res2chapter1 = $res21['chapter'];
                            $res2auto_number1 = $res21["auto_number"];
                            ?>
                            <tr>
                                <td>
                                    <button class="action-btn activate" 
                                            onclick="confirmActivate('<?php echo htmlspecialchars($res2description1); ?>', '<?php echo $res2auto_number1; ?>')"
                                            title="Activate">
                                        <i class="fas fa-undo"></i> Activate
                                    </button>
                                </td>
                                <td><?php echo htmlspecialchars($res2disease1); ?></td>
                                <td><?php echo htmlspecialchars($res2chapter1); ?></td>
                                <td><?php echo htmlspecialchars($res2description1); ?></td>
                                <td><?php echo htmlspecialchars($res2icdcode1); ?></td>
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
    <script src="js/addicd-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



