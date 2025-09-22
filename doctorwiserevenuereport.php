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





$snocount = "";

$colorloopcount="";

$showcolor = "";

$range = "";

$admissiondate = "";

$ipnumber = "";

$patientname = "";

$gender = "";

$admissiondoc = "";

$consultingdoc = "";

$companyname = "";

$bedno = "";

$dischargedate = "";

$wardcode = "";

$locationcode = "";



//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");





if (isset($_REQUEST["wardcode1"])) { $wardcode = $_REQUEST["wardcode1"]; } else { $wardcode = ""; }

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



function clean($string) {
   $string = str_replace("'", "", $string); // Replaces all spaces with hyphens.

   return $string; // Removes special chars.
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Wise Revenue Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/doctor-revenue-modern.css?v=<?php echo time(); ?>">
    
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
    
    <script type="text/javascript">
    window.onload = function () {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
    }
    </script>
    
    <!-- Modern JavaScript -->
    <script src="js/doctor-revenue-modern.js?v=<?php echo time(); ?>"></script>
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
        <span>Doctor Wise Revenue Report</span>
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
                        <a href="doctorwiserevenuereport.php" class="nav-link active">
                            <i class="fas fa-chart-line"></i>
                            <span>Doctor Revenue Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorsactivityreport.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Activity Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorpaymententry.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Doctor Payment Entry</span>
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
                    <h2>Doctor Wise Revenue Report</h2>
                    <p>Comprehensive revenue analysis by doctor with detailed OPD and IPD performance metrics.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-chart-line search-form-icon"></i>
                    <h3 class="search-form-title">Revenue Report Search</h3>
                </div>
                
                <form name="cbform1" method="post" action="doctorwiserevenuereport.php" class="search-form">
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

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        
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
            <?php if(isset($_POST['Submit'])): ?>
            <div class="results-section">
                <div class="results-header">
                    <h3>Revenue Report Results</h3>
                    <div class="results-actions">
                        <a target="_blank" href="print_doctorwiserevenuexls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>" class="btn btn-outline">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
                
                <div class="report-info">
                    <div class="location-info">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><strong>
                        <?php 
                        $query451 = "select * from `master_location`";
                        $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                        $row2 = array();
                        while ($row2[] = mysqli_fetch_assoc($exec451)){
                            $locationcode = $row2[0]['auto_number'];
                            echo "Location: " . $row2[0]['locationname'];
                        }
                        ?>
                        </strong></span>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Doctor</th>
                                <th>Speciality</th>
                                <th>OPD</th>
                                <th>IPD</th>
                                <th>Total</th>
                                <th>OPD Volume</th>
                                <th>Avg. OPD Revenue</th>
                                <th>IPD Volume</th>
                                <th>Avg. IPD Revenue</th>
                                <th>Admission</th>
                                <th>OP to IP Conversion</th>
                            </tr>
                        </thead>
                        <tbody>


        <?php

        $usernames = [];

        $employeecodes = [];

        $sumopdamount = $sumipdamount = $rowtot = $sumrowtot = $sumopdvolume = $sumvagopdrevenue = $sumipdvolume = $sumavdipdrevenue = $sumadmission = $sumopipconversion = $totalrefund = 0;



        /*$query3 = "select employeename, employeecode, username, jobdescription from master_employee";

        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

        while($res3 = mysqli_fetch_array($exec3)){

          $employeecode = $res3['employeecode'];

          $username = $res3['username'];*/



          $query4 = "select doctorname, doctorcode from master_doctor where status <> 'deleted'";

          $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res4 = mysqli_fetch_array($exec4)){

          $employeename1 = $res4['doctorname'];
		  $employeename=clean($employeename1);

          $doctorcode = $res4['doctorcode'];



          $query30 = "select department from master_doctor where doctorcode = '$doctorcode'";

          $exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res30 = mysqli_fetch_array($exec30);

          $departmentid = $res30['department'];



          $query31 = "select department from master_department where auto_number = '$departmentid'";

          $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res31 = mysqli_fetch_array($exec31);

          $speciality = $res31['department'];

          



          $opdamount = $consultation = $pharmacy = $lab = $radiology = $service = $referal = $rescue = $homecare = 0;

          $ipdamount = $billingip = $opdvolume = $avgopdrevenue = $ipdvolume = $ipdrevenue = $avgipdrevenue = $admission = $opipconversion = 0;

          

          //CONSULTATION

           $query1 = "SELECT sum(consultation) as consultation FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res1 = mysqli_fetch_array($exec1)){

              $consultation = $res1['consultation'];

              $opdamount += $consultation;

          }



          $query2 = "SELECT sum(totalamount) as consultation FROM `billing_paylaterconsultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res2 = mysqli_fetch_array($exec2)){

              $consultation = $res2['consultation'];

              $opdamount += $consultation;

          }



          //CONSULTATION REFUND

          $query24a = "SELECT sum(consultation) as consultation1 from refund_consultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename') ";

          $exec24a = mysqli_query($GLOBALS["___mysqli_ston"], $query24a) or die ("Error in Query24a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24a = mysqli_fetch_array($exec24a);

          $r24a = $res24a['consultation1'];



          $query24b = "SELECT sum(fxamount) as consultation1 from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec24b = mysqli_query($GLOBALS["___mysqli_ston"], $query24b) or die ("Error in Query24b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24b = mysqli_fetch_array($exec24b);

          $r24b = $res24b['consultation1'];



          $query24c = "SELECT sum(consultationfxamount) as consultation1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec24c = mysqli_query($GLOBALS["___mysqli_ston"], $query24c) or die ("Error in Query24c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24c = mysqli_fetch_array($exec24c);

          $r24c = $res24c['consultation1'];



          $totalrefund = $r24a + $r24b + $r24c;

          $opdamount = $opdamount - $totalrefund;







          //PHARMACY

          $query5 = "SELECT sum(amount) as pharmacy FROM `billing_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res5 = mysqli_fetch_array($exec5)){

              $pharmacy = $res5['pharmacy'];

              $opdamount += $pharmacy;

          }



          $query6 = "SELECT sum(amount) as pharmacy FROM `billing_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res6 = mysqli_fetch_array($exec6)){

              $pharmacy = $res6['pharmacy'];

              $opdamount += $pharmacy;

          }



          //PHARMACY REFUND

          $query25a = "SELECT sum(amount)as amount1 from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec25a = mysqli_query($GLOBALS["___mysqli_ston"], $query25a) or die ("Error in Query25a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25a = mysqli_fetch_array($exec25a) ;

          $r25a = $res25a['amount1'];



          $query25b = "SELECT sum(amount)as amount1 from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec25b = mysqli_query($GLOBALS["___mysqli_ston"], $query25b) or die ("Error in Query25b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25b = mysqli_fetch_array($exec25b) ;

          $r25b = $res25b['amount1'];



          $query25c = "SELECT sum(pharmacyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec25c = mysqli_query($GLOBALS["___mysqli_ston"], $query25c) or die ("Error in Query25c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25c = mysqli_fetch_array($exec25c) ;

          $r25c = $res25c['amount1'];



          $query25d = "SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`) and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec25d = mysqli_query($GLOBALS["___mysqli_ston"], $query25d) or die ("Error in Query25d".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25d = mysqli_fetch_array($exec25d) ;

          $r25d = $res25d['amount1'];



          $totalrefund = $r25a + $r25b + $r25c + $r25d;

          $opdamount = $opdamount - $totalrefund;







          //LABORATORY

          $query7 = "SELECT sum(labitemrate) as lab FROM `billing_paynowlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res7 = mysqli_fetch_array($exec7)){

              $lab = $res7['lab'];

              $opdamount += $lab;

          }



          $query8 = "SELECT sum(labitemrate) as lab FROM `billing_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res8 = mysqli_fetch_array($exec8)){

              $lab = $res8['lab'];

              $opdamount += $lab;

          }



          //LABORATORY REFUND

          $query26a = "SELECT sum(labitemrate)as labitemrate1 from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec26a = mysqli_query($GLOBALS["___mysqli_ston"], $query26a) or die ("Error in Query26a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26a = mysqli_fetch_array($exec26a) ;

          $r26a = $res26a['labitemrate1'];



          $query26b = "SELECT sum(labitemrate)as labitemrate1 from refund_paynowlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec26b = mysqli_query($GLOBALS["___mysqli_ston"], $query26b) or die ("Error in Query26b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26b = mysqli_fetch_array($exec26b) ;

          $r26b = $res26b['labitemrate1'];



          $query26c = "SELECT sum(labfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec26c = mysqli_query($GLOBALS["___mysqli_ston"], $query26c) or die ("Error in Query26c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26c = mysqli_fetch_array($exec26c) ;

          $r26c = $res26c['amount1'];



          $totalrefund = $r26a + $r26b + $r26c; 

          $opdamount = $opdamount - $totalrefund;







          //RADIOLOGY

          $query9 = "SELECT sum(radiologyitemrate) as radiology FROM `billing_paynowradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res9 = mysqli_fetch_array($exec9)){

              $radiology = $res9['radiology'];

              $opdamount += $radiology;

          }



          $query10 = "SELECT sum(radiologyitemrate) as radiology FROM `billing_paylaterradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res10 = mysqli_fetch_array($exec10)){

              $radiology = $res10['radiology'];

              $opdamount += $radiology;

          }



          //RADIOLOGY REFUND

          $query27a = "SELECT sum(fxamount) as radiologyitemrate1 from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec27a = mysqli_query($GLOBALS["___mysqli_ston"], $query27a) or die ("Error in Query27a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27a = mysqli_fetch_array($exec27a) ;

          $r27a = $res27a['radiologyitemrate1'];



          $query27b = "SELECT sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec27b = mysqli_query($GLOBALS["___mysqli_ston"], $query27b) or die ("Error in Query27b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27b = mysqli_fetch_array($exec27b) ;

          $r27b = $res27b['radiologyitemrate1'];



          $query27c = "SELECT sum(radiologyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec27c = mysqli_query($GLOBALS["___mysqli_ston"], $query27c) or die ("Error in Query27c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27c = mysqli_fetch_array($exec27c) ;

          $r27c = $res27c['amount1'];



          $totalrefund = $r27a + $r27b + $r27c; 

          $opdamount = $opdamount - $totalrefund;







          //SERVICES

          $query11 = "SELECT sum(fxamount) as service FROM `billing_paynowservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res11 = mysqli_fetch_array($exec11)){

              $service = $res11['service'];

              $opdamount += $service;

          }



          $query12 = "SELECT sum(fxamount) as service FROM `billing_paylaterservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res12 = mysqli_fetch_array($exec12)){

              $service = $res12['service'];

              $opdamount += $service;

          }



          //SERVICES REFUND

          $query28a = "SELECT sum(fxamount) as servicesitemrate1 from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec28a= mysqli_query($GLOBALS["___mysqli_ston"], $query28a) or die ("Error in Query28a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28a = mysqli_fetch_array($exec28a) ;

          $r28a = $res28a['servicesitemrate1'];



          $query28b = "SELECT sum(servicetotal) as servicesitemrate1 from refund_paynowservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec28b = mysqli_query($GLOBALS["___mysqli_ston"], $query28b) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28b = mysqli_fetch_array($exec28b) ;

          $r28b = $res28b['servicesitemrate1'];



          $query28c = "SELECT sum(servicesfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec28c = mysqli_query($GLOBALS["___mysqli_ston"], $query28c) or die ("Error in Query28c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28c = mysqli_fetch_array($exec28c) ;

          $r28c = $res28c['amount1'];



          $totalrefund = $r28a + $r28b + $r28c; 

          $opdamount = $opdamount - $totalrefund;







          //REFERAL

          $query13 = "SELECT sum(referalrate) as referal FROM `billing_paynowreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res13 = mysqli_fetch_array($exec13)){

              $referal = $res13['referal'];

              $opdamount += $referal;

          }



          $query14 = "SELECT sum(referalrate) as referal FROM `billing_paylaterreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res14 = mysqli_fetch_array($exec14)){

              $referal = $res14['referal'];

              $opdamount += $referal;

          }



          //REFERAL REFUND

          $query29a = "SELECT sum(referalrate) as referalrate1 from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec29a= mysqli_query($GLOBALS["___mysqli_ston"], $query29a) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res29a = mysqli_fetch_array($exec29a) ;

          $r29a = $res29a['referalrate1'];



          $query29b = "SELECT sum(referalrate) as referalrate1 from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec29b = mysqli_query($GLOBALS["___mysqli_ston"], $query29b) or die ("Error in Query29b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res29b = mysqli_fetch_array($exec29b) ;

          $r29b = $res29b['referalrate1'];



          $totalrefund = $r29a + $r29b; 

          $opdamount = $opdamount - $totalrefund; 







          //AMBULANCE

          $query15 = "SELECT sum(amount) as rescue FROM `billing_opambulance` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die("Error in query15".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res15 = mysqli_fetch_array($exec15)){

              $rescue = $res15['rescue'];

              $opdamount += $rescue;

          }



          $query16 = "SELECT sum(amount) as rescue FROM `billing_opambulancepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die("Error in query16".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res16 = mysqli_fetch_array($exec16)){

              $rescue = $res16['rescue'];

              $opdamount += $rescue;

          }







          //HOMECARE

          $query17 = "SELECT sum(amount) as homecare FROM `billing_homecare` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die("Error in query17".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res17 = mysqli_fetch_array($exec17)){

              $homecare = $res17['homecare'];

              $opdamount += $homecare;

          }



          $query18 = "SELECT sum(amount) as homecare FROM `billing_homecarepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename')";

          $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die("Error in query18".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res18 = mysqli_fetch_array($exec18)){

              $homecare = $res18['homecare'];

              $opdamount += $homecare;

          }



          $sumopdamount += $opdamount;





          //BILLING IP

          $query19 = "SELECT sum(totalrevenue) as billingip FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')";

          $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die("Error in query19".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res19 = mysqli_fetch_array($exec19)){

              $billingip = $res19['billingip'];

              $ipdamount += $billingip;

          }





          //IP CREDIT APPROVED

          $query20 = "SELECT sum(totalrevenue) as billingip FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')";

          $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die("Error in query20".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res20 = mysqli_fetch_array($exec20)){

              $billingip = $res20['billingip'];

              $ipdamount += $billingip;

          }



          //IP DISCOUNT 

          $query30 = "SELECT sum(rate) as amount from ip_discount where consultationdate between '$ADate1' and '$ADate2' and patientvisitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')";

          $exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));

          $num30 = mysqli_num_rows($exec30);

          $res30 = mysqli_fetch_array($exec30);

          $ipdiscamount = $res30['amount'];



          $ipdamount = $ipdamount - $ipdiscamount;



          //REBATE

          $query16 = "SELECT sum(amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode') ";

          $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));

          $num16=mysqli_num_rows($exec16);

          $res16 = mysqli_fetch_array($exec16);

          $rebateamount = $res16['rebate'];



          $ipdamount = $ipdamount - $rebateamount;



          $sumipdamount += $ipdamount;

          $rowtot = $opdamount + $ipdamount;







          //OPD VOLUME

          $query21 = "SELECT sum(count) as count from (SELECT count(visitcode) as count FROM billing_paynow WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename') UNION ALL SELECT count(visitcode) as count FROM billing_paylater WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username = '$employeename') ) as count1";

          $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die("Error in query21".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res21 = mysqli_fetch_array($exec21)){

              $opdvolume = $res21['count'];

              $sumopdvolume += $opdvolume;

          }



          //IPD VOLUME

          $query22 = "SELECT sum(count) as count from (SELECT count(totalrevenue) as count FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode') UNION ALL SELECT count(totalrevenue) as count FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')) as count1";

          $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die("Error in query22".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res22 = mysqli_fetch_array($exec22)){

              $ipdvolume = $res22['count'];

              $sumipdvolume += $ipdvolume;

          }



          //ADMISSION COUNT

          $query23 = "SELECT count(visitcode) as admission FROM `ip_bedallocation` where recorddate between '$ADate1' and '$ADate2' and visitcode in (select visitcode from master_ipvisitentry where opdoctorcode = '$doctorcode')";

          $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die("Error in query23".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res23 = mysqli_fetch_array($exec23)){

              $admission = $res23['admission'];

              $sumadmission += $admission;

          }



          if($opdvolume != 0 and $opdamount != 0){

            $avgopdrevenue = $opdamount / $opdvolume;

          } else {

            $avgopdrevenue = 0;

          }



          if($ipdvolume != 0 and $ipdamount != 0){

            $avgipdrevenue = $ipdamount / $ipdvolume;

          } else {

            $avgipdrevenue = 0;

          }



          if($admission != 0 and $opdvolume != 0){

            $opipconversion = ($admission / $opdvolume)*100;

          } else {

            $opipconversion = 0;

          }



          $snocount = $snocount + 1;



          $colorloopcount = $colorloopcount + 1;

          $showcolor = ($colorloopcount & 1); 

          if ($showcolor == 0)

          {

            $colorcode = 'bgcolor="#CBDBFA"';

          }

          else

          {

            $colorcode = 'bgcolor="#ecf0f5"';

          }



          array_push($usernames, $employeename);



          array_push($employeecodes, $doctorcode);



        ?>



                            <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>">
                                <td><?php echo $snocount; ?></td>
                                <td><?php echo htmlspecialchars($employeename); ?></td>
                                <td><?php echo htmlspecialchars($speciality); ?></td>
                                <td class="text-right"><?php echo number_format($opdamount,2); ?></td>
                                <td class="text-right"><?php echo number_format($ipdamount,2); ?></td>
                                <td class="text-right"><?php echo number_format($rowtot,2); ?></td>
                                <td class="text-right"><?php echo number_format($opdvolume); ?></td>
                                <td class="text-right"><?php echo number_format($avgopdrevenue,2); ?></td>
                                <td class="text-right"><?php echo number_format($ipdvolume); ?></td>
                                <td class="text-right"><?php echo number_format($avgipdrevenue,2); ?></td>
                                <td class="text-right"><?php echo number_format($admission); ?></td>
                                <td class="text-right"><?php echo number_format($opipconversion,2)."%"; ?></td>
                            </tr>



        <?php

        }

           

        ?>



        <?php

          array_push($usernames, '');

          array_push($employeecodes, '');



          $used_usernames = implode("','" ,$usernames);

          $used_employeecodes = implode("','" ,$employeecodes);



          $opdamount = $consultation = $pharmacy = $lab = $radiology = $service = $referal = $rescue = $homecare = 0;

          $ipdamount = $billingip = $opdvolume = $avgopdrevenue = $ipdvolume = $ipdrevenue = $avgipdrevenue = $admission = $opipconversion = 0;

          

          //CONSULTATION

          $query1 = "SELECT sum(consultation) as consultation from (SELECT sum(consultation) as consultation FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL 

            SELECT sum(consultation) as consultation FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username != '' ) ) as consultation1;";

          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res1 = mysqli_fetch_array($exec1)){

              $consultation = $res1['consultation'];

              $opdamount += $consultation;

          }



          $query2 = "SELECT sum(consultation) as consultation from (SELECT sum(totalamount) as consultation FROM `billing_paylaterconsultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(totalamount) as consultation FROM `billing_paylaterconsultation` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username != '') ) as consultation1";

          $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res2 = mysqli_fetch_array($exec2)){

              $consultation = $res2['consultation'];

              $opdamount += $consultation;

          }



          //CONSULTATION REFUND

          $query24a = "SELECT sum(consultation1) as consultation1 from (SELECT sum(consultation) as consultation1 from refund_consultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(consultation) as consultation1 from refund_consultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')) as consultation";

          $exec24a = mysqli_query($GLOBALS["___mysqli_ston"], $query24a) or die ("Error in Query24a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24a = mysqli_fetch_array($exec24a);

          $r24a = $res24a['consultation1'];



          $query24b = "SELECT sum(consultation1) as consultation1 from (SELECT sum(fxamount) as consultation1 from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username NOT IN ('$used_usernames')) UNION ALL SELECT sum(fxamount) as consultation1 from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')) as consultation";

          $exec24b = mysqli_query($GLOBALS["___mysqli_ston"], $query24b) or die ("Error in Query24b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24b = mysqli_fetch_array($exec24b);

          $r24b = $res24b['consultation1'];



          $query24c = "SELECT sum(consultation1) as consultation1 from (SELECT sum(consultationfxamount) as consultation1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(consultationfxamount) as consultation1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as consultation";

          $exec24c = mysqli_query($GLOBALS["___mysqli_ston"], $query24c) or die ("Error in Query24c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res24c = mysqli_fetch_array($exec24c);

          $r24c = $res24c['consultation1'];



          $totalrefund = $r24a + $r24b + $r24c;

          $opdamount = $opdamount - $totalrefund;







          //PHARMACY

          $query5 = "SELECT sum(pharmacy) as pharmacy from (SELECT sum(amount) as pharmacy FROM `billing_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL 

            SELECT sum(amount) as pharmacy FROM `billing_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

          ) as pharmacy1";

          $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res5 = mysqli_fetch_array($exec5)){

              $pharmacy = $res5['pharmacy'];

              $opdamount += $pharmacy;

          }



          $query6 = "SELECT sum(pharmacy) as pharmacy from (SELECT sum(amount) as pharmacy FROM `billing_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL

            SELECT sum(amount) as pharmacy FROM `billing_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

            ) as pharmacy1";

          $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res6 = mysqli_fetch_array($exec6)){

              $pharmacy = $res6['pharmacy'];

              $opdamount += $pharmacy;

          }



          //PHARMACY REFUND

          $query25a = "SELECT sum(amount1) as amount1 from (SELECT sum(amount)as amount1 from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(amount)as amount1 from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec25a = mysqli_query($GLOBALS["___mysqli_ston"], $query25a) or die ("Error in Query25a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25a = mysqli_fetch_array($exec25a) ;

          $r25a = $res25a['amount1'];



          $query25b = "SELECT sum(amount1) as amount1 from (SELECT sum(amount)as amount1 from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(amount)as amount1 from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec25b = mysqli_query($GLOBALS["___mysqli_ston"], $query25b) or die ("Error in Query25b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25b = mysqli_fetch_array($exec25b) ;

          $r25b = $res25b['amount1'];



          $query25c = "SELECT sum(amount1) as amount1 from (SELECT sum(pharmacyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))  UNION ALL SELECT sum(pharmacyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec25c = mysqli_query($GLOBALS["___mysqli_ston"], $query25c) or die ("Error in Query25c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25c = mysqli_fetch_array($exec25c) ;

          $r25c = $res25c['amount1'];



          $query25d = "SELECT sum(amount1) as amount1 from (SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`) and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`) and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')  ) as amount";

          $exec25d = mysqli_query($GLOBALS["___mysqli_ston"], $query25d) or die ("Error in Query25d".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res25d = mysqli_fetch_array($exec25d) ;

          $r25d = $res25d['amount1'];



          $totalrefund = $r25a + $r25b + $r25c + $r25d;

          $opdamount = $opdamount - $totalrefund;







          //LABORATORY

          $query7 = "SELECT sum(lab) as lab from (SELECT sum(labitemrate) as lab FROM `billing_paynowlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username NOT IN ('$used_usernames')) 

            UNION ALL

            SELECT sum(labitemrate) as lab FROM `billing_paynowlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and accountname = 'CASH - HOSPITAL' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) AS lab1";

          $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res7 = mysqli_fetch_array($exec7)){

              $lab = $res7['lab'];

              $opdamount += $lab;

          }



          $query8 = "SELECT sum(lab) as lab from (SELECT sum(labitemrate) as lab FROM `billing_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(labitemrate) as lab FROM `billing_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') )

            as lab1";

          $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res8 = mysqli_fetch_array($exec8)){

              $lab = $res8['lab'];

              $opdamount += $lab;

          }



           //LABORATORY REFUND

          $query26a = "SELECT sum(labitemrate1) as labitemrate1 from (SELECT sum(labitemrate)as labitemrate1 from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(labitemrate)as labitemrate1 from refund_paylaterlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as labitem1";

          $exec26a = mysqli_query($GLOBALS["___mysqli_ston"], $query26a) or die ("Error in Query26a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26a = mysqli_fetch_array($exec26a) ;

          $r26a = $res26a['labitemrate1'];



          $query26b = "SELECT sum(labitemrate1) as labitemrate1 from (SELECT sum(labitemrate)as labitemrate1 from refund_paynowlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(labitemrate)as labitemrate1 from refund_paynowlab where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')  ) as labitem1";

          $exec26b = mysqli_query($GLOBALS["___mysqli_ston"], $query26b) or die ("Error in Query26b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26b = mysqli_fetch_array($exec26b) ;

          $r26b = $res26b['labitemrate1'];



          $query26c = "SELECT sum(amount1) as amount1 from (SELECT sum(labfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(labfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec26c = mysqli_query($GLOBALS["___mysqli_ston"], $query26c) or die ("Error in Query26c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res26c = mysqli_fetch_array($exec26c) ;

          $r26c = $res26c['amount1'];



          $totalrefund = $r26a + $r26b + $r26c; 

          $opdamount = $opdamount - $totalrefund;







          //RADIOLOGY

          $query9 = "SELECT sum(radiology) as radiology from (SELECT sum(radiologyitemrate) as radiology FROM `billing_paynowradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(radiologyitemrate) as radiology FROM `billing_paynowradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as radiology1";

          $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res9 = mysqli_fetch_array($exec9)){

              $radiology = $res9['radiology'];

              $opdamount += $radiology;

          }



          $query10 = "SELECT sum(radiology) as radiology from (SELECT sum(radiologyitemrate) as radiology FROM `billing_paylaterradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL

            SELECT sum(radiologyitemrate) as radiology FROM `billing_paylaterradiology` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

          ) as radiology1";

          $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res10 = mysqli_fetch_array($exec10)){

              $radiology = $res10['radiology'];

              $opdamount += $radiology;

          }



          //RADIOLOGY REFUND

          $query27a = "SELECT sum(radiologyitemrate1) as radiologyitemrate1 from (SELECT sum(fxamount) as radiologyitemrate1 from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(fxamount) as radiologyitemrate1 from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as rad1";

          $exec27a = mysqli_query($GLOBALS["___mysqli_ston"], $query27a) or die ("Error in Query27a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27a = mysqli_fetch_array($exec27a) ;

          $r27a = $res27a['radiologyitemrate1'];



          $query27b = "SELECT sum(radiologyitemrate1) as radiologyitemrate1 from (SELECT sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as rad1";

          $exec27b = mysqli_query($GLOBALS["___mysqli_ston"], $query27b) or die ("Error in Query27b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27b = mysqli_fetch_array($exec27b) ;

          $r27b = $res27b['radiologyitemrate1'];



          $query27c = "SELECT sum(amount1) as amount1 from (SELECT sum(radiologyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(radiologyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec27c = mysqli_query($GLOBALS["___mysqli_ston"], $query27c) or die ("Error in Query27c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res27c = mysqli_fetch_array($exec27c) ;

          $r27c = $res27c['amount1'];



          $totalrefund = $r27a + $r27b + $r27c; 

          $opdamount = $opdamount - $totalrefund;







          //SERVICES

          $query11 = "SELECT sum(service) as service from (SELECT sum(fxamount) as service FROM `billing_paynowservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username NOT IN ('$used_usernames')) 

            UNION ALL

            SELECT sum(fxamount) as service FROM `billing_paynowservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as services1";

          $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res11 = mysqli_fetch_array($exec11)){

              $service = $res11['service'];

              $opdamount += $service;

          }



          $query12 = "SELECT sum(service) as service from (SELECT sum(fxamount) as service FROM `billing_paylaterservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username NOT IN ('$used_usernames'))

            UNION ALL 

            SELECT sum(fxamount) as service FROM `billing_paylaterservices` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

            ) as services";

          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res12 = mysqli_fetch_array($exec12)){

              $service = $res12['service'];

              $opdamount += $service;

          }



          //SERVICES REFUND

          $query28a = "SELECT sum(servicesitemrate1) as servicesitemrate1 from (SELECT sum(fxamount) as servicesitemrate1 from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(fxamount) as servicesitemrate1 from refund_paylaterservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as service1";

          $exec28a= mysqli_query($GLOBALS["___mysqli_ston"], $query28a) or die ("Error in Query28a".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28a = mysqli_fetch_array($exec28a) ;

          $r28a = $res28a['servicesitemrate1'];



          $query28b = "SELECT sum(servicesitemrate1) as servicesitemrate1 from (SELECT sum(servicetotal) as servicesitemrate1 from refund_paynowservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(servicetotal) as servicesitemrate1 from refund_paynowservices where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amoount1";

          $exec28b = mysqli_query($GLOBALS["___mysqli_ston"], $query28b) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28b = mysqli_fetch_array($exec28b) ;

          $r28b = $res28b['servicesitemrate1'];



          $query28c = "SELECT sum(amount1) as amount1 from (SELECT sum(servicesfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(servicesfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec28c = mysqli_query($GLOBALS["___mysqli_ston"], $query28c) or die ("Error in Query28c".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res28c = mysqli_fetch_array($exec28c) ;

          $r28c = $res28c['amount1'];



          $totalrefund = $r28a + $r28b + $r28c; 

          $opdamount = $opdamount - $totalrefund;







          //REFERAL

          $query13 = "SELECT sum(referal) as referal from (SELECT sum(referalrate) as referal FROM `billing_paynowreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(referalrate) as referal FROM `billing_paynowreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

            ) as referal1";

          $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res13 = mysqli_fetch_array($exec13)){

              $referal = $res13['referal'];

              $opdamount += $referal;

          }



          $query14 = "SELECT sum(referal) as referal from (SELECT sum(referalrate) as referal FROM `billing_paylaterreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(referalrate) as referal FROM `billing_paylaterreferal` WHERE `billdate` BETWEEN '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as referal1";

          $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res14 = mysqli_fetch_array($exec14)){

              $referal = $res14['referal'];

              $opdamount += $referal;

          }



          //REFERAL REFUND

          $query29a = "SELECT sum(referalrate1) as referalrate1 from (SELECT sum(referalrate) as referalrate1 from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(referalrate) as referalrate1 from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') ) as amount";

          $exec29a= mysqli_query($GLOBALS["___mysqli_ston"], $query29a) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res29a = mysqli_fetch_array($exec29a) ;

          $r29a = $res29a['referalrate1'];



          $query29b = "SELECT sum(referalrate1) as referalrate1 from (SELECT sum(referalrate) as referalrate1 from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT sum(referalrate) as referalrate1 from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' and patientvisitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')) as referal";

          $exec29b = mysqli_query($GLOBALS["___mysqli_ston"], $query29b) or die ("Error in Query29b".mysqli_error($GLOBALS["___mysqli_ston"]));

          $res29b = mysqli_fetch_array($exec29b) ;

          $r29b = $res29b['referalrate1'];



          $totalrefund = $r29a + $r29b; 

          $opdamount = $opdamount - $totalrefund; 







          //AMBULANCE

          $query15 = "SELECT sum(rescue) as rescue from (SELECT sum(amount) as rescue FROM `billing_opambulance` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(amount) as rescue FROM `billing_opambulance` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as rescue1";

          $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die("Error in query15".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res15 = mysqli_fetch_array($exec15)){

              $rescue = $res15['rescue'];

              $opdamount += $rescue;

          }



          $query16 = "SELECT sum(rescue) as rescue from (SELECT sum(amount) as rescue FROM `billing_opambulancepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) 

            UNION ALL

            SELECT sum(amount) as rescue FROM `billing_opambulancepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as rescue1";

          $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die("Error in query16".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res16 = mysqli_fetch_array($exec16)){

              $rescue = $res16['rescue'];

              $opdamount += $rescue;

          }







          //HOMECARE

          $query17 = "SELECT sum(homecare) as homecare from (SELECT sum(amount) as homecare FROM `billing_homecare` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL

            SELECT sum(amount) as homecare FROM `billing_homecare` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') 

            ) as homecare1";

          $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die("Error in query17".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res17 = mysqli_fetch_array($exec17)){

              $homecare = $res17['homecare'];

              $opdamount += $homecare;

          }



          $query18 = "SELECT sum(homecare) as homecare from (SELECT sum(amount) as homecare FROM `billing_homecarepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames'))

            UNION ALL

            SELECT sum(amount) as homecare FROM `billing_homecarepaylater` WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '')

            ) as homecare1";

          $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die("Error in query18".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res18 = mysqli_fetch_array($exec18)){

              $homecare = $res18['homecare'];

              $opdamount += $homecare;

          }



          $sumopdamount += $opdamount;





          //BILLING IP

          $query19 = "SELECT sum(billingip) as billingip from (SELECT sum(totalrevenue) as billingip FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) 

            UNION ALL

            SELECT sum(totalrevenue) as billingip FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '')

          ) as billingip1";

          $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die("Error in query19".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res19 = mysqli_fetch_array($exec19)){

              $billingip = $res19['billingip'];

              $ipdamount += $billingip;

          }



          //IP CREDIT APPROVED

          $query20 = "SELECT SUM(billingip) as billingip from (SELECT sum(totalrevenue) as billingip FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) 

            UNION ALL

            SELECT sum(totalrevenue) as billingip FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '') 

          ) as billingip1";

          $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die("Error in query20".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res20 = mysqli_fetch_array($exec20)){

              $billingip = $res20['billingip'];

              $ipdamount += $billingip;

          }



          //IP DISCOUNT 

          $query30 = "SELECT sum(amount) as amount from (SELECT sum(rate) as amount from ip_discount where consultationdate between '$ADate1' and '$ADate2' and patientvisitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) 

            UNION ALL

            SELECT sum(rate) as amount from ip_discount where consultationdate between '$ADate1' and '$ADate2' and patientvisitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '') 

          ) as amount1";

          $exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));

          $num30 = mysqli_num_rows($exec30);

          $res30 = mysqli_fetch_array($exec30);

          $ipdiscamount = $res30['amount'];



          $ipdamount = $ipdamount - $ipdiscamount;



          //REBATE

          $query16 = "SELECT SUM(rebate) as rebate from (SELECT sum(amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) 

            UNION ALL

            SELECT sum(amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '')

          ) as rebate1";

          $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));

          $num16=mysqli_num_rows($exec16);

          $res16 = mysqli_fetch_array($exec16);

          $rebateamount = $res16['rebate'];



          $ipdamount = $ipdamount - $rebateamount;





          

          //COUNT OPD VOLUME

          $query21 = "SELECT sum(count) as count from (SELECT count(visitcode) as count FROM billing_paynow WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT count(visitcode) as count FROM billing_paylater WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username not in ('$used_usernames')) UNION ALL SELECT count(visitcode) as count FROM billing_paynow WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '') UNION ALL SELECT count(visitcode) as count FROM billing_paylater WHERE billdate BETWEEN '$ADate1' and '$ADate2' and visitcode not in (select patientvisitcode from master_consultation where recorddate BETWEEN '$ADate1' and '$ADate2' and username <> '' ) ) as count1";

          $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die("Error in query21".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res21 = mysqli_fetch_array($exec21)){

              $opdvolume = $res21['count'];

              $sumopdvolume += $opdvolume;

          }



          //COUNT IPD VOLUME

          $query22 = "SELECT sum(count) as count from (SELECT count(totalrevenue) as count FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '') UNION ALL SELECT count(totalrevenue) as count FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode NOT IN (select visitcode from master_ipvisitentry where opdoctorcode <> '') UNION ALL SELECT count(totalrevenue) as count FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) UNION ALL SELECT count(totalrevenue) as count FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes'))) as count1";

          $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die("Error in query22".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res22 = mysqli_fetch_array($exec22)){

              $ipdvolume = $res22['count'];

              $sumipdvolume += $ipdvolume;

          }



          //COUNT ADMISSIONS

          $query23 = "SELECT sum(admission) as admission from (SELECT count(visitcode) as admission FROM `ip_bedallocation` where recorddate between '$ADate1' and '$ADate2' and visitcode in (select visitcode from master_ipvisitentry where opdoctorcode NOT IN ('$used_employeecodes')) UNION ALL SELECT count(visitcode) as admission FROM `ip_bedallocation` where recorddate between '$ADate1' and '$ADate2' and visitcode not in (select visitcode from master_ipvisitentry where opdoctorcode <> '' ) ) as admission1";

          $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die("Error in query23".mysqli_error($GLOBALS["___mysqli_ston"]));

          while($res23 = mysqli_fetch_array($exec23)){

              $admission = $res23['admission'];

              $sumadmission += $admission;

          }



          $sumipdamount += $ipdamount;

          $rowtot = $opdamount + $ipdamount;



          if($opdvolume != 0 and $opdamount != 0){

            $avgopdrevenue = $opdamount / $opdvolume;

          } else {

            $avgopdrevenue = 0;

          }



          if($ipdvolume != 0 and $ipdamount != 0){

            $avgipdrevenue = $ipdamount / $ipdvolume;

          } else {

            $avgipdrevenue = 0;

          }



          if($admission != 0 and $opdvolume != 0){

            $opipconversion = ($admission / $opdvolume)*100;

          } else {

            $opipconversion = 0;

          }



          $snocount = $snocount + 1;



          $colorloopcount = $colorloopcount + 1;

          $showcolor = ($colorloopcount & 1); 

          if ($showcolor == 0)

          {

            $colorcode = 'bgcolor="#CBDBFA"';

          }

          else

          {

            $colorcode = 'bgcolor="#ecf0f5"';

          }



        ?>



                            <tr class="walkins-row">
                                <td><?php echo $snocount; ?></td>
                                <td><strong>WALKINS</strong></td>
                                <td><strong>WALKINS</strong></td>
                                <td class="text-right"><?php echo number_format($opdamount,2); ?></td>
                                <td class="text-right"><?php echo number_format($ipdamount,2); ?></td>
                                <td class="text-right"><?php echo number_format($rowtot,2); ?></td>
                                <td class="text-right"><?php echo number_format($opdvolume); ?></td>
                                <td class="text-right"><?php echo number_format($avgopdrevenue,2); ?></td>
                                <td class="text-right"><?php echo number_format($ipdvolume); ?></td>
                                <td class="text-right"><?php echo number_format($avgipdrevenue,2); ?></td>
                                <td class="text-right"><?php echo number_format($admission); ?></td>
                                <td class="text-right"><?php echo number_format($opipconversion,2)."%"; ?></td>
                            </tr>

        <?php 

        $sumrowtot = $sumopdamount + $sumipdamount;



        if($sumopdvolume != 0 and $sumopdamount != 0){

          $sumvagopdrevenue = $sumopdamount / $sumopdvolume;

        } else {

          $sumvagopdrevenue = 0;

        }



        if($sumipdvolume != 0 and $sumipdamount != 0){

          $sumavdipdrevenue = $sumipdamount / $sumipdvolume;

        } else {

          $sumavdipdrevenue = 0;

        }



        if($sumadmission != 0 and $sumopdvolume != 0){

          $sumopipconversion = ($sumadmission / $sumopdvolume)*100;

        } else {

          $sumopipconversion = 0;

        }



        ?>

                            <tr class="totals-row">
                                <td></td>
                                <td></td>
                                <td><strong>TOTALS</strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumopdamount,2); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumipdamount,2); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumrowtot,2); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumopdvolume); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumvagopdrevenue,2); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumipdvolume); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumavdipdrevenue,2); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumadmission); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($sumopipconversion,2)."%"; ?></strong></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>

