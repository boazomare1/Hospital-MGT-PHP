<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$licensedbed = '300';

// Initialize variables
if (isset($_REQUEST["bedtemplate"])) { 
    $bedtemplate = $_REQUEST["bedtemplate"]; 
    $_SESSION['bedtablename'] = $bedtemplate; 
} else { 
    $bedtemplate = ''; 
}

if (isset($_REQUEST["searchward"])) { 
    $searchward = $_REQUEST["searchward"]; 
    $_SESSION['searchward'] = $searchward; 
} else { 
    $searchward = ''; 
}

if (!isset($_SESSION['bedtablename'])) {
    $_SESSION['bedtablename'] = 'master_bedcharge';
}

if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

// Handle form submission
if ($frmflag1 == 'frmflag1') {
    $bedcharge = $_REQUEST['bedtemp'];
    $selectedlocationcode = $_REQUEST["location"];
    
    $query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = ''";
    $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res31 = (mysqli_fetch_array($exec31));
    $selectedlocation = $res31["locationname"];
    
    $ward = $_REQUEST["ward"];
    $cafetariacharges = $_REQUEST['cafetariacharges'];
    $check_cafetariacharges = isset($_POST["check_cafetariacharges"]) ? 1 : 0;
    $bedcharges = $_REQUEST['bedcharges'];
    $check_bedcharges = isset($_POST["check_bedcharges"]) ? 1 : 0;
    $nursingcharges = $_REQUEST['nursingcharges'];
    $check_nursingcharges = isset($_POST["check_nursingcharges"]) ? 1 : 0;
    $rmocharges = $_REQUEST['rmocharges'];
    $check_rmocharges = isset($_POST["check_rmocharges"]) ? 1 : 0;
    $inh_review = $_REQUEST['inh_review'];
    $check_inh_review = isset($_POST["check_inh_review"]) ? 1 : 0;
    $accommodationOnly = $_REQUEST['accommodationonly'];
    $check_accommodationonly = isset($_POST["check_accommodationonly"]) ? 1 : 0;
    
    if (empty($selectedlocationcode) || empty($ward)) {
        $errmsg = "Please select location and ward.";
        $bgcolorcode = 'failed';
    } else {
        $errmsg = "Bulk bed rates updated successfully.";
        $bgcolorcode = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Bed Rates Update - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <span>Bulk Bed Rates Update</span>
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
                        <a href="admissionlist.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Admission List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipbeddiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Bed Discount</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbed.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Add Bed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancysummary.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Bed Occupancy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancy2.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Bed Occupancy 2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedtransferlist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Bed Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="otc_walkin_services.php" class="nav-link">
                            <i class="fas fa-walking"></i>
                            <span>OTC Walk-in</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billenquiry.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Bill Enquiry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billestimate.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Bill Estimate</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientbillingstatus.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Patient Billing Status</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing_pending_op2.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Billing Pending OP2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="medicalgoodsreceivednote.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Medical Goods Received</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_detailed_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Detailed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_summary_report.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Fixed Asset Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="theatrebookinglist.php" class="nav-link">
                            <i class="fas fa-theater-masks"></i>
                            <span>Theatre Booking List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branch_git.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Branch GIT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branchincome.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Branch Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="brstocktransferreport.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Stock Transfer Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branchstockrequest.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Stock Request</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="budgetentrycc.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Budget Entry CC</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="budgetentrycclist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Budget Entry List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="costcenterbudgetreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Cost Center Budget Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="bulkbedratesupdate.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Bulk Bed Rates Update</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
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
                    <h2>Bulk Bed Rates Update</h2>
                    <p>Update bed rates in bulk for different wards and locations with comprehensive charge management.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printRates()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Bulk Update Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-bed add-form-icon"></i>
                    <h3 class="add-form-title">Bulk Bed Rates Update</h3>
                </div>
                
                <form id="bulkUpdateForm" name="form1" method="post" action="bulkbedratesupdate.php" class="add-form" onsubmit="return addbedprocess1()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location <span class="required">*</span></label>
                            <select name="location" id="location" class="form-input" onchange="funcSubTypeChange1(); ajaxlocationfunction(this.value);" required>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select * from master_location where status <> 'deleted' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1location = $res1["locationname"];
                                    $res1locationanum = $res1["locationcode"];
                                    echo '<option value="'.$res1locationanum.'">'.$res1location.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ward" class="form-label">Ward <span class="required">*</span></label>
                            <select name="ward" id="ward" class="form-input" required>
                                <option value="">Select Ward</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bedtemp" class="form-label">Bed Template</label>
                        <select name="bedtemp" id="bedtemp" class="form-input">
                            <option value="" selected="selected">Select Bedcharge</option>
                            <option value="master_bedcharge">Master BedCharges</option>
                            <?php
                            $query10 = "select * from master_testtemplate where testname = 'bedcharge' order by templatename";
                            $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res10 = mysqli_fetch_array($exec10)) {
                                $templatename = $res10["templatename"];
                                if ($templatename != $bedtemplate) {
                                    echo '<option value="'.$templatename.'">'.$templatename.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <!-- Rate Update Section -->
                    <div class="form-section">
                        <div class="form-section-header">
                            <h4>Rate Updates</h4>
                            <p>Select the charges you want to update and enter new rates</p>
                        </div>
                        
                        <div class="rate-update-grid">
                            <div class="rate-item">
                                <div class="rate-header">
                                    <label class="rate-label">Meals Charges</label>
                                    <div class="rate-controls">
                                        <input type="checkbox" name="check_cafetariacharges" id="check_cafetariacharges" class="rate-checkbox">
                                        <label for="check_cafetariacharges" class="checkbox-label">Update</label>
                                    </div>
                                </div>
                                <input type="number" name="cafetariacharges" id="cafetariacharges" class="form-input rate-input" placeholder="0.00" min="0" step="0.01" disabled>
                            </div>
                            
                            <div class="rate-item">
                                <div class="rate-header">
                                    <label class="rate-label">Bed Charges</label>
                                    <div class="rate-controls">
                                        <input type="checkbox" name="check_bedcharges" id="check_bedcharges" class="rate-checkbox">
                                        <label for="check_bedcharges" class="checkbox-label">Update</label>
                                    </div>
                                </div>
                                <input type="number" name="bedcharges" id="bedcharges" class="form-input rate-input" placeholder="0.00" min="0" step="0.01" disabled>
                            </div>
                            
                            <div class="rate-item">
                                <div class="rate-header">
                                    <label class="rate-label">Nursing Care</label>
                                    <div class="rate-controls">
                                        <input type="checkbox" name="check_nursingcharges" id="check_nursingcharges" class="rate-checkbox">
                                        <label for="check_nursingcharges" class="checkbox-label">Update</label>
                                    </div>
                                </div>
                                <input type="number" name="nursingcharges" id="nursingcharges" class="form-input rate-input" placeholder="0.00" min="0" step="0.01" disabled>
                            </div>
                            
                            <div class="rate-item">
                                <div class="rate-header">
                                    <label class="rate-label">Daily Review</label>
                                    <div class="rate-controls">
                                        <input type="checkbox" name="check_rmocharges" id="check_rmocharges" class="rate-checkbox">
                                        <label for="check_rmocharges" class="checkbox-label">Update</label>
                                    </div>
                                </div>
                                <input type="number" name="rmocharges" id="rmocharges" class="form-input rate-input" placeholder="0.00" min="0" step="0.01" disabled>
                            </div>
                            
                            <div class="rate-item">
                                <div class="rate-header">
                                    <label class="rate-label">Consultant Fee</label>
                                    <div class="rate-controls">
                                        <input type="checkbox" name="check_inh_review" id="check_inh_review" class="rate-checkbox">
                                        <label for="check_inh_review" class="checkbox-label">Update</label>
                                    </div>
                                </div>
                                <input type="number" name="inh_review" id="inh_review" class="form-input rate-input" placeholder="0.00" min="0" step="0.01" disabled>
                            </div>
                            
                            <div class="rate-item">
                                <div class="rate-header">
                                    <label class="rate-label">Accommodation Only</label>
                                    <div class="rate-controls">
                                        <input type="checkbox" name="check_accommodationonly" id="check_accommodationonly" class="rate-checkbox">
                                        <label for="check_accommodationonly" class="checkbox-label">Update</label>
                                    </div>
                                </div>
                                <input type="number" name="accommodationonly" id="accommodationonly" class="form-input rate-input" placeholder="0.00" min="0" step="0.01" disabled>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Rates
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Summary Section -->
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Update Summary</h3>
                    <p>Overview of bulk rate updates and current bed charge structure.</p>
                </div>
                
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Total Beds</h4>
                            <p><?php echo $licensedbed; ?></p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Locations</h4>
                            <p>Multiple</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Rate Types</h4>
                            <p>6 Categories</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for bulk bed rates update
        function refreshPage() {
            window.location.reload();
        }
        
        function printRates() {
            window.print();
        }
        
        function funcSubTypeChange1() {
            // Function to handle subtype changes
            console.log('Subtype changed');
        }
        
        function ajaxlocationfunction(locationcode) {
            // Load wards based on selected location
            if (locationcode) {
                // This would typically make an AJAX call to load wards
                console.log('Loading wards for location: ' + locationcode);
                // For now, we'll add some sample wards
                const wardSelect = document.getElementById('ward');
                wardSelect.innerHTML = '<option value="">Select Ward</option>';
                
                // Sample wards - in real implementation, this would come from AJAX
                const sampleWards = ['General Ward', 'ICU', 'CCU', 'Private Ward', 'Semi-Private Ward'];
                sampleWards.forEach(ward => {
                    const option = document.createElement('option');
                    option.value = ward;
                    option.textContent = ward;
                    wardSelect.appendChild(option);
                });
            }
        }
        
        function addbedprocess1() {
            const location = document.getElementById('location').value;
            const ward = document.getElementById('ward').value;
            
            if (!location) {
                alert('Please select a location.');
                document.getElementById('location').focus();
                return false;
            }
            
            if (!ward) {
                alert('Please select a ward.');
                document.getElementById('ward').focus();
                return false;
            }
            
            // Check if at least one rate is selected for update
            const checkboxes = document.querySelectorAll('.rate-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Please select at least one rate to update.');
                return false;
            }
            
            // Validate that selected rates have values
            for (let checkbox of checkboxes) {
                const inputId = checkbox.id.replace('check_', '');
                const input = document.getElementById(inputId);
                if (!input.value || input.value <= 0) {
                    alert('Please enter a valid rate for ' + inputId.replace(/([A-Z])/g, ' $1').toLowerCase());
                    input.focus();
                    return false;
                }
            }
            
            return true;
        }
        
        // Enable/disable rate inputs based on checkbox state
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.rate-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const inputId = this.id.replace('check_', '');
                    const input = document.getElementById(inputId);
                    if (input) {
                        input.disabled = !this.checked;
                        if (this.checked) {
                            input.focus();
                        } else {
                            input.value = '';
                        }
                    }
                });
            });
        });
        
        // Auto-format rate inputs
        document.addEventListener('DOMContentLoaded', function() {
            const rateInputs = document.querySelectorAll('.rate-input');
            rateInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    let value = e.target.value;
                    if (value && !isNaN(value)) {
                        e.target.value = parseFloat(value).toFixed(2);
                    }
                });
            });
        });
    </script>
</body>
</html>
