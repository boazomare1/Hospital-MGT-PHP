<?php
session_start();
set_time_limit(0);

if (!isset($_SESSION["username"])) header ("location:index.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];
$curdate = date('Y-m-d');
$currenttime = date("H:i:s");
$updatedatetime = date ("d-m-Y H:i:s");
$errmsg = "";
$bgcolorcode = "";
$pagename = "";

$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

$patientcode = '';
$visitcode = '';
$companyanum = $_SESSION["companyanum"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

// Get form data
$subtype = isset($_REQUEST["billtype"]) ? $_REQUEST["billtype"] : '';
$patientcode = isset($_REQUEST["patientcode"]) ? $_REQUEST["patientcode"] : '';
$visitcode = isset($_REQUEST["visitcode"]) ? $_REQUEST["visitcode"] : '';

// Get subtype information
if ($subtype) {
    $query5 = "select subtype,auto_number from master_subtype where auto_number='$subtype'";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res5 = mysqli_fetch_array($exec5);
    $subtype_name = $res5["subtype"];
    $subtype_no = $res5["auto_number"];
} else {
    $subtype_name = '';
    $subtype_no = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bill Estimate</title>
<!-- Modern CSS -->
<link href="css/billestimate-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Modern Header -->
    <header class="hospital-header">
        <div class="hospital-title">MedStar Hospital Management</div>
        <div class="hospital-subtitle">Bill Estimate</div>
    </header>

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
                        <a href="billestimate.php" class="nav-link active">
                            <i class="fas fa-calculator"></i>
                            <span>Bill Estimate</span>
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
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Bill Estimate</h1>
                <p class="page-subtitle">Create detailed cost estimates for patient treatments and procedures</p>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <i class="fas fa-calculator"></i>
                    Estimate Details
                </div>
                
                <form name="form1" id="form1" method="post" action="billestimate.php">
                    <div class="form-content">
                        <!-- Patient Information Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-user"></i>
                                Patient Information
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="patientcode">Patient Code</label>
                                    <input type="text" name="patientcode" id="patientcode" class="form-control" value="<?php echo htmlspecialchars($patientcode); ?>" placeholder="Enter patient code" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="visitcode">Visit Code</label>
                                    <input type="text" name="visitcode" id="visitcode" class="form-control" value="<?php echo htmlspecialchars($visitcode); ?>" placeholder="Enter visit code" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="subtype">Subtype</label>
                                    <input type="text" name="maintypesearch" id="maintypesearch" class="form-control" value="<?php echo htmlspecialchars($subtype_name); ?>" placeholder="Subtype" readonly>
                                    <input type="hidden" name="subtype" id="subtype" value="<?php echo $subtype; ?>">
                                    <input type="hidden" name="maintype" id="maintype" value="<?php echo $subtype_no; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($locationname); ?>" readonly>
                                    <input type="hidden" name="locationnameget" id="locationname" value="<?php echo $locationname; ?>">
                                    <input type="hidden" name="locationcodeget" id="locationcode" value="<?php echo $locationcode; ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Prescription Section -->
                        <div class="prescription-container">
                            <div class="prescription-header">
                                <i class="fas fa-prescription-bottle-alt"></i>
                                Prescription Items
                                <button type="button" id="addRowBtn" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i>
                                    Add Item
                                </button>
                            </div>
                            
                            <div class="prescription-content">
                                <table class="prescription-table">
                                    <thead>
                                        <tr>
                                            <th>Medicine Name</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="prescription-row">
                                            <td>
                                                <input type="text" class="medicine-name" name="medicinename_1" placeholder="Medicine name">
                                            </td>
                                            <td>
                                                <input type="number" class="quantity" name="quantity_1" min="1" value="1" onchange="calculateRowAmount(this.closest('tr'))">
                                            </td>
                                            <td>
                                                <input type="number" class="rate" name="rate_1" min="0" step="0.01" value="0" onchange="calculateRowAmount(this.closest('tr'))">
                                            </td>
                                            <td>
                                                <input type="number" class="amount" name="amount_1" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="action-btn remove" onclick="removePrescriptionRow(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Summary Section -->
                        <div class="summary-cards">
                            <div class="summary-card total">
                                <div class="summary-card-icon total">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div class="summary-card-value" id="totalAmount">₹ 0.00</div>
                                <div class="summary-card-label">Total Amount</div>
                            </div>
                            
                            <div class="summary-card discount">
                                <div class="summary-card-icon discount">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="summary-card-value">₹ 0.00</div>
                                <div class="summary-card-label">Discount</div>
                            </div>
                            
                            <div class="summary-card net">
                                <div class="summary-card-icon net">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="summary-card-value">₹ 0.00</div>
                                <div class="summary-card-label">Net Amount</div>
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $subtype; ?>">
                        <input type="hidden" name="billtypes" id="billtypes" value="">
                        <input type="hidden" name="payment" id="payment" value="">
                        <input type="hidden" name="total5" id="total5" value="0">
                        <input type="hidden" name="totalr" id="totalr" value="0">
                        <input type="hidden" name="packcharge" id="packcharge" value="">
                        <input type="hidden" name="serialnumber" id="serialnumber" value="1">
                        <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <input type="hidden" name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" value="">
                        <input type="hidden" name="searchmedicineanum1" id="searchmedicineanum1" value="">
                        <input type="hidden" name="hiddenmedicinename" id="hiddenmedicinename" value="">

                        <!-- Action Buttons -->
                        <div class="btn-group">
                            <button type="submit" name="Submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Save Estimate
                            </button>
                            <button type="button" onclick="printEstimate()" class="btn btn-warning">
                                <i class="fas fa-print"></i>
                                Print Estimate
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i>
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern Footer -->
    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date('Y'); ?> MedStar Hospital Management System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modern JavaScript -->
    <script src="js/billestimate-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
