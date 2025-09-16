<?php
// Get the start time

session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$snocount = "";
$colorloopcount="";
$totalcollection = 0;
$totalrevenue = 0;
$totalpercentage = 0;

if(isset($_REQUEST['locationcode'])){ $locationcode = $_REQUEST['locationcode']; } else { $locationcode = ''; }
if(isset($_REQUEST['year'])){ $from_year = $_REQUEST['year']; } else { $from_year = date('Y'); }
if(isset($_REQUEST['month'])){ $from_month = $_REQUEST['month']; } else { $from_month = date('m'); }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debtor Sales Branch Wise - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/debtorsales-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
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
        <span>Debtor Sales Branch Wise</span>
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
                        <a href="daybookreport.php" class="nav-link">
                            <i class="fas fa-book"></i>
                            <span>Day Book Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dailykpi_report.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Daily KPI Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="daytodayflash.php" class="nav-link">
                            <i class="fas fa-bolt"></i>
                            <span>Day to Day Flash</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="debitnotelist.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Debit Note List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="debtorsales.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Debtor Sales</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Debtor Sales Branch Wise</h2>
                    <p>Comprehensive analysis of debtor sales performance across different branches and locations.</p>
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

            <!-- Search Form -->
            <div class="search-form">
                <form name="cbform1" method="post" action="debtorsales.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="locationcode" class="form-label">Location</label>
                            <select name="locationcode" id="locationcode" class="form-control">
                                <option value="">All Locations</option>
                                <?php
                                $query1 = "select * from master_location order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode1 = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode1; ?>" <?php if($locationcode!=''){if($locationcode == $locationcode1){echo "selected";}}?>><?php echo $locationname; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="year" class="form-label">Select Year</label>
                            <select name="year" id="year" class="form-control">
                                <?php $years = range(2018, strftime("2025", time())); ?>
                                <?php if($from_year != ''){ ?>
                                    <option value="<?php echo $from_year; ?>"><?php echo $from_year; ?></option>
                                <?php } ?>
                                <option>Select Year</option>
                                <?php foreach($years as $year1) : ?>
                                    <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="month" class="form-label">Select Month</label>
                            <select name="month" id="month" class="form-control">
                                <option <?php if($from_month == '1') { ?> selected = 'selected' <?php } ?> value="1">January</option>
                                <option <?php if($from_month == '2') { ?> selected = 'selected' <?php } ?> value="2">February</option>
                                <option <?php if($from_month == '3') { ?> selected = 'selected' <?php } ?> value="3">March</option>
                                <option <?php if($from_month == '4') { ?> selected = 'selected' <?php } ?> value="4">April</option>
                                <option <?php if($from_month == '5') { ?> selected = 'selected' <?php } ?> value="5">May</option>
                                <option <?php if($from_month == '6') { ?> selected = 'selected' <?php } ?> value="6">June</option>
                                <option <?php if($from_month == '7') { ?> selected = 'selected' <?php } ?> value="7">July</option>
                                <option <?php if($from_month == '8') { ?> selected = 'selected' <?php } ?> value="8">August</option>
                                <option <?php if($from_month == '9') { ?> selected = 'selected' <?php } ?> value="9">September</option>
                                <option <?php if($from_month == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                                <option <?php if($from_month == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                                <option <?php if($from_month == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <button type="reset" class="btn btn-outline" id="resetbutton">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <?php if(isset($_POST['Submit'])){  
                $valuesArray=array();
                
                $query12 = "select locationname from master_location where locationcode='$locationcode' and auto_number not in ('11','12') order by auto_number asc";
                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res12 = mysqli_fetch_array($exec12);
                $res1location = $res12["locationname"];
                if($res1location==''){
                    $res1location='ALL';
                }
              
                if($locationcode==''){
                        $locationcodenew= "and a.locationcode like '%%'";
                    
                        $query121 = "select locationname from master_location where locationcode like '%%'  and auto_number not in ('11','12') order by auto_number asc";
                        $exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $exec1211 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                }else{
                        $locationcodenew= "and a.locationcode = '$locationcode'";
                    
                        $query121 = "select locationname from master_location where locationcode='$locationcode'  and auto_number not in ('11','12')  order by auto_number asc";
                        $exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
                
                $year_start = date('Y-m-d', strtotime('first day of january'.date($from_year)));
                $year_end = date('Y-m-d', strtotime('last day of '.date($from_year.'-'.$from_month)));
            ?>
            
            <div class="export-actions">
                <button type="button" class="btn btn-success" onclick="exportToExcel()">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </button>
            </div>

            <div class="data-table-container">
                <table class="data-table" id="AutoNumber3">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>ACCOUNT</th>
                            <?php 
                              while($res121 = mysqli_fetch_array($exec121)){
                            ?>
                            <th><?php echo $res121["locationname"]; ?></th>
                            <?php } ?>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "select * from master_subtype where recordstatus <> 'deleted' and auto_number != '1'";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1").mysqli_error($GLOBALS["___mysqli_ston"]);
                        while($res1 = mysqli_fetch_array($exec1)){
                            $totcollection=0;
                            $subtypename = $res1['subtype'];
                            $subtypeano = $res1['auto_number'];
                            $subtype_ledger = $res1['subtype_ledger'];
                            $snocount = $snocount + 1;
                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                            if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                            } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                            }
                            ?>
                            <tr <?=$colorcode;?>>
                                <td><?=$snocount;?></td>
                                <td><?=$subtypename;?></td>
                                <?php
                                if($locationcode==''){
                                        $query121 = "select locationcode from master_location where locationcode like '%%'  and auto_number not in ('11','12') order by auto_number asc";
                                        $exec1211 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
                                }else{
                                        $query121 = "select locationcode from master_location where locationcode='$locationcode'  and auto_number not in ('11','12') order by auto_number asc";
                                        $exec1211 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
                                }
                                while($res1211 = mysqli_fetch_array($exec1211)){
                                    $ltcamt=0;
                                    $selectlct=$res1211["locationcode"];    
                                    $queryn21 = "select sum(a.transactionamount) as ltcamt from master_transactionpaylater as a JOIN master_subtype as b ON a.accountcode = b.subtype_ledger where  a.transactiondate between '$year_start' and '$year_end' and a.billnumber<>'' and a.transactionmodule != 'PAYMENT'  and b.subtype_ledger = '$subtype_ledger' and a.locationcode='$selectlct' group by b.auto_number";
                                    $execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res23 = mysqli_fetch_array($execn21)){
                                        $ltcamt+= $res23['ltcamt'];
                                        $totcollection+= $res23['ltcamt'];
                                    }
                                    ?>
                                    <td><?=number_format($ltcamt,2,'.',',');?></td>
                                    <?php
                                }
                                ?>
                                <td><?=number_format($totcollection,2,'.',',');?></td>
                            </tr>
                            <?php 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/debtorsales-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>