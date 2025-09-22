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

// Initialize variables
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

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
$colorloopcount = "";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';

// Handle form parameters
$slocation = isset($_REQUEST["slocation"]) ? $_REQUEST["slocation"] : "";
$searchsuppliername = isset($_REQUEST["searchsuppliername"]) ? $_REQUEST["searchsuppliername"] : "";
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : "";
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : "";
$range = isset($_REQUEST["range"]) ? $_REQUEST["range"] : "";
$amount = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : "";
$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";
$searchemployeecode = isset($_REQUEST["searchemployeecode"]) ? $_REQUEST["searchemployeecode"] : "";

// Set date variables
if ($ADate1 != "") { $paymentreceiveddatefrom = $ADate1; }
if ($ADate2 != "") { $paymentreceiveddateto = $ADate2; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Activity Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/doctors-activity-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- jQuery UI for autocomplete -->
    <link href="js/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>







    
    <script>
    $(function() {
        $('#searchsuppliername').autocomplete({
            source:'ajaxemployeenewsearch.php', 
            minLength:3,
            delay: 0,
            html: true, 
            select: function(event,ui){
                var code = ui.item.id;
                var employeecode = ui.item.employeecode;
                var employeename = ui.item.employeename;
                $('#searchemployeecode').val(employeecode);
                $('#searchsuppliername').val(employeename);
            },
        });
    });
    </script>
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
        <span>Doctor Activity Report</span>
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
                        <a href="doctorsactivityreport.php" class="nav-link active">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Activity Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
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
                    <h2>Doctor Activity Report</h2>
                    <p>Generate comprehensive reports on doctor consultation activities and patient interactions.</p>
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
                    <h3 class="search-form-title">Search Criteria</h3>
                </div>
                
                <form name="cbform1" method="post" action="doctorsactivityreport.php" class="search-form">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>" 
                                       class="form-input date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>" 
                                       class="form-input date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>





                    <div class="form-group">
                        <label for="slocation" class="form-label">Location</label>
                        <select name="slocation" id="slocation" class="form-input">
                            <option value="" selected="selected">All Locations</option>
                            <?php
                            $query01="select locationcode,locationname from master_employeelocation where username ='$username' group by locationcode order by locationname ";
                            $exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
                            while($res01=mysqli_fetch_array($exc01)) {
                                $selected = ($slocation == $res01['locationcode']) ? 'selected' : '';
                                ?>
                                <option value="<?= $res01['locationcode'] ?>" <?php echo $selected; ?>>
                                    <?= $res01['locationname']; ?>
                                </option>
                                <?php 
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="searchsuppliername" class="form-label">Doctor</label>
                        <input name="searchsuppliername" type="text" id="searchsuppliername" 
                               value="<?php echo $searchsuppliername; ?>" class="form-input" 
                               placeholder="Search for doctor name..." autocomplete="off">
                        <input name="searchdescription" id="searchdescription" type="hidden" value="">
                        <input name="searchemployeecode" id="searchemployeecode" type="hidden" value="<?php echo $searchemployeecode; ?>">
                        <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />
                        <input type="hidden" name="cbfrmflag2" value="cbfrmflag1">
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Generate Report
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <?php if($cbfrmflag2 == 'cbfrmflag1'): ?>
            <div class="results-section">
                <div class="results-header">
                    <i class="fas fa-chart-bar results-icon"></i>
                    <h3 class="results-title">Doctor Activity Results</h3>
                </div>

                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Doctor Name</th>
                                <th>Patient Count</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>

			

                            <?php
                            $query7 = "select * from master_employee where employeecode = '$searchemployeecode'";
                            $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res7 = mysqli_fetch_array($exec7);
                            $res7username = $res7['username'];

                            $query4 = "select username,locationname,count(username) as totalpatients from master_consultationlist where locationcode like '%$slocation' and date between '$ADate1' and '$ADate2' and username LIKE '%$res7username%' group by username order by auto_number ASC"; 
                            $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $num4 = mysqli_num_rows($exec4);

                            while($res4 = mysqli_fetch_array($exec4)) {
                                $numt1 = 0;
                                $username = $res4['username'];
                                $totalpatients = $res4['totalpatients'];

                                $query1002 = "select count(username) as totalpatients1 from master_consultationlist where locationcode like '%$slocation' and username='$username' and date between '$ADate1' and '$ADate2' group by visitcode order by auto_number ASC"; 
                                $exec1002 = mysqli_query($GLOBALS["___mysqli_ston"], $query1002) or die ("Error in Query002".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $numt1 = mysqli_num_rows($exec1002);

                                $doctorname = $res4['username'];
                                $doctorusername = $res4['username'];
                                $location = $res4['locationname'];

                                $query02 = "select employeename from master_employee where username='$doctorname'";
                                $exec02 = mysqli_query($GLOBALS["___mysqli_ston"], $query02);
                                $res02 = mysqli_fetch_array($exec02);
                                
                                if($res02['employeename'] != '') {
                                    $doctorname = $res02['employeename'];
                                }

                                $snocount = $snocount + 1;
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                $colorcode = ($showcolor == 0) ? 'bgcolor="#CBDBFA"' : 'bgcolor="#ecf0f5"';
                                ?>
                                <tr <?php echo $colorcode; ?>>
                                    <td><?php echo $snocount; ?></td>
                                    <td>
                                        <a href="doctorsactivityreportdetaiview.php?usernamenew=<?= $doctorusername; ?>&ADate1=<?= $ADate1; ?>&ADate2=<?= $ADate2; ?>&cbfrmflag2=cbfrmflag1&slocation=<?= $slocation ?>" 
                                           target="_blank" class="doctor-link">
                                            <i class="fas fa-user-md"></i>
                                            <?php echo htmlspecialchars($doctorname); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="count-badge"><?php echo $numt1; ?></span>
                                    </td>
                                    <td>
                                        <span class="location-badge"><?php echo htmlspecialchars($location); ?></span>
                                    </td>
                                </tr>
                                <?php
                                $total1 += $numt1;
                                $numt1 = 0;
                            }
                            ?>

                        </tbody>
                    </table>
                    
                    <!-- Summary Row -->
                    <div class="summary-row">
                        <div class="summary-item">
                            <span class="summary-label">Total Patients Consulted:</span>
                            <span class="summary-value"><?= $total1; ?></span>
                        </div>
                    </div>
                    
                    <!-- Export Actions -->
                    <div class="export-actions">
                        <?php $url = "ADate1=$ADate1&&ADate2=$ADate2&slocation=$slocation&usernamenew=$res7username" ?>
                        <a href="print_doctoractivity.php?<?php echo $url; ?>" class="export-btn pdf-btn" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                            Export PDF
                        </a>
                        <a href="print_doctoractivityxl.php?<?php echo $url; ?>" class="export-btn excel-btn" target="_blank">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/doctors-activity-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
