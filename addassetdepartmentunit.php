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

$docno = $_SESSION['docno'];

// Get default location
$query = "select * from master_location where status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

// Get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1') {
    $department = $_REQUEST["department"];
    $department = strtoupper($department);
    $department = trim($department);
    $length = strlen($department);
    
    $query1 = "select locationname from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    
    $locationname = $res1["locationname"];	
    $serunit = $_REQUEST['serunit'];
    
    for($i=1; $i<$serunit; $i++) {	
        if(isset($_REQUEST['unit'.$i])) {
            $unit = $_REQUEST['unit'.$i];
            if($unit != '') {
                $query1 = "insert into master_assetdepartment (department, ipaddress, recorddate, username, unit, locationcode, locationname) 
                           values ('$department', '$ipaddress', '$updatedatetime', '$username', '$unit', '".$locationcode."', '".$locationname."')";
                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                $errmsg = "Success. New Department Added.";
                $bgcolorcode = 'success';
            }	
        }	
    }
    
    header('location:addassetdepartmentunit.php');
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_assetdepartment set recordstatus = 'deleted' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: addassetdepartmentunit.php?msg=deleted");
    exit();
}

if ($st == 'activate') {
    $delanum = $_REQUEST["anum"];
    $query3 = "update master_assetdepartment set recordstatus = '' where auto_number = '$delanum'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: addassetdepartmentunit.php?msg=activated");
    exit();
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        $errmsg = "Department deleted successfully.";
        $bgcolorcode = 'success';
    } elseif ($_GET['msg'] == 'activated') {
        $errmsg = "Department activated successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Department & Unit Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addassetdepartmentunit-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Asset Department & Unit Master</span>
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
                        <a href="addassetdepartmentunit.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Asset Department</span>
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
                    <h2>Asset Department & Unit Master</h2>
                    <p>Manage asset departments and their associated units across different locations.</p>
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
                    <h3 class="add-form-title">Add New Department & Units</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="addassetdepartmentunit.php" onSubmit="return addward1process1()" class="add-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <?php
                                $query1 = "select * from master_location where status <> 'deleted' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $res1locationanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $res1locationanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($res1location); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="department" class="form-label">Department Name</label>
                            <input name="department" id="department" class="form-input" 
                                   placeholder="Enter department name" style="text-transform:uppercase" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unit" class="form-label">Add New Unit</label>
                        <div class="unit-input-group">
                            <input name="unit" id="unit" class="form-input" 
                                   placeholder="Enter unit name" style="text-transform:uppercase" />
                            <button type="button" name="addunit" id="addunit" class="btn btn-secondary">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                    </div>

                    <!-- Dynamic Units Container -->
                    <div class="units-container">
                        <h4>Added Units</h4>
                        <div id="unitadd" class="units-list">
                            <!-- Units will be added here dynamically -->
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="serunit" id="serunit" value="1">
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Submit
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
                    <h3 class="data-table-title">Existing Departments & Units</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Department</th>
                            <th>Location</th>
                            <th>Unit</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="departmentTableBody">
                        <?php
                        $query1 = "select * from master_assetdepartment where recordstatus <> 'deleted' order by department";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $colorloopcount = 0;
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $department = $res1["department"];
                            $auto_number = $res1["auto_number"];
                            $unit = $res1['unit'];
                            $locationname = $res1['locationname'];
                            
                            $colorloopcount++;
                            ?>
                            <tr>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="confirmDelete('<?php echo htmlspecialchars($department); ?>', '<?php echo $auto_number; ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="department-badge"><?php echo htmlspecialchars($department); ?></span>
                                </td>
                                <td>
                                    <span class="location-badge"><?php echo htmlspecialchars($locationname); ?></span>
                                </td>
                                <td>
                                    <span class="unit-badge"><?php echo htmlspecialchars($unit); ?></span>
                                </td>
                                <td>
                                    <a href="editassetdepartmentunit.php?st=edit&&anum=<?php echo $auto_number; ?>" 
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
                    <h3 class="deleted-items-title">Deleted Departments</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Department</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody id="deletedDepartmentTableBody">
                        <?php
                        $query1 = "select * from master_assetdepartment where recordstatus = 'deleted' order by department";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $department = $res1["department"];
                            $auto_number = $res1["auto_number"];
                            $unit = $res1['unit'];
                            ?>
                            <tr>
                                <td>
                                    <button class="action-btn activate" 
                                            onclick="confirmActivate('<?php echo htmlspecialchars($department); ?>', '<?php echo $auto_number; ?>')"
                                            title="Activate">
                                        <i class="fas fa-undo"></i> Activate
                                    </button>
                                </td>
                                <td><?php echo htmlspecialchars($department); ?></td>
                                <td><?php echo htmlspecialchars($unit); ?></td>
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
    <script src="js/addassetdepartmentunit-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    
    <script language="javascript">
    $(function() {
        $('#addunit').click(function() {  
            var varunit = $('#unit').val();
            varunit = varunit.toUpperCase();
            var sno = $('#serunit').val();
            
            if(varunit != ''){
                var unitbuild = '';
                unitbuild = unitbuild+'<tr id="TR'+sno+'">';
                unitbuild = unitbuild+'<td class="unit-label">Unit</td>';
                unitbuild = unitbuild+'<td class="unit-input">';
                unitbuild = unitbuild+'<input name="unit'+sno+'" id="unit'+sno+'" value="'+varunit+'" class="form-input" style="text-transform:uppercase;" />&nbsp;';
                unitbuild = unitbuild+'<button type="button" id="delunit'+sno+'" class="btn btn-danger" onClick="return DelUnit('+sno+')">';
                unitbuild = unitbuild+'<i class="fas fa-trash"></i> Delete</button></td>';
                unitbuild = unitbuild+'</tr>';
                
                $('#unitadd').append(unitbuild);
                $('#unit').val('');
                var ino = parseFloat($('#serunit').val()) + parseFloat(1);
                $('#serunit').val(ino);
            }
        });
    });

    function DelUnit(id) {
        if(id != ''){
            var child1 = document.getElementById('TR'+id);
            if (child1 != null) {
                document.getElementById('unitadd').removeChild(child1);
            }
        }
    }

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
        if (document.form1.department.value == "") {
            alert("Please Enter Department Name.");
            document.form1.department.focus();
            return false;
        }
        
        var serunit = document.getElementById("serunit").value;
        var unitflg = false;
        
        for(var i=1; i<=serunit; i++) {
            if(document.getElementById("unit"+i) != null) {	
                var unitflg = true;
            }
        }
        
        if(unitflg == false) {
            alert("Enter Department Unit");
            document.getElementById("unit").focus();
            return false;
        }
    }

    function funcDeleteDepartment1(varDepartmentAutoNumber) {
        var varDepartmentAutoNumber = varDepartmentAutoNumber;
        var fRet;
        fRet = confirm('Are you sure want to delete this Department '+varDepartmentAutoNumber+'?');
        
        if (fRet == true) {
            alert("Department Entry Delete Completed.");
        }
        if (fRet == false) {
            alert("Department Entry Delete Not Completed.");
            return false;
        }
    }
    </script>
</body>
</html>



