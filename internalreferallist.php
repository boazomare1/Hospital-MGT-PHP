<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$res1suppliername = '';

$total1 = '0.00';

$total2 = '0.00';

$total3 = '0.00';

$total4 = '0.00';

$total5 = '0.00';

$total6 = '0.00';

//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");





if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Referral List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/referral-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <script type="text/javascript">
    window.onload = function () {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
    }
    </script>
</head>







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
        <span>Internal Referral List</span>
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
                        <a href="payrollmonthwiseinterim.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="internalreferallist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Internal Referral List</span>
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
                    <h2>Internal Referral List</h2>
                    <p>View and manage internal patient referrals between departments.</p>
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

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Internal Referral Search</h3>
                </div>
                
                <form name="cbform1" method="post" action="internalreferallist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input" 
                                       value="<?php echo $paymentreceiveddatefrom; ?>" 
                                       readonly="readonly" onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="calendar-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" class="form-input" 
                                       value="<?php echo $paymentreceiveddateto; ?>" 
                                       readonly="readonly" onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="calendar-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group form-group-submit">
                            <button type="submit" name="Submit" class="submit-btn">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                            <button type="reset" name="resetbutton" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                    
                    <!-- Hidden fields -->
                    <input name="searchsuppliername" type="hidden" id="searchsuppliername" 
                           value="<?php echo htmlspecialchars($searchsuppliername); ?>">
                    <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" 
                           value="<?php echo isset($searchsuppliercode) ? htmlspecialchars($searchsuppliercode) : ''; ?>">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                </form>
            </div>

            <!-- Internal Referral Report Section -->
            <?php if (!empty($ADate1) && !empty($ADate2)): ?>
            <div class="referral-report-section">
                <div class="report-header">
                    <div class="report-title">
                        <i class="fas fa-exchange-alt"></i>
                        <h3>Internal Referral Report</h3>
                    </div>
                    <div class="report-info">
                        <div class="report-info-item">
                            <strong>Date Range:</strong> <?php echo $ADate1; ?> to <?php echo $ADate2; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Table Container -->
                <div class="table-container">
                    <table class="referral-table">
                        <thead>
                            <tr>
                                <th class="serial-header">No.</th>
                                <th class="date-header">Date</th>
                                <th class="patient-header">Patient Name</th>
                                <th class="code-header">Patient Code</th>
                                <th class="visit-header">Visit Code</th>
                                <th class="gender-header">Gender</th>
                                <th class="age-header">Age</th>
                                <th class="department-from-header">Department From</th>
                                <th class="department-to-header">Department To</th>
                                <th class="referred-by-header">Referred By</th>
                                <th class="export-header">Export</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query2 = "select * from consultation_departmentreferal where consultationdate between '$ADate1' and '$ADate2' order by consultationdate desc";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $nums = mysqli_num_rows($exec2);
                            
                            $snocount = 0;
                            while ($res2 = mysqli_fetch_array($exec2)) {
                                $res2patientname = $res2['patientname'];
                                $res2patientcode = $res2['patientcode'];
                                $res2visitcode = $res2['patientvisitcode'];
                                $res2referalname = $res2['referalname'];
                                $res2username = $res2['username'];
                                $res2consultationdate = $res2['consultationdate'];
                                
                                $query3 = "select * from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode'";
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3". mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res3 = mysqli_fetch_array($exec3);
                                
                                $res3gender = $res3['gender'];
                                $res3age = $res3['age'];
                                $res3departmentname = $res3['departmentname'];
                                
                                $snocount++;
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                $rowClass = ($showcolor == 0) ? 'even' : 'odd';
                            ?>
                            <tr class="referral-row <?php echo $rowClass; ?>">
                                <td class="serial-number"><?php echo $snocount; ?></td>
                                <td class="referral-date"><?php echo $res2consultationdate; ?></td>
                                <td class="patient-name"><?php echo htmlspecialchars($res2patientname); ?></td>
                                <td class="patient-code">
                                    <span class="code-badge"><?php echo htmlspecialchars($res2patientcode); ?></span>
                                </td>
                                <td class="visit-code">
                                    <span class="visit-badge"><?php echo htmlspecialchars($res2visitcode); ?></span>
                                </td>
                                <td class="gender">
                                    <span class="gender-badge"><?php echo htmlspecialchars($res3gender); ?></span>
                                </td>
                                <td class="age"><?php echo htmlspecialchars($res3age); ?></td>
                                <td class="department-from">
                                    <span class="department-badge from-badge"><?php echo htmlspecialchars($res3departmentname); ?></span>
                                </td>
                                <td class="department-to">
                                    <span class="department-badge to-badge"><?php echo htmlspecialchars($res2referalname); ?></span>
                                </td>
                                <td class="referred-by">
                                    <span class="user-badge"><?php echo htmlspecialchars($res2username); ?></span>
                                </td>
                                <td class="export-actions">
                                    <?php if ($nums > 0): ?>
                                    <a href="print_internalreferallist.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>" 
                                       class="export-btn" title="Export to Excel" target="_blank">
                                        <i class="fas fa-file-excel"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/referral-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

