<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

error_reporting(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$username = $_SESSION['username'];
$docno1 = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION["companycode"];
$errmsg = "";
$date = date('Ymd');
$colorloopcount = '';
$uniquecode = array();
$duplicated = array();
$uniquecode12 = array();
$main_array = array();
$sub_array = array();

// Get location details
$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname = $res["locationname"];
$locationcode = $res["locationcode"];

$query018 = "select auto_number from master_location where locationcode='$locationcode'";
$exc018 = mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018 = mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

// Get job title
$query77 = "select job_title from master_employee where username = '$username'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$job_title = $res77['job_title'];

// Handle form submissions
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate = $transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate = $transactiondateto;}
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["lpodate"])) { $lpodate = $_REQUEST["lpodate"]; } else { $lpodate = ""; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Lab PO Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/external-lab-report-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for datepicker -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script src="js/datetimepicker_css.js"></script>
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
        <a href="laboratory_master.php">Laboratory Management</a>
        <span>→</span>
        <span>External Lab PO Report</span>
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
                        <a href="laboratory_master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Laboratory Management</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="externallabpo_report.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>External Lab PO Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="sample_collection.php" class="nav-link">
                            <i class="fas fa-vial"></i>
                            <span>Sample Collection</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lab_reports.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Lab Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="external_lab_master.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>External Lab Master</span>
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
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>External Lab PO Report</h2>
                    <p>Generate comprehensive reports of external lab purchase orders with detailed patient and test information.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportReport()">
                        <i class="fas fa-download"></i> Export Report
                    </button>
                </div>
            </div>
            
            <!-- Search Form Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Report Criteria</h3>
                    <span class="form-help">Filter external lab PO data by date range and location</span>
                </div>
                
                <form name="drugs" action="externallabpo_report.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ADate1" class="form-label required">Date From</label>
                            <div class="date-input-container">
                                <input name="ADate1" id="ADate1" class="form-input datepicker-input" 
                                       value="<?php echo htmlspecialchars($transactiondatefrom); ?>" readonly />
                                <i class="fas fa-calendar-alt datepicker-icon" onClick="javascript:NewCssCal('ADate1')"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label required">Date To</label>
                            <div class="date-input-container">
                                <input name="ADate2" id="ADate2" class="form-input datepicker-input" 
                                       value="<?php echo htmlspecialchars($transactiondateto); ?>" readonly />
                                <i class="fas fa-calendar-alt datepicker-icon" onClick="javascript:NewCssCal('ADate2')"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select">
                                <option value="All">All Locations</option>
                                <?php
                                $query1 = "select * from master_location where status='' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname_option = $res1["locationname"];
                                    $locationcode_option = $res1["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode_option; ?>" <?php if($location!='')if($location==$locationcode_option){echo "selected";}?>>
                                    <?php echo htmlspecialchars($locationname_option); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                        
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Generate Report
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset Form
                        </button>
                    </div>
                </form>
            </div>
            
            <?php if ($frmflag1 == 'frmflag1'): ?>
            <!-- Results Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <div class="data-table-title">
                        <i class="fas fa-file-alt"></i>
                        <h3>External Lab PO Report Results</h3>
                    </div>
                    <div class="data-table-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="exportReport()">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="printReport()">
                            <i class="fas fa-print"></i>
                            Print Report
                        </button>
                    </div>
                </div>
                
                <div class="report-summary">
                    <div class="summary-cards">
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="summary-content">
                                <h4>Date Range</h4>
                                <p><?php echo date('M d, Y', strtotime($fromdate)); ?> - <?php echo date('M d, Y', strtotime($todate)); ?></p>
                            </div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="summary-content">
                                <h4>Location</h4>
                                <p><?php echo htmlspecialchars($location == 'All' ? 'All Locations' : $location); ?></p>
                            </div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-icon">
                                <i class="fas fa-vial"></i>
                            </div>
                            <div class="summary-content">
                                <h4>Total Tests</h4>
                                <p><?php echo $sno; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table" id="externalLabReportTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>Reg No</th>
                                <th>Visit No</th>
                                <th>PO No</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Sample Id</th>
                                <th>Test Name</th>
                                <th>Supplier</th>
                                <th>Rate</th>
                                <th>Tax%</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 0;
                            $sno1 = 0;
                            $totalAmount = 0;
                            
                            if($location == 'All') {
                                $query7 = "(select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,recorddate as recorddate,itemname as itemname,itemcode as itemcode,sampleid as sampleid,billnumber as billnumber,'samplecollection_lab' as tablename from samplecollection_lab where externallab = '1' and externalack='1' and recorddate between '$fromdate' and '$todate') 
                                union all
                                ( select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,recorddate as recorddate,itemname as itemname,itemcode as itemcode,sampleid as sampleid,billnumber as billnumber,'ipsamplecollection_lab' as tablename from ipsamplecollection_lab where externallab = '1' and externalack='1' and recorddate between '$fromdate' and '$todate') order by recorddate desc";
                            } else {
                                $query7 = "(select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,recorddate as recorddate,itemname as itemname,itemcode as itemcode,sampleid as sampleid,billnumber as billnumber,'samplecollection_lab' as tablename from samplecollection_lab where externallab = '1' and externalack='1' and recorddate between '$fromdate' and '$todate' and locationcode='$location') 
                                union all
                                ( select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,recorddate as recorddate,itemname as itemname,itemcode as itemcode,sampleid as sampleid,billnumber as billnumber,'ipsamplecollection_lab' as tablename from ipsamplecollection_lab where externallab = '1' and externalack='1' and recorddate between '$fromdate' and '$todate' and locationcode='$location') order by recorddate desc";
                            }
                            
                            $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $num7 = mysqli_num_rows($exec7);
                            
                            if ($num7 == 0): ?>
                            <tr>
                                <td colspan="14" class="no-data">
                                    <i class="fas fa-search"></i>
                                    <h3>No Records Found</h3>
                                    <p>No external lab PO records found for the specified criteria.</p>
                                </td>
                            </tr>
                            <?php else:
                            while($res7 = mysqli_fetch_array($exec7)) {
                                $res7auto_number = $res7['auto_number'];
                                $res7docnumber = $res7['docnumber'];
                                $patientname6 = $res7['patientname'];
                                $regno = $res7['patientcode'];
                                $visitno = $res7['patientvisitcode'];
                                $billdate6 = $res7['recorddate'];
                                $test = $res7['itemname'];
                                $itemcode = $res7['itemcode'];
                                $sampleid = $res7['sampleid'];
                                $billnumber2 = $res7['billnumber'];
                                $res7tablename = $res7['tablename'];

                                $query70 = "select * from manual_lpo where sample_autono = '$res7auto_number' and sample_table ='$res7tablename' ";
                                $exec70 = mysqli_query($GLOBALS["___mysqli_ston"], $query70) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res70 = mysqli_fetch_array($exec70);
                                $suppliername = $res70['suppliername'];
                                $quantity = $res70['quantity'];
                                $rate_val = $res70['rate'];
                                $totalamount = $res70['totalamount'];
                                $itemtaxpercentage = $res70['itemtaxpercentage'];
                                $purchaseindentdocno = $res70['billnumber'];

                                $query751 = "select * from master_customer where customercode = '$regno' ";
                                $exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res751 = mysqli_fetch_array($exec751);
                                $dob = $res751['dateofbirth'];
                                $age = calculate_age($dob);
                                $gender = $res751['gender'];

                                $query68 = "select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";
                                $exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68);
                                $res68 = mysqli_fetch_array($exec68);
                                $externallab = $res68['externallab'];

                                $sno = $sno + 1;
                                $sno1 = $sno1 + 1;
                                $totalAmount += $totalamount;
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = 'bgcolor="#ecf0f5"';
                                }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td class="item-number"><?php echo $sno; ?></td>
                                <td class="date-cell"><?php echo htmlspecialchars($billdate6); ?></td>
                                <td class="patient-name"><?php echo htmlspecialchars($patientname6); ?></td>
                                <td class="reg-no"><?php echo htmlspecialchars($regno); ?></td>
                                <td class="visit-no"><?php echo htmlspecialchars($visitno); ?></td>
                                <td class="po-no"><?php echo htmlspecialchars($purchaseindentdocno); ?></td>
                                <td class="age-cell"><?php echo htmlspecialchars($age); ?></td>
                                <td class="gender-cell"><?php echo htmlspecialchars($gender); ?></td>
                                <td class="sample-id"><?php echo htmlspecialchars($res7docnumber); ?></td>
                                <td class="test-name"><?php echo htmlspecialchars($test); ?></td>
                                <td class="supplier-name"><?php echo htmlspecialchars($suppliername); ?></td>
                                <td class="rate-cell">$<?php echo number_format($rate_val, 2); ?></td>
                                <td class="tax-cell"><?php echo htmlspecialchars($itemtaxpercentage); ?>%</td>
                                <td class="amount-cell">$<?php echo number_format($totalamount, 2); ?></td>
                            </tr>
                            <?php 
                            } endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table-summary">
                    <div class="summary-item">
                        <i class="fas fa-list"></i>
                        <span>Total Records: <?php echo $sno; ?></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Total Amount: $<?php echo number_format($totalAmount, 2); ?></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-info-circle"></i>
                        <span>Report generated on <?php echo date('M d, Y H:i:s'); ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/external-lab-report-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript for compatibility -->
    <script type="text/javascript">
        // Legacy functions preserved for compatibility
        function disableEnterKey() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
            
            const key = event.keyCode || event.which;
            
            if(key == 13) { // if enter key press
                return false;
            } else {
                return true;
            }
        }
        
        function validcheck() {
            // Validation logic can be added here
        }
        
        function getValidityDays() {
            var d1 = parseDate($('#todaydate').val());
            console.log(d1);
            var oneDay = 24*60*60*1000;
            var diff = 0;
            if (d1 && d2) {
                diff = Math.round(Math.abs((d2.getTime() - d1.getTime())/(oneDay)));
                console.log('diff'+diff);
            }
        }
        
        function parseDate(input) {
            var parts = input.match(/(\d+)/g);
            return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
        }
        
        // Modern functions
        function refreshPage() {
            window.location.reload();
        }
        
        function exportReport() {
            const fromdate = document.querySelector('input[name="ADate1"]').value;
            const todate = document.querySelector('input[name="ADate2"]').value;
            const location = document.querySelector('select[name="location"]').value;
            
            if (!fromdate || !todate) {
                alert('Please select date range before exporting');
                return;
            }
            
            // Create CSV content
            const table = document.getElementById('externalLabReportTable');
            if (!table) {
                alert('No data to export');
                return;
            }
            
            let csvContent = 'S.No,Date,Patient Name,Reg No,Visit No,PO No,Age,Gender,Sample Id,Test Name,Supplier,Rate,Tax%,Amount\n';
            
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                const cells = row.querySelectorAll('td');
                if (cells.length > 1 && !row.querySelector('.no-data')) {
                    const rowData = Array.from(cells).map(cell => `"${cell.textContent.trim()}"`);
                    csvContent += rowData.join(',') + '\n';
                }
            });
            
            // Download CSV
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'external_lab_po_report.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        function printReport() {
            window.print();
        }
        
        // jQuery document ready
        $(function() {
            getValidityDays();
        });
    </script>
</body>
</html>

<?php
function calculate_age($birthday) {
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));
    if ($diff->y) {
        return $diff->y . ' Years';
    } elseif ($diff->m) {
        return $diff->m . ' Months';
    } else {
        return $diff->d . ' Days';
    }
}
?>
