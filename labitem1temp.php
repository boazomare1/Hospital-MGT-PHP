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

if (isset($_REQUEST['uploadexcel'])){
    if(!empty($_FILES['upload_file']))
    {
        $inputFileName = $_FILES['upload_file']['tmp_name'];
        include 'phpexcel/Classes/PHPExcel/IOFactory.php';
        
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $row = 1;
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
            
            foreach($rowData as $key=>$value)
            {
                if($rowData[$key] == 'Item Code') $itemcodenm = $key;
                if($rowData[$key] == 'Category') $categorynm = $key;
                if($rowData[$key] == 'Item Name') $itemnamenm = $key;
                if($rowData[$key] == 'Location') $locationnm = $key;
                if($rowData[$key] == 'Temp Name') $tempidnm = $key;
                if($rowData[$key] == 'Charges') $chargesnm = $key;
            }			
            
            for ($row = 2; $row <= $highestRow; $row++){ 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
                $itemcode=$rowData[$itemcodenm];	
                $category=$rowData[$categorynm];	
                $itemname=$rowData[$itemnamenm];
                $location=$rowData[$locationnm];
                $tempid=$rowData[$tempidnm];
                $charges=$rowData[$chargesnm];
                
                if($itemcode!="" )
                {
                    $query591 = "update $tempid set rateperunit='$charges' where itemcode = '$itemcode' and location='$location'";
                    $exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
    }
}

if (isset($_REQUEST['update'])){
    if (isset($_REQUEST['newserselect'])){$numrow = (sizeof($_REQUEST["newserselect"]))?sizeof($_REQUEST["newserselect"]):0;} else {$numrow=0;}
    
    if($numrow>0)
    {
        $itemcodes= $_REQUEST['newserselect'];
        
        for($i=0;$i<$numrow;$i++){
            $query1 = "select * from master_lab where itemcode = '".$itemcodes[$i]."' order by auto_number ";
            $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            while ($res1 = mysqli_fetch_array($exec3))
            {
                $itemcode = $res1["itemcode"];
                $itemname = $res1["itemname"];
                $categoryname = $res1["categoryname"];
                $description = $res1["description"];
                $purchaseprice = $res1["purchaseprice"];
                $rateperunit = $res1["rateperunit"];
                $expiryperiod = $res1["expiryperiod"];
                $sampletype= $res1["sampletype"];
                $location = $res1["location"];
                $referencename = $res1['referencename'];
                $referenceunit = $res1['referenceunit'];
                $referencerange = $res1['referencerange'];
                $itemname_abbreviation = $res1["itemname_abbreviation"];
                $taxname = $res1["taxname"];
                $taxanum = $res1["taxanum"];
                $ipmarkup = $res1["ipmarkup"];
                $rate2 = $res1['rate2'];
                $rate3 = $res1['rate3'];
                $displayname=$res1['displayname'];
                $criticallow=$res1['criticallow'];
                $criticalhigh=$res1['criticalhigh'];
                $status=$res1['status'];
                $referencevalue=$res1['referencevalue'];
                $locationname=$res1['locationname'];
                $pkg=$res1['pkg'];
                
                if ($expiryperiod != '0') 
                { 
                    $expiryperiod = $expiryperiod.' Months'; 
                }
                else
                {
                    $expiryperiod = ''; 
                }
                
                $query1 = "insert into $labtemplate (itemcode, itemname, categoryname,purchaseprice, rateperunit, rate2, expiryperiod, ipaddress, updatetime,location,ipmarkup, pkg,itemname_abbreviation,description, rate3,taxname,taxanum,displayname,sampletype,referencename,referenceunit,referencerange,criticallow,criticalhigh,status,referencevalue,locationname) 
                values ('$itemcode', '$itemname', '$categoryname','".$purchaseprice."', '".$rateperunit."','".$rate2."', '$expiryperiod', '$ipaddress', '$updatedatetime','".$location."','$ipmarkup','".$pkg."','$itemname_abbreviation','$description', '".$rate3."','$taxname','$taxanum','$displayname','$sampletype','$referencename','$referenceunit','$referencerange','$criticallow','$criticalhigh','$status','$referencevalue','$locationname')";
                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
        }
    }
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
    $delanum = $_REQUEST["anum"];
    $query3 = "update $labtemplate set status = 'deleted',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $query31 = "update master_lab set status = 'deleted',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
    $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'activate')
{
    $delanum = $_REQUEST["anum"];
    $query3 = "update $labtemplate set status = '',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $query31 = "update master_lab set status = '',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
    $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
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
    <title>Lab Item Template - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/labitem1temp-modern.css?v=<?php echo time(); ?>">
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
        <span>Lab Item Template</span>
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
                <h1 class="page-title">Lab Item Template Management</h1>
                <p class="page-subtitle">Manage laboratory test templates and bulk operations</p>
            </div>
            
            <div class="upload-section">
                <h2 class="upload-title">Template Operations</h2>
                <form method="post" enctype="multipart/form-data" class="upload-form">
                    <div class="form-group">
                        <label for="labtemplate" class="form-label">Select Template</label>
                        <select name="labtemplate" id="labtemplate" class="template-select" onchange="changeTemplate(this.value)">
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
                    </div>
                    <div class="form-group">
                        <label for="upload_file" class="form-label">Upload Excel File</label>
                        <input type="file" name="upload_file" id="upload_file" class="file-input" accept=".xlsx,.xls">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="uploadexcel" class="btn btn-primary">
                            <i class="fas fa-upload"></i>
                            Upload Excel
                        </button>
                        <a href="download_labitemtemp.php?labtemp=<?php echo $labtemplate; ?>" 
                           class="download-btn" 
                           target="_blank">
                            <i class="fas fa-download"></i>
                            Download Template
                        </a>
                    </div>
                </form>
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
                                <th>
                                    <input type="checkbox" onchange="toggleAll(this)" title="Select All">
                                </th>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Charges</th>
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
                                $sno = 0;
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $sno++;
                                    $itemcode = $res1["itemcode"];
                                    $itemname = $res1["itemname"];
                                    $categoryname = $res1["categoryname"];
                                    $rateperunit = $res1["rateperunit"];
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
                                <td class="checkbox-container">
                                    <input type="checkbox" name="newserselect[]" value="<?php echo htmlspecialchars($itemcode); ?>" class="checkbox-input">
                                </td>
                                <td><?php echo htmlspecialchars($itemcode); ?></td>
                                <td><?php echo htmlspecialchars($categoryname); ?></td>
                                <td><?php echo htmlspecialchars($itemname); ?></td>
                                <td>
                                    <div class="inline-display" id="caredittxno_<?php echo $sno;?>">
                                        <?php echo number_format($rateperunit, 2); ?>
                                    </div>
                                    <div class="inline-edit showit<?php echo $sno; ?>" style="display:none">
                                        <input type="text" 
                                               id="rateperunit<?php echo $sno; ?>" 
                                               name="rateperunit<?php echo $sno; ?>" 
                                               value="<?php echo $rateperunit; ?>" 
                                               size="6" />
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline hideit<?php echo $sno; ?>" 
                                                onclick="enablerate('<?php echo $sno; ?>')">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-primary showit<?php echo $sno; ?>" 
                                                style="display:none"
                                                onclick="updaterate('<?php echo $sno; ?>','<?php echo htmlspecialchars($itemcode); ?>')">
                                            <i class="fas fa-save"></i>
                                            Update
                                        </button>
                                        <a href="labitem1temp.php?st=del&&anum=<?php echo $auto_number; ?>" 
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
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-file-medical"></i>
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
                
                <?php if (mysqli_num_rows($exec1) > 0) { ?>
                <div style="padding: 1rem 2rem; background: var(--background-accent); border-top: 1px solid var(--border-color);">
                    <form method="post" action="">
                        <input type="hidden" name="labtemplate" value="<?php echo htmlspecialchars($labtemplate); ?>">
                        <button type="submit" name="update" class="btn btn-primary" disabled>
                            <i class="fas fa-plus"></i>
                            Add Selected Items to Template
                        </button>
                    </form>
                </div>
                <?php } ?>
                
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
                                        <a href="labitem1temp.php?st=activate&&anum=<?php echo $auto_number; ?>" 
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
    
    <script src="js/labitem1temp-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
