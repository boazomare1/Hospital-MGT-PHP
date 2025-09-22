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
$errmsg = "";
$date = date('Ymd');
$colorloopcount = '';
$uniquecode = array();
$duplicated = array();
$uniquecode12 = array();
$main_array = array();
$sub_array = array();
ini_set('display_errors',1);

$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname = $res["locationname"];
$locationcode = $res["locationcode"];

$query018 = "select auto_number from master_location where locationcode='$locationcode'";
$exc018 = mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018 = mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

// Form processing
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate = $transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate = $transactiondateto;}
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

$query77 = "select job_title from master_employee where username = '$username'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$job_title = $res77['job_title'];

function calculate_age($birthday)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));
    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Radiology PO Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/external-radiology-report-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for datepicker -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
        <span>External Radiology PO Report</span>
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
                        <a href="addemployeecategory.php" class="nav-link">
                            <i class="fas fa-user-tag"></i>
                            <span>Employee Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeedesignation.php" class="nav-link">
                            <i class="fas fa-id-badge"></i>
                            <span>Employee Designation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployeeinfo.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="editemployeeinfo1.php" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeelist1.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Employee List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employeepayrollreport1.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addinterfacemachine.php" class="nav-link">
                            <i class="fas fa-desktop"></i>
                            <span>Interface Machine</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="expenseentry2.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Expense Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="expirydtupdate.php" class="nav-link">
                            <i class="fas fa-calendar-times"></i>
                            <span>Expiry Update</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbyexpirydate1.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Stock Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="externallabpo_report.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>External Lab Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="externalradpo_report.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>External Radiology Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">🏥 External Radiology PO Report</h1>
                <div class="page-actions">
                    <button class="btn btn-primary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Alert Container -->
            <div id="alertContainer"></div>

            <!-- Search Form -->
            <div class="search-container">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Search Radiology Report</h3>
                </div>
                
                <form name="drugs" action="externalradpo_report.php" method="post" onKeyDown="return disableEnterKey()">
                    <div class="search-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ADate1" class="form-label required">Date From</label>
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                       class="form-input datepicker-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" class="datepicker-icon"/>
                            </div>
                            
                            <div class="form-group">
                                <label for="ADate2" class="form-label required">Date To</label>
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                       class="form-input datepicker-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" class="datepicker-icon"/>
                            </div>
                            
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <select name="location" id="location" class="form-select">
                                    <option value="All">All Locations</option>
                                    <?php
                                    $query1 = "select * from master_location where status='' order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $locationname = $res1["locationname"];
                                        $locationcode = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                            <button type="submit" name="Submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Search Report
                            </button>
                            <button type="reset" name="resetbutton" id="resetbutton" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Report Results -->
            <?php if ($frmflag1 == 'frmflag1'): ?>
            <div class="report-container">
                <div class="report-header">
                    <div class="report-title">
                        <i class="fas fa-file-medical-alt"></i>
                        <h3>External Radiology PO Report Results</h3>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-success" onclick="exportReport()">
                            <i class="fas fa-file-excel"></i>
                            Export CSV
                        </button>
                        <button class="btn btn-info" onclick="printReport()">
                            <i class="fas fa-print"></i>
                            Print Report
                        </button>
                    </div>
                </div>

                <!-- Report Summary -->
                <div class="report-summary">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="summary-content">
                            <span class="summary-label">Date Range</span>
                            <span class="summary-value"><?php echo date('M d, Y', strtotime($fromdate)); ?> - <?php echo date('M d, Y', strtotime($todate)); ?></span>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="summary-content">
                            <span class="summary-label">Location</span>
                            <span class="summary-value"><?php echo ($location == 'All') ? 'All Locations' : $location; ?></span>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-x-ray"></i>
                        </div>
                        <div class="summary-content">
                            <span class="summary-label">Total Tests</span>
                            <span class="summary-value"><?php 
                                if($location=='All') {
                                    $countquery = "(select count(*) as total from consultation_radiology where exclude = 'yes' and externalack='1' and consultationdate between '$fromdate' and '$todate') + (select count(*) as total from ipconsultation_radiology where exclude = 'yes' and externalack='1' and consultationdate between '$fromdate' and '$todate')";
                                } else {
                                    $countquery = "(select count(*) as total from consultation_radiology where exclude = 'yes' and externalack='1' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode') + (select count(*) as total from ipconsultation_radiology where exclude = 'yes' and externalack='1' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode')";
                                }
                                $countexec = mysqli_query($GLOBALS["___mysqli_ston"], $countquery);
                                $countres = mysqli_fetch_array($countexec);
                                echo $countres['total'];
                            ?></span>
                        </div>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="table-container">
                    <table class="data-table" id="externalRadiologyReportTable">
                        <thead>
                            <tr>
                                <th class="sortable" data-sort="sno">S.No</th>
                                <th class="sortable" data-sort="date">Date</th>
                                <th class="sortable" data-sort="patient-name">Patient Name</th>
                                <th class="sortable" data-sort="reg-no">Reg No</th>
                                <th class="sortable" data-sort="visit-no">Visit No</th>
                                <th class="sortable" data-sort="po-no">PO No</th>
                                <th class="sortable" data-sort="age">Age</th>
                                <th class="sortable" data-sort="gender">Gender</th>
                                <th class="sortable" data-sort="sample-id">Sample Id</th>
                                <th class="sortable" data-sort="test-name">Test Name</th>
                                <th class="sortable" data-sort="supplier">Supplier</th>
                                <th class="sortable" data-sort="rate">Rate</th>
                                <th class="sortable" data-sort="tax">Tax%</th>
                                <th class="sortable" data-sort="amount">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 0;
                            $sno1 = 0;
                            if($location == 'All') {
                                $query7 = "(select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'consultation_radiology' as tablename from consultation_radiology where exclude = 'yes' and externalack='1' and consultationdate between '$fromdate' and '$todate') 
                                union all
                                ( select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'ipconsultation_radiology' as tablename from ipconsultation_radiology where exclude = 'yes' and externalack='1' and consultationdate between '$fromdate' and '$todate') order by recorddate desc";
                            } else {
                                $query7 = "(select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'consultation_radiology' as tablename from consultation_radiology where exclude = 'yes' and externalack='1' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode') 
                                union all
                                ( select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'ipconsultation_radiology' as tablename from ipconsultation_radiology where exclude = 'yes' and externalack='1' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode') order by recorddate desc";
                            }
                            $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $num7 = mysqli_num_rows($exec7);
                            
                            if ($num7 > 0) {
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
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                            ?>
                            <tr class="<?php echo ($showcolor == 0) ? 'even' : 'odd'; ?>">
                                <td class="sno-cell"><?php echo $sno; ?></td>
                                <td class="date-cell"><?php echo $billdate6; ?></td>
                                <td class="patient-name"><?php echo htmlspecialchars($patientname6); ?></td>
                                <td class="reg-no"><?php echo $regno; ?></td>
                                <td class="visit-no"><?php echo $visitno; ?></td>
                                <td class="po-no"><?php echo $purchaseindentdocno; ?></td>
                                <td class="age-cell"><?php echo $age; ?></td>
                                <td class="gender-cell"><?php echo $gender; ?></td>
                                <td class="sample-id"><?php echo $res7docnumber; ?></td>
                                <td class="test-name"><?php echo htmlspecialchars($test); ?></td>
                                <td class="supplier"><?php echo htmlspecialchars($suppliername); ?></td>
                                <td class="rate-cell"><?php echo number_format($rate_val, 2); ?></td>
                                <td class="tax-cell"><?php echo $itemtaxpercentage; ?></td>
                                <td class="amount-cell"><?php echo number_format($totalamount, 2); ?></td>
                            </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="14" class="no-data">
                                    <div class="no-data-content">
                                        <i class="fas fa-search"></i>
                                        <h4>No Data Found</h4>
                                        <p>No external radiology PO records found for the selected criteria.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Table Summary -->
                <div class="table-summary">
                    <div class="summary-item">
                        <i class="fas fa-list"></i>
                        <span>Total Records: <?php echo $sno; ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/external-radiology-report-modern.js?v=<?php echo time(); ?>"></script>

    <!-- Legacy JavaScript -->
    <script type="text/javascript">
        function disableEnterKey() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode 
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;
            } else {
                key = e.which;
            }
            
            if(key == 13) {
                return false;
            } else {
                return true;
            }
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
            return new Date(parts[0], parts[1]-1, parts[2]);
        }

        function validcheck() {
            return true;
        }

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
            
            const table = document.getElementById('externalRadiologyReportTable');
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
            
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'external_radiology_po_report.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }

        function printReport() {
            window.print();
        }
    </script>
</body>
</html>
