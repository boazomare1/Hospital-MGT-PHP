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

// Handle form submission
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

if ($frmflag1 == 'frmflag1') {
	$drug_inst = $_REQUEST["drug_inst"];
	$drug_inst = trim($drug_inst);
    $length = strlen($drug_inst);

    if ($length <= 100) {
        $drug_inst = strtolower($drug_inst);
        $drug_inst = ucwords($drug_inst);
        
	$query2 = "select id from drug_instructions where name = '$drug_inst'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);

        if ($res2 == 0) {
            $query1 = "insert into drug_instructions (`name`, `ipaddress`, `username`, `created_on`) values ('$drug_inst', '$ipaddress', '$username','$updatedatetime')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Drug Instruction was Created.";
		$bgcolorcode = 'success';
        } else {
		$errmsg = "Failed. Drug Instruction Already Exists.";
		$bgcolorcode = 'failed';
        }
    } else {
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
    }
}



// Handle delete action
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'del') {
	$delanum = $_REQUEST["anum"];
	$query3 = "update drug_instructions set status = '0' where id = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: drug_instructions.php?msg=deleted");
    exit();
}

if ($st == 'activate') {
	$delanum = $_REQUEST["anum"];
	$query3 = "update drug_instructions set status = '1' where id = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    header("Location: drug_instructions.php?msg=activated");
    exit();
}

// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        $errmsg = "Drug instruction deleted successfully.";
        $bgcolorcode = 'success';
    } elseif ($_GET['msg'] == 'activated') {
        $errmsg = "Drug instruction activated successfully.";
        $bgcolorcode = 'success';
    }
}

/*if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update product_type set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());



	$query5 = "update master_salutation set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

}*/

/*if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_salutation set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());

}

*/









?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Instructions Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/druginstructions-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<script language="javascript">



function addsalutation1process1()

{

	//alert ("Inside Funtion");

	var drug_inst = document.form1.drug_inst.value;

	drug_inst = drug_inst.replace(/^\s+|\s+$/g, '' );

	if(drug_inst == "")

	{

		alert ("Please Enter Drug Instructions.");

		document.form1.drug_inst.focus();

		return false;

	}

	

}



function funcDeleteProductType(varNameAutoNumber)

{

     var varNameAutoNumber = varNameAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Drug Instruction '+varNameAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Drug Instruction Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Drug Instruction Entry Delete Not Completed.");

		return false;

	}



}







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
        <span>Drug Instructions Master</span>
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
                    <li class="nav-item">
                        <a href="drugcategoryissues.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Drug Category Issues</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="drug_instructions.php" class="nav-link">
                            <i class="fas fa-prescription-bottle-alt"></i>
                            <span>Drug Instructions</span>
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
                    <h2>Drug Instructions Master</h2>
                    <p>Manage drug instructions and dosage guidelines for pharmacy operations.</p>
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
                    <h3 class="add-form-title">Add New Drug Instruction</h3>
                </div>
                
                <form id="drugInstructionsForm" name="form1" method="post" action="drug_instructions.php" class="add-form">

                    <div class="form-group">
                        <label for="drug_inst" class="form-label">Drug Instruction</label>
                        <input type="text" name="drug_inst" id="drug_inst" class="form-input" 
                               placeholder="Enter drug instruction (e.g., Take with food, Take on empty stomach)" 
                               maxlength="100" required>
                        <small class="form-help">Maximum 100 characters allowed</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Add Drug Instruction
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Existing Drug Instructions</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Actions</th>
                            <th>Drug Instruction</th>
                            <th>Edit</th>
                      </tr>
                    </thead>
                    <tbody id="drugInstructionsTableBody">
                      <?php
                        $query1 = "select id,name from drug_instructions where status='1' order by id desc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $colorloopcount = 0;

                        while ($res1 = mysqli_fetch_array($exec1)) {
		$drug_inst = $res1["name"];
		$auto_number = $res1["id"];
                            $colorloopcount++;
                            ?>
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn delete" 
                                                onclick="confirmDelete('<?php echo htmlspecialchars($drug_inst); ?>', '<?php echo $auto_number; ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="instruction-text"><?php echo htmlspecialchars($drug_inst); ?></span>
                                </td>
                                <td>
                                    <a href="edit_drug_instructions.php?st=edit&anum=<?php echo $auto_number; ?>" 
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
                    <h3 class="deleted-items-title">Deleted Drug Instructions</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Drug Instruction</th>
                      </tr>
                    </thead>
                    <tbody id="deletedDrugInstructionsTableBody">
                      <?php
                        $query1 = "select id,name from drug_instructions where status = 0 order by id desc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

                        while ($res1 = mysqli_fetch_array($exec1)) {
		$drug_inst = $res1['name'];
		$auto_number = $res1["id"];
                            ?>
                            <tr>
                                <td>
                                    <button class="action-btn activate" 
                                            onclick="confirmActivate('<?php echo htmlspecialchars($drug_inst); ?>', '<?php echo $auto_number; ?>')"
                                            title="Activate">
                                        <i class="fas fa-undo"></i> Activate
                                    </button>
                                </td>
                                <td>
                                    <span class="instruction-text"><?php echo htmlspecialchars($drug_inst); ?></span>
                                </td>
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
    <script src="js/druginstructions-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>




