<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (!isset($_SESSION['labtablename'])){$_SESSION['labtablename']='master_lab';}
if (isset($_REQUEST["labtemplate"])) { $labtemplate = $_REQUEST["labtemplate"]; $_SESSION['labtablename']=$labtemplate; } else { $labtemplate = $_SESSION['labtablename']; }

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
    $delanum = $_REQUEST["anum"];
    $query3 = "update $labtemplate set status = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
    $delanum = $_REQUEST["anum"];
    $query3 = "update $labtemplate set status = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
    $errmsg = "Please Add lab Item To Proceed For Billing.";
    $bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }

// Pagination setup
$tbl_name = $labtemplate;
$adjacents = 3;

if ($searchflag1 == 'searchflag1') {
    $search1 = $_REQUEST["search1"];
    $query111 = "select * from $labtemplate where itemname like '%$search1%' or categoryname like '%$search1%' and status <> 'deleted' group by itemcode order by auto_number desc";
    $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
    $total_pages = mysqli_num_rows($exec111);
} else {
    $query111 = "select * from $labtemplate where status <> 'deleted' group by itemcode order by auto_number desc";
    $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
    $total_pages = mysqli_num_rows($exec111);
}

$targetpage = $_SERVER['PHP_SELF'];
$limit = 50;
if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}
if($page) 
    $start = ($page - 1) * $limit;
else
    $start = 0;

if ($page == 0) $page = 1;
$prev = $page - 1;
$next = $page + 1;
$lastpage = ceil($total_pages/$limit);
$lpm1 = $lastpage - 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Item Master - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/labitem1interpret-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($_SESSION["companyname"]); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>
    
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Lab Item Master</span>
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
                <h1 class="page-title">Lab Item Master</h1>
                <p class="page-subtitle">Manage laboratory test items and their configurations</p>
            </div>
            
            <div class="data-section">
                <div class="data-header">
                    <h2 class="data-title">Lab Items - <?php echo htmlspecialchars($labtemplate); ?></h2>
                    <div class="search-container">
                        <form method="get" action="">
                            <input type="text" 
                                   name="search1" 
                                   class="search-input" 
                                   placeholder="Search items..."
                                   value="<?php echo htmlspecialchars($search1); ?>">
                            <button type="submit" name="searchflag1" value="searchflag1" class="search-btn">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </form>
                        <select name="labtemplate" class="template-select" onchange="changeTemplate(this.value)">
                            <option value="<?php echo htmlspecialchars($labtemplate); ?>"><?php echo htmlspecialchars($labtemplate); ?></option>
                            <option value="master_lab">master_lab</option>
                            <?php
                            $query10 = "select * from master_testtemplate where testname = 'lab' order by templatename";
                            $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res10 = mysqli_fetch_array($exec10)) {
                                $templatename = $res10["templatename"];
                                if($templatename != $labtemplate) {
                                    echo '<option value="' . htmlspecialchars($templatename) . '">' . htmlspecialchars($templatename) . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <?php if($total_pages > 0) { ?>
                            <a href="print_labitemtemp.php?labtemp=<?php echo $labtemplate; ?>" 
                               class="export-btn" 
                               target="_blank">
                                <i class="fas fa-file-excel"></i>
                                Export Excel
                            </a>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Sample Type</th>
                                <th>Reference</th>
                                <th>Ref. Unit</th>
                                <th>Range</th>
                                <th>Tax %</th>
                                <th>IP Markup</th>
                                <th>Charges</th>
                                <th>Rate2</th>
                                <th>Rate3</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($searchflag1 == 'searchflag1') {
                                $query1 = "select * from $labtemplate where itemname like '%$search1%' or categoryname like '%$search1%' and status <> 'deleted' group by itemcode order by auto_number desc LIMIT $start, $limit";
                            } else {
                                $query1 = "select * from $labtemplate where status <> 'deleted' group by itemcode order by auto_number desc LIMIT $start, $limit";
                            }
                            
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if (mysqli_num_rows($exec1) > 0) {
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $itemcode = $res1["itemcode"];
                                    $itemname = $res1["itemname"];
                                    $categoryname = $res1["categoryname"];
                                    $purchaseprice = $res1["purchaseprice"];
                                    $sampletype = isset($res1["sampletype"]) ? $res1["sampletype"] : '';
                                    $rateperunit = $res1["rateperunit"];
                                    $expiryperiod = $res1["expiryperiod"];
                                    $auto_number = $res1["auto_number"];
                                    $itemname_abbreviation = $res1["itemname_abbreviation"];
                                    $taxname = $res1["taxname"];
                                    $taxanum = $res1["taxanum"];
                                    $ipmarkup = $res1["ipmarkup"];
                                    $location = $res1["location"];
                                    $referencename = isset($res1['referencename']) ? $res1['referencename'] : '';
                                    $referenceunit = isset($res1['referenceunit']) ? $res1['referenceunit'] : '';
                                    $referencerange = isset($res1['referencerange']) ? $res1['referencerange'] : '';
                                    $rate2 = $res1['rate2'];
                                    $rate3 = $res1['rate3'];
                                    
                                    if ($expiryperiod != '0') {
                                        $expiryperiod = $expiryperiod . ' Months';
                                    } else {
                                        $expiryperiod = '';
                                    }
                                    
                                    $query6 = "select * from master_tax where auto_number = '$taxanum'";
                                    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res6 = mysqli_fetch_array($exec6);
                                    $res6taxpercent = $res6["taxpercent"];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td><?php echo htmlspecialchars($itemcode); ?></td>
                                <td><?php echo htmlspecialchars($categoryname); ?></td>
                                <td><?php echo htmlspecialchars($itemname); ?></td>
                                <td><?php echo htmlspecialchars($itemname_abbreviation); ?></td>
                                <td><?php echo htmlspecialchars($sampletype); ?></td>
                                <td><?php echo htmlspecialchars($referencename); ?></td>
                                <td><?php echo htmlspecialchars($referenceunit); ?></td>
                                <td><?php echo htmlspecialchars($referencerange); ?></td>
                                <td><?php echo htmlspecialchars($res6taxpercent); ?></td>
                                <td><?php echo htmlspecialchars($ipmarkup); ?></td>
                                <td><?php echo number_format($rateperunit, 2); ?></td>
                                <td><?php echo number_format($rate2, 2); ?></td>
                                <td><?php echo number_format($rate3, 2); ?></td>
                                <td><?php echo htmlspecialchars($location); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="labitem1interpret.php?st=del&&anum=<?php echo $auto_number; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirmDelete('<?php echo htmlspecialchars($itemname); ?>', this.href)">
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
                                <td colspan="15" class="empty-state">
                                    <i class="fas fa-flask"></i>
                                    <h3>No Items Found</h3>
                                    <p>No lab items match your search criteria.</p>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if($lastpage >= 1) { ?>
                <div class="pagination">
                    <?php if ($page > 1) { ?>
                        <a href="<?php echo $targetpage; ?>?labtemplate=<?php echo $labtemplate; ?>&searchflag1=<?php echo $searchflag1; ?>&search1=<?php echo $search1; ?>&page=<?php echo $prev; ?>">Previous</a>
                    <?php } else { ?>
                        <span class="disabled">Previous</span>
                    <?php } ?>
                    
                    <?php
                    if ($lastpage < 7 + ($adjacents * 2)) {
                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                            if ($counter == $page) {
                                echo "<span class=\"current\">$counter</span>";
                            } else {
                                echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=$counter\">$counter</a>";
                            }
                        }
                    } elseif($lastpage > 5 + ($adjacents * 2)) {
                        if($page < 1 + ($adjacents * 2)) {
                            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                if ($counter == $page) {
                                    echo "<span class=\"current\">$counter</span>";
                                } else {
                                    echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=$counter\">$counter</a>";
                                }
                            }
                            echo "...";
                            echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=$lpm1\">$lpm1</a>";
                            echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=$lastpage\">$lastpage</a>";
                        } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                            echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=1\">1</a>";
                            echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=2\">2</a>";
                            echo "...";
                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                if ($counter == $page) {
                                    echo "<span class=\"current\">$counter</span>";
                                } else {
                                    echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=$counter\">$counter</a>";
                                }
                            }
                            echo "...";
                            echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=$lpm1\">$lpm1</a>";
                            echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=$lastpage\">$lastpage</a>";
                        } else {
                            echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=1\">1</a>";
                            echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=2\">2</a>";
                            echo "...";
                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                if ($counter == $page) {
                                    echo "<span class=\"current\">$counter</span>";
                                } else {
                                    echo "<a href=\"$targetpage?labtemplate=$labtemplate&searchflag1=$searchflag1&search1=$search1&page=$counter\">$counter</a>";
                                }
                            }
                        }
                    }
                    ?>
                    
                    <?php if ($page < $lastpage) { ?>
                        <a href="<?php echo $targetpage; ?>?labtemplate=<?php echo $labtemplate; ?>&searchflag1=<?php echo $searchflag1; ?>&search1=<?php echo $search1; ?>&page=<?php echo $next; ?>">Next</a>
                    <?php } else { ?>
                        <span class="disabled">Next</span>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            
            <div class="data-section">
                <div class="data-header">
                    <h2 class="data-title">Deleted Items</h2>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Charges</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query2 = "select * from $labtemplate where status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if (mysqli_num_rows($exec2) > 0) {
                                while ($res2 = mysqli_fetch_array($exec2)) {
                                    $itemcode = $res2["itemcode"];
                                    $itemname = $res2["itemname"];
                                    $categoryname = $res2["categoryname"];
                                    $rateperunit = $res2["rateperunit"];
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
                                <td><?php echo htmlspecialchars($itemcode); ?></td>
                                <td><?php echo htmlspecialchars($categoryname); ?></td>
                                <td><?php echo htmlspecialchars($itemname); ?></td>
                                <td><?php echo number_format($rateperunit, 2); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="labitem1interpret.php?st=activate&&anum=<?php echo $auto_number; ?>" 
                                           class="btn btn-sm btn-success"
                                           onclick="return confirmActivate('<?php echo htmlspecialchars($itemname); ?>', this.href)">
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
                                <td colspan="5" class="empty-state">
                                    <i class="fas fa-trash"></i>
                                    <h3>No Deleted Items</h3>
                                    <p>There are no deleted items to display.</p>
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
    
    <script src="js/labitem1interpret-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
