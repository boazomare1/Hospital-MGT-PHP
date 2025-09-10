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

if ($frmflag1 == 'frmflag1')

{



	$department = $_REQUEST["department"];

	$department = strtoupper($department);

	$department = trim($department);

	$length=strlen($department);

	$rate1 = $_REQUEST['rate1'];

	$rate2 = $_REQUEST['rate2'];

	$rate3 = $_REQUEST['rate3'];

	$skiptriage = isset($_REQUEST['skiptriage'])?'1':'0';	

	

	$query1 = "select * from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						$locationname = $res1["locationname"];

						

	//echo $length;

	if ($length<=100)

	{

	$query2 = "select * from master_department where department = '$department'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query1 = "insert into master_department (department, ipaddress, recorddate, username,rate1,rate2,rate3,locationcode,locationname,skiptriage) 

		values ('$department', '$ipaddress', '$updatedatetime', '$username','$rate1','$rate2','$rate3','".$locationcode."','".$locationname."','$skiptriage')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Department Updated.";

		$bgcolorcode = 'success';

		

	}

	//exit();

	else

	{

		$errmsg = "Failed. Department Already Exists.";

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

	$query3 = "update master_department set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_department set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_department set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_department set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_department set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}





if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Department To Proceed For Billing.";

	$bgcolorcode = 'failed';

}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/adddepartment1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<script language="javascript">



function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here



function addward1process1()

{

	//alert ("Inside Funtion");

	if (document.form1.department.value == "")

	{

		alert ("Pleae Enter Department Name.");

		document.form1.department.focus();

		return false;

	}

}



function funcDeleteDepartment1(varDepartmentAutoNumber)

{



     var varDepartmentAutoNumber = varDepartmentAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Department '+varDepartmentAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Department  Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Department Entry Delete Not Completed.");

		return false;

	}



}

/*this is for numbers only */

	function noDecimal(evt) {



  

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (charCode > 31 && (charCode < 48 || charCode > 57)  )

  return false;

        else 

        return true;





}





//onkeypress="return noDecimal(event);"

</script>

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
        <span>Department Master</span>
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
                        <a href="adddepartment1.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Department Master</span>
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
                    <h2>Department Master</h2>
                    <p>Manage hospital departments with rates and configurations for different locations.</p>
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
                    <h3 class="add-form-title">Add New Department</h3>
                </div>
                
                <form id="departmentForm" name="form1" method="post" action="adddepartment1.php" class="add-form">

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
                        <input type="text" name="department" id="department" class="form-input" 
                               placeholder="Enter department name (e.g., Cardiology, Neurology)" 
                               style="text-transform: uppercase;" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="rate1" class="form-label">Rate 1</label>
                        <input type="number" name="rate1" id="rate1" class="form-input" 
                               placeholder="Enter rate 1" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label for="rate2" class="form-label">Rate 2</label>
                        <input type="number" name="rate2" id="rate2" class="form-input" 
                               placeholder="Enter rate 2" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label for="rate3" class="form-label">Rate 3</label>
                        <input type="number" name="rate3" id="rate3" class="form-input" 
                               placeholder="Enter rate 3" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="skiptriage" id="skiptriage" class="checkbox-input">
                            <span class="checkbox-text">Skip Triage</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Add Department
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag" value="addnew">
                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Existing Departments</h3>
                </div>

                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="searchInput" class="form-input" 
                               placeholder="Search departments..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="searchDepartments(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Location</th>
                            <th>Rate 1</th>
                            <th>Rate 2</th>
                            <th>Rate 3</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="departmentTableBody">

                        <?php
                        $query1 = "select * from master_department where recordstatus <> 'deleted' order by auto_number";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $colorloopcount = 0;
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $department = $res1["department"];
                            $auto_number = $res1["auto_number"];
                            $rate1 = $res1['rate1'];
                            $rate2 = $res1['rate2'];
                            $rate3 = $res1['rate3'];
                            $locationname = $res1['locationname'];
                            $colorloopcount++;
                            ?>
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td><?php echo htmlspecialchars($department); ?></td>
                                <td><?php echo htmlspecialchars($locationname); ?></td>
                                <td><?php echo number_format($rate1, 2); ?></td>
                                <td><?php echo number_format($rate2, 2); ?></td>
                                <td><?php echo number_format($rate3, 2); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="confirmDelete('<?php echo htmlspecialchars($department); ?>', '<?php echo $auto_number; ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="editdepartment1.php?st=edit&anum=<?php echo $auto_number; ?>" 
                                           class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div id="paginationContainer" style="margin-top: 1rem; text-align: center;">
                    <div class="pagination-controls">
                        <button id="prevBtn" class="btn btn-outline" onclick="changePage(-1)" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <span id="pageInfo" class="page-info">Page 1 of 1</span>
                        <button id="nextBtn" class="btn btn-outline" onclick="changePage(1)" disabled>
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="pagination-info">
                        <span id="recordInfo">Showing 0 of 0 records</span>
                    </div>
                </div>
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
                        </tr>
                    </thead>
                    <tbody id="deletedDepartmentTableBody">
                        <?php
                        $query1 = "select * from master_department where recordstatus = 'deleted' order by department";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $department = $res1['department'];
                            $auto_number = $res1["auto_number"];
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
    <script src="js/adddepartment1-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Pagination JavaScript -->
    <script>
        let currentPage = 1;
        const recordsPerPage = 5;
        let allRecords = [];
        let filteredRecords = [];

        // Initialize pagination when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializePagination();
        });

        function initializePagination() {
            // Get all table rows (excluding header)
            const tableBody = document.getElementById('departmentTableBody');
            const rows = Array.from(tableBody.querySelectorAll('tr'));
            
            allRecords = rows.map((row, index) => ({
                element: row,
                originalIndex: index
            }));
            
            filteredRecords = [...allRecords];
            updatePagination();
        }

        function updatePagination() {
            const totalRecords = filteredRecords.length;
            const totalPages = Math.ceil(totalRecords / recordsPerPage);
            
            // Update page info
            document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
            document.getElementById('recordInfo').textContent = `Showing ${Math.min((currentPage - 1) * recordsPerPage + 1, totalRecords)}-${Math.min(currentPage * recordsPerPage, totalRecords)} of ${totalRecords} records`;
            
            // Update button states
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;
            
            // Show/hide records based on current page
            showPageRecords();
        }

        function showPageRecords() {
            const tableBody = document.getElementById('departmentTableBody');
            
            // Hide all records first
            allRecords.forEach(record => {
                record.element.style.display = 'none';
            });
            
            // Show records for current page
            const startIndex = (currentPage - 1) * recordsPerPage;
            const endIndex = startIndex + recordsPerPage;
            
            for (let i = startIndex; i < endIndex && i < filteredRecords.length; i++) {
                filteredRecords[i].element.style.display = '';
            }
        }

        function changePage(direction) {
            const totalPages = Math.ceil(filteredRecords.length / recordsPerPage);
            const newPage = currentPage + direction;
            
            if (newPage >= 1 && newPage <= totalPages) {
                currentPage = newPage;
                updatePagination();
            }
        }

        function searchDepartments(searchTerm) {
            const tableBody = document.getElementById('departmentTableBody');
            const rows = Array.from(tableBody.querySelectorAll('tr'));
            
            filteredRecords = allRecords.filter(record => {
                const text = record.element.textContent.toLowerCase();
                return text.includes(searchTerm.toLowerCase());
            });
            
            currentPage = 1; // Reset to first page
            updatePagination();
        }

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            filteredRecords = [...allRecords];
            currentPage = 1;
            updatePagination();
        }

        function refreshPage() {
            location.reload();
        }

        function exportToExcel() {
            // Simple CSV export functionality
            const table = document.querySelector('.data-table');
            const rows = Array.from(table.querySelectorAll('tr'));
            let csv = [];
            
            rows.forEach(row => {
                const cells = Array.from(row.querySelectorAll('th, td'));
                const rowData = cells.map(cell => `"${cell.textContent.trim()}"`).join(',');
                csv.push(rowData);
            });
            
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'departments.csv';
            a.click();
            window.URL.revokeObjectURL(url);
        }

        function resetForm() {
            document.getElementById('departmentForm').reset();
        }

        function confirmDelete(departmentName, autoNumber) {
            if (confirm(`Are you sure you want to delete the department "${departmentName}"?`)) {
                window.location.href = `adddepartment1.php?st=del&anum=${autoNumber}`;
            }
        }

        function confirmActivate(departmentName, autoNumber) {
            if (confirm(`Are you sure you want to activate the department "${departmentName}"?`)) {
                window.location.href = `adddepartment1.php?st=activate&anum=${autoNumber}`;
            }
        }

        // AJAX function for location updates
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
            xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
            xmlhttp.send();
        }
    </script>
</body>
</html>



