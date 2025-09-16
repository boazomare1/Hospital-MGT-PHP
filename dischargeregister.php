<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Set default date ranges
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Initialize form variables
$snocount = "";
$colorloopcount = "";
$range = "";
$opnumber = "";
$ipnumber = "";
$patientname = "";
$dateofadmission = "";
$dateofdischarge = "";
$class = "";
$admissiondoc = "";
$consultingdoc = "";
$revenue = "";
$returns = "";
$discount = "";
$nhif = "";
$netbill = "";
$invoiceno = "";
$dischargedby = "";
$wardcode = "";
$locationcode = "";
$patientcode = "";

// Initialize financial variables
$consultationfee = 0;
$labrate = 0;
$pharmamount = 0;
$radrate = 0;
$serrate = 0;
$bedallocationamount = 0;
$bedtransferamount = 0;
$packageamount = 0;
$sumoveralltotal = 0;
$sumrevenue = 0;
$sumnet = 0;

// Handle form parameters with modern isset() checks
$ward12 = isset($_REQUEST["ward"]) ? $_REQUEST["ward"] : "";
$wardcode = isset($_REQUEST["wardcode1"]) ? $_REQUEST["wardcode1"] : "";
$locationcode1 = isset($_REQUEST["locationcode"]) ? $_REQUEST["locationcode"] : "";
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : "";
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : "";
$range = isset($_REQUEST["range"]) ? $_REQUEST["range"] : "";
$amount = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : "";
$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";

// Update date variables if form dates are provided
if ($ADate1 != "") {
    $paymentreceiveddatefrom = $ADate1;
}
if ($ADate2 != "") {
    $paymentreceiveddateto = $ADate2;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discharge Register - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Additional CSS for date picker -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <style>
        .bodytext31:hover { font-size:14px; }
        .bal {
            border-style:none;
            background:none;
            text-align:right;
        }
        .bali {
            text-align:right;
        }
    </style>
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
        <span>Reports</span>
        <span>→</span>
        <span>Discharge Register</span>
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
                        <a href="patient_registration.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Patient Registration</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist1.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Inpatient Management</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="dischargeregister.php" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Discharge Register</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Reports</span>
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
                    <h2>Discharge Register</h2>
                    <p>View and analyze patient discharge records with comprehensive financial and clinical data.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <form name="cbform1" method="post" action="dischargeregister.php" class="search-form">
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fas fa-search form-section-icon"></i>
                        <h3 class="form-section-title">Search Discharge Records</h3>
                    </div>
                    
                    <div class="form-section-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="locationcode" class="form-label">Location</label>
                                <select name="locationcode" id="locationcode" class="form-input" onChange="funcSubTypeChange1(this.value); ajaxlocationfunction(this.value);">
                                    <option value="All">All</option>
                                    <?php
                                    $query20 = "select * FROM master_location";
                                    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20". mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res20 = mysqli_fetch_array($exec20)){
                                        $locationname = $res20["locationname"];
                                        $locationcode = $res20["locationcode"];
                                    ?>
                                        <option value="<?php echo $locationcode; ?>" <?php if($locationcode1!='')if($locationcode1==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="ward" class="form-label">Ward</label>
                                <select name="ward" id="ward" class="form-input">
                                    <option value="">Select Ward</option>
                                    <?php
                                    if($locationcode1!='All') {
                                        $query78 = "select auto_number,ward from master_ward where locationcode='$locationcode1'";
                                    } else {
                                        $query78 = "select auto_number,ward from master_ward";
                                    }
                                    $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res78 = mysqli_fetch_array($exec78)) {
                                        $wardanum = $res78['auto_number'];
                                        $wardname = $res78['ward'];
                                    ?>
                                        <option value="<?php echo $wardanum; ?>"<?php if($wardanum == $ward12) { echo "selected"; }?>><?php echo $wardname; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ADate1" class="form-label">Date From</label>
                                <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>" class="form-input" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer; margin-left: 5px;"></i>
                            </div>
                            
                            <div class="form-group">
                                <label for="ADate2" class="form-label">Date To</label>
                                <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>" class="form-input" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer; margin-left: 5px;"></i>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                                <button type="submit" class="btn btn-primary" name="Submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Export Button -->
            <div class="form-section">
                <div class="form-section-form">
                    <div class="form-row">
                        <div class="form-group">
                            <a href="print_dischargeregisterxls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $ward12; ?>&&locationcode=<?php echo $locationcode1; ?>" class="btn btn-outline">
                                <i class="fas fa-file-excel"></i> Export to Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">Discharge Records</h3>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr class="table-header">
                            <th class="table-header-cell">No.</th>
                            <th class="table-header-cell">Ward</th>
                            <th class="table-header-cell">Patient Code</th>
                            <th class="table-header-cell">Visit Code</th>
                            <th class="table-header-cell">Patient Name</th>
                            <th class="table-header-cell">D.O.A.</th>
                            <th class="table-header-cell">D.O.A. Time</th>
                            <th class="table-header-cell">D.O.D</th>
                            <th class="table-header-cell">D.O.D Time</th>
                            <th class="table-header-cell">LOS</th>
                            <th class="table-header-cell">Scheme</th>
                            <th class="table-header-cell">Ward</th>
                            <th class="table-header-cell">Admitting Doctor</th>
                            <th class="table-header-cell">Consulting Doctor</th>
                            <th class="table-header-cell text-right">Revenue</th>
                            <th class="table-header-cell text-right">Deposit</th>
                            <th class="table-header-cell text-right">Discount</th>
                            <th class="table-header-cell text-right">NHIF</th>
                            <th class="table-header-cell text-right">Net Bill</th>
                            <th class="table-header-cell">Invoice NO.</th>
                            <th class="table-header-cell">Discharged By</th>
                            <th class="table-header-cell">Finalized By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalrevenue = $totaldiscount = $totaldeposit = $totalnhif = $totalnetbill = 0;
                        
                        if($locationcode1=='All') {
                            $pass_location = "locationcode !=''";
                        } else {
                            $pass_location = "locationcode ='$locationcode1'";
                        }
                        
                        if($ward12!='') {
                            $query110 = "select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location and b.ward='$ward12'
                            UNION ALL 
                            select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location and b.ward='$ward12' order by ward";
                        } else {
                            $query110 = "select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location 
                            UNION ALL 
                            select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location order by ward";
                        }
                        
                        $exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res110 = mysqli_fetch_array($exec110)){
                            $patientcode = $res110['patientcode'];
                            $patientname = $res110['patientname'];
                            $visitcode = $res110['visitcode'];
                            
                            $query10 = "select * from ip_bedallocation where patientcode = '$patientcode' and visitcode = '$visitcode'";
                            $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res10 = mysqli_fetch_array($exec10);
                            
                            $admissiondate = $res10['recorddate'];
                            $admissiontime = $res10['recordtime'];
                            $wardno = $res10['ward'];
                            
                            $queryward = "select * from master_ward where auto_number = '$wardno'";
                            $execward = mysqli_query($GLOBALS["___mysqli_ston"], $queryward) or die("Error in QueryWard".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $resward = mysqli_fetch_array($execward);
                            $wardname = $resward['ward'];
                            
                            $querydischarge = "select * from ip_discharge where patientcode = '$patientcode' and visitcode = '$visitcode'";
                            $execdischarge = mysqli_query($GLOBALS["___mysqli_ston"], $querydischarge) or die("Error in querydischarge".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $resdischarge = mysqli_fetch_array($execdischarge);
                            
                            $dischargedate = $resdischarge['recorddate'];
                            $dischargetime = $resdischarge['recordtime'];
                            $accountname = $resdischarge['accountname'];
                            $dischargedby = $resdischarge['username'];
                            
                            $start = strtotime($admissiondate);
                            $end = strtotime($dischargedate);
                            $los = floor(abs($end - $start) / 86400);
                            
                            $query12 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
                            $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res12 = mysqli_fetch_array($exec12);
                            
                            $admissiondoc = $res12['opadmissiondoctor'];
                            $consultingdoc = $res12['consultingdoctorName'];
                            
                            $query13 = "select * from billing_ip where patientcode = '$patientcode' and visitcode = '$visitcode'";
                            $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res13 = mysqli_fetch_array($exec13);
                            $num13 = mysqli_num_rows($exec13);
                            
                            if($num13 == 1){
                                $revenue = $res13['totalrevenue'];
                                $deposit = $res13['deposit'];
                                $discount = $res13['discount'];
                                $nhif = $res13['nhif'];
                                $netbill=$revenue-$discount-$nhif;
                                $invoiceno = $res13['billno'];
                                $finalizedby = $res13['username'];
                            } else {
                                $query14 = "select * from billing_ipcreditapproved where patientcode = '$patientcode' and visitcode = '$visitcode'";
                                $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res14 = mysqli_fetch_array($exec14);
                                
                                $revenue = $res14['totalrevenue'];
                                $deposit = $res14['deposit'];
                                $discount = $res14['discount'];
                                $nhif = $res14['nhif'];
                                $netbill=$revenue-$discount-$nhif;
                                $invoiceno = $res14['billno'];
                                $finalizedby = $res14['username'];
                            }
                            
                            $query15 = "select username from master_transactionpaylater where billnumber = '$invoiceno' and visitcode = '$visitcode' and transactiontype='finalize'";
                            $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die("Error in query15".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res15 = mysqli_fetch_array($exec15);
                            if($finalizedby==''){
                                $finalizedby = $res15['username'];
                            }
                            
                            $totalrevenue += $revenue;
                            $totaldeposit += $deposit;
                            $totaldiscount += $discount;
                            $totalnhif += $nhif;
                            
                            $snocount = $snocount + 1;
                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                            
                            if ($showcolor == 0) {
                                $colorcode = 'class="table-row-even"';
                            } else {
                                $colorcode = 'class="table-row-odd"';
                            }
                            
                            $deposit1=$deposit;
                            $deposit1=abs($deposit);
                            if($revenue<=0) {
                                $revenue=$deposit1;
                            }
                            $netbill=$revenue-$discount-$nhif;
                            $totalnetbill += $netbill;
                        ?>
                            <tr <?php echo $colorcode; ?>>
                                <td class="table-cell text-center"><?php echo $snocount; ?></td>
                                <td class="table-cell"><?php echo $wardname; ?></td>
                                <td class="table-cell"><?php echo $patientcode; ?></td>
                                <td class="table-cell"><?php echo $visitcode; ?></td>
                                <td class="table-cell"><?php echo $patientname; ?></td>
                                <td class="table-cell"><?php echo $admissiondate; ?></td>
                                <td class="table-cell"><?php echo $admissiontime; ?></td>
                                <td class="table-cell"><?php echo $dischargedate; ?></td>
                                <td class="table-cell"><?php echo $dischargetime; ?></td>
                                <td class="table-cell text-center"><?php echo $los; ?></td>
                                <td class="table-cell"><?php echo $accountname; ?></td>
                                <td class="table-cell"><?php echo $wardname; ?></td>
                                <td class="table-cell"><?php echo $admissiondoc; ?></td>
                                <td class="table-cell"><?php echo $consultingdoc; ?></td>
                                <td class="table-cell text-right"><?php echo number_format($revenue,2); ?></td>
                                <td class="table-cell text-right"><?php echo number_format($deposit,2); ?></td>
                                <td class="table-cell text-right"><?php if($discount != 0){echo "-".number_format($discount,2);} else {echo number_format($discount,2);} ?></td>
                                <td class="table-cell text-right"><?php echo number_format($nhif,2); ?></td>
                                <td class="table-cell text-right"><?php echo number_format($netbill,2); ?></td>
                                <td class="table-cell"><?php echo $invoiceno; ?></td>
                                <td class="table-cell"><?php echo $dischargedby; ?></td>
                                <td class="table-cell"><?php echo $finalizedby; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-total-row">
                            <td class="table-cell text-right" colspan="14"><strong>Total:</strong></td>
                            <td class="table-cell text-right"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>
                            <td class="table-cell text-right"><strong><?php echo number_format($totaldeposit,2); ?></strong></td>
                            <td class="table-cell text-right"><strong><?php if($totaldiscount != 0){echo "-".number_format($totaldiscount,2);} else {echo number_format($totaldiscount,2);} ?></strong></td>
                            <td class="table-cell text-right"><strong><?php echo number_format($totalnhif,2); ?></strong></td>
                            <td class="table-cell text-right"><strong><?php echo number_format($totalnetbill,2); ?></strong></td>
                            <td class="table-cell text-right" colspan="3">&nbsp;</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript Functions -->
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('leftSidebar');
            const toggle = document.querySelector('.sidebar-toggle i');
            
            sidebar.classList.toggle('collapsed');
            toggle.classList.toggle('fa-chevron-left');
            toggle.classList.toggle('fa-chevron-right');
        }

        // Page refresh function
        function refreshPage() {
            window.location.reload();
        }

        // Export to Excel function
        function exportToExcel() {
            const exportUrl = 'print_dischargeregisterxls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $ward12; ?>&&locationcode=<?php echo $locationcode1; ?>';
            window.open(exportUrl, '_blank');
        }

        // Print report function
        function printReport() {
            window.print();
        }

        // Initialize sidebar toggle on menu button click
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('leftSidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>

    <!-- Include Required JavaScript Files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>

    <!-- JavaScript for location and ward functionality -->
    <script type="text/javascript">
        window.onload = function () {
            var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
        }

        function funcSubTypeChange1(locationcode) {
            <?php 
            $query12 = "select * from master_location";
            $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($res12 = mysqli_fetch_array($exec12)) {
                $res12subtypeanum = $res12["auto_number"];
                $res12locationname = $res12["locationname"];
                $res12locationcode = $res12["locationcode"];
            ?>
            if(locationcode=="<?php echo $res12locationcode; ?>") {
                document.getElementById("ward").options.length=null; 
                var combo = document.getElementById('ward'); 	
                <?php 
                $loopcount=0;
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 
                <?php
                $query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res10 = mysqli_fetch_array($exec10)) {
                    $loopcount = $loopcount+1;
                    $res10accountnameanum = $res10["auto_number"];
                    $ward = $res10["ward"];
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 
                <?php } ?>
            }
            <?php } ?>
        }

        function ajaxlocationfunction(val) { 
            if (window.XMLHttpRequest) {
                xmlhttp=new XMLHttpRequest();
            } else {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
                    funcSubTypeChange1();
                }
            }
            xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
            xmlhttp.send();
        }
    </script>

</body>
</html>