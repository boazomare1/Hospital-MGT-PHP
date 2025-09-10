

<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION['username'];



$docno = $_SESSION['docno'];



 $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Patient Details - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ippatientdetails-modern.css?v=<?php echo time(); ?>">
    
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
        <span>IP Patient Details</span>
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
                        <a href="cashradiologyrefund.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Cash Radiology Refund</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashrefundapprovallist.php" class="nav-link">
                            <i class="fas fa-check-circle"></i>
                            <span>Refund Approval List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashrefundsreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Cash Refunds Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashservicesrefund.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Cash Services Refund</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ippatientdetails.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>IP Patient Details</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <?php
            $companyanum = $_SESSION['companyanum'];
            $companyname = $_SESSION['companyname'];
            $transactiondatefrom = date('Y-m-d');
            $transactiondateto = date('Y-m-d');
            
            $colorloopcount = '';
            $sno = '';
            
            if (isset($_REQUEST["cbfrmflag1"])) { 
                $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
            } else { 
                $cbfrmflag1 = ""; 
            }
            
            $query1111 = "select * from master_employee where username = '$username'";
            $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            while ($res1111 = mysqli_fetch_array($exec1111)) {
                $locationnumber = $res1111["location"];
                $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";
                $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                while ($res1112 = mysqli_fetch_array($exec1112)) {
                    $locationname = $res1112["locationname"];    
                    $locationcode = $res1112["locationcode"];
                }
            }
            
            if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
            if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
            if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
            if(isset($_POST['ADate1'])){ $fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
            if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
            ?>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>IP Patient Details</h2>
                    <p>View and manage inpatient patient details, admissions, and billing information.</p>
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
                    <h3 class="search-form-title">Search IP Patients</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="ippatientdetails.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $locationname = $res["locationname"];
                                    $locationcode1 = $res["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode1) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $locationcode1; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($locationname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                   class="form-input date-input" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                   class="form-input date-input" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" 
                                   placeholder="Enter patient name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   placeholder="Enter registration number" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit No</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" 
                                   placeholder="Enter visit number" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                        <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Table Section -->
            <div class="results-table-section">
                <div class="results-table-header">
                    <i class="fas fa-list results-table-icon"></i>
                    <h3 class="results-table-title">IP Patient Details</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Patient Code</th>
                            <th>Visit Code</th>
                            <th>Bill No.</th>
                            <th>Admission Date</th>
                            <th>Discharge Date</th>
                            <th>Ward</th>
                            <th>Account Name</th>
                            <th>Total Amount</th>
                            <th>Amount Allocated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cbfrmflag1 = isset($_REQUEST['cbfrmflag1']) ? $_REQUEST['cbfrmflag1'] : '';
                        if($cbfrmflag1 == 'cbfrmflag1') {
                            $scount = 0;
                            $colorloopcount = 0;
                            
                            $patientdetails = "select patientcode,visitcode,patientname,billno,totalamount,accountname from billing_ipcreditapproved where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and billdate between '$fromdate' and '$todate' and locationcode='$locationcode' group by visitcode order by auto_number desc";
                            
                            $exepatient = mysqli_query($GLOBALS["___mysqli_ston"], $patientdetails) or die("Error in patientdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $numrow = mysqli_num_rows($exepatient);
                            
                            while($respatient = mysqli_fetch_array($exepatient)) {
                                $patientcode = $respatient['patientcode'];
                                $visitcode = $respatient['visitcode'];
                                $patientname = $respatient['patientname'];
                                $billnum = $respatient['billno'];
                                $totalamount = $respatient['totalamount'];
                                $accountname = $respatient['accountname'];
                                
                                $admission = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode='$visitcode' order by auto_number asc") or die("Error in admission".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $resdata = mysqli_fetch_array($admission);
                                $dateofaddmission = $resdata['recorddate'];
                                
                                $discharge = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_discharge where visitcode='$visitcode' group by visitcode") or die("Error in discharge".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $resdis = mysqli_fetch_array($discharge);
                                $dischargedate = $resdis['recorddate'];
                                
                                $warddetails = mysqli_query($GLOBALS["___mysqli_ston"], "select ward from master_ward where auto_number in(select ward from ip_bedallocation where visitcode='$visitcode' and recordstatus not in('transfered')) order by auto_number desc") or die("Error in warddetails".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $resward = mysqli_fetch_array($warddetails);
                                $wardname = $resward['ward'];
                                
                                if($wardname == '') {
                                    $warddetails = mysqli_query($GLOBALS["___mysqli_ston"], "select ward from master_ward where auto_number in(select ward from ip_bedtransfer where visitcode='$visitcode' and recordstatus not in('transfered')) order by auto_number desc") or die("Error in warddetails".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $resward = mysqli_fetch_array($warddetails);
                                    $wardname = $resward['ward'];   
                                }
                                
                                $payment = "select receivableamount,transactionamount,accountname from master_transactionpaylater where visitcode='$visitcode' and transactionamount<>'0' and acc_flag='0' and recordstatus='allocated' and billnumber='$billnum' order by auto_number desc";
                                $exepay = mysqli_query($GLOBALS["___mysqli_ston"], $payment) or die("Error in payment".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $paidamount = '0';
                                
                                while($respay = mysqli_fetch_array($exepay)) {
                                    $paidamount += $respay['transactionamount'];
                                }
                                
                                $scount = $scount + 1;
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                        ?>
                        <tr class="<?php echo $rowclass; ?>">
                            <td class="modern-cell"><?php echo $scount; ?></td>
                            <td class="modern-cell">
                                <div class="patient-info">
                                    <strong><?php echo htmlspecialchars($patientname); ?></strong>
                                </div>
                            </td>
                            <td class="modern-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($visitcode); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($billnum); ?></td>
                            <td class="modern-cell"><?php echo $dateofaddmission; ?></td>
                            <td class="modern-cell"><?php echo $dischargedate; ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($wardname); ?></td>
                            <td class="modern-cell"><?php echo htmlspecialchars($accountname); ?></td>
                            <td class="modern-cell amount"><?php echo number_format($totalamount, 2, '.', ','); ?></td>
                            <td class="modern-cell amount"><?php echo number_format($paidamount, 2, '.', ','); ?></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                
                <?php if($cbfrmflag1 == 'cbfrmflag1') { ?>
                <div class="export-section">
                    <a href="print_patientdetails.php?patient=<?php echo $searchpatient; ?>&patientcode=<?php echo $searchpatientcode; ?>&visitcode=<?php echo $searchvisitcode; ?>&ADate1=<?php echo $fromdate; ?>&ADate2=<?php echo $todate; ?>&location=<?php echo $locationcode; ?>" class="btn btn-outline">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ippatientdetails-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Date Picker Scripts -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
</body>
</html>



