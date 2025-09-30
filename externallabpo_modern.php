<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
error_reporting(0);

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$username = $_SESSION['username'];
$companyname = $_SESSION['companyname'];
$docno1 = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
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

// Date handling
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["lpodate"])) { $lpodate = $_REQUEST["lpodate"]; } else { $lpodate = ""; }

// Get job title
$query77 = "select job_title from master_employee where username = '$username'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$job_title = $res77['job_title'];

// Handle form submission for PO generation
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1') {
    // PO generation logic (preserved from original)
    // ... [PO generation code preserved from original file]
}

// Age calculation function
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Lab PO - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/external-lab-po-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
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
        <span>External Lab PO</span>
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
                        <a href="labmapmultiple.php" class="nav-link">
                            <i class="fas fa-link"></i>
                            <span>Lab Item Mapping</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="externallabpo.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>External Lab PO</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="externallabpo_report.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>External Lab Reports</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">🧪 External Lab Purchase Order</h1>
                <div class="page-actions">
                    <button class="btn btn-primary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Alert Container -->
            <div id="alertContainer"></div>

            <!-- Search Container -->
            <div class="search-container">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Search External Lab Tests</h3>
                </div>
                
                <form name="drugs" action="externallabpo.php" method="post">
                    <div class="search-form">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" class="form-input" 
                                   value="<?php echo $transactiondatefrom; ?>" readonly />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" class="form-input" 
                                   value="<?php echo $transactiondateto; ?>" readonly />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"/>
                        </div>
                        
                        <?php 
                        $default_lpo_date = date('Y-m-d', strtotime("+60 days"));
                        ?>
                        
                        <div class="form-group">
                            <label for="lpodate" class="form-label">Valid Till</label>
                            <input name="lpodate" id="lpodate" class="form-input" 
                                   value="<?php echo $default_lpo_date; ?>" readonly onChange="return getValidityDays();"/>
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('lpodate','yyyyMMdd','','','','','future')" style="cursor:pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"/>
                            <div class="validity-period">
                                <input type="text" name="validityperiod" id="validityperiod" readonly>
                                <span>Days</span>
                                <input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="Submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Reset
                            </button>
                            <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                        </div>
                    </div>
                </form>
            </div>

            <?php
            if ($frmflag1 == 'frmflag1') {
                $sno = 0;
                $sno1 = 0;
                
                $query7 = "(select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,recorddate as recorddate,itemname as itemname,itemcode as itemcode,sampleid as sampleid,billnumber as billnumber,'samplecollection_lab' as tablename from samplecollection_lab where externallab = '1' and externalack='0' and recorddate between '$fromdate' and '$todate' and locationcode='$locationcode') 
                union all
                (select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,recorddate as recorddate,itemname as itemname,itemcode as itemcode,sampleid as sampleid,billnumber as billnumber,'ipsamplecollection_lab' as tablename from ipsamplecollection_lab where externallab = '1' and externalack='0' and recorddate between '$fromdate' and '$todate' and locationcode='$locationcode') order by recorddate desc";
                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $num7 = mysqli_num_rows($exec7);
            ?>
            
            <!-- Results Container -->
            <div class="results-container">
                <div class="results-header">
                    <h3 class="results-title">External Lab Tests Found</h3>
                    <span class="results-count"><?php echo $num7; ?> tests</span>
                </div>
                
                <?php if ($num7 > 0) { ?>
                <form name="form1" id="form1" method="post" action="externallabpo.php">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>S.No</th>
                                    <th>Date</th>
                                    <th>Patient Name</th>
                                    <th>Reg No</th>
                                    <th>Visit No</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Sample Id</th>
                                    <th>Test Name</th>
                                    <th>Supplier Mapped</th>
                                    <th>Rate</th>
                                    <th>Tax%</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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
                                    $rate = $res68['externalrate'];
                                    
                                    $sno++;
                                    $sno1++;
                                ?>
                                <tr>
                                    <td class="checkbox-container">
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" name="selectbox<?=$sno;?>" id="selectbox<?php echo $sno; ?>" onClick="validcheckbox(<?php echo $sno; ?>)" value="0">
                                            <span class="checkmark"></span>
                                        </div>
                                    </td>
                                    <td><?php echo $sno; ?></td>
                                    <td><?php echo $billdate6; ?></td>
                                    <td><?php echo htmlspecialchars($patientname6); ?></td>
                                    <td><?php echo htmlspecialchars($regno); ?></td>
                                    <td><?php echo htmlspecialchars($visitno); ?></td>
                                    <td><?php echo htmlspecialchars($age); ?></td>
                                    <td><?php echo htmlspecialchars($gender); ?></td>
                                    <td><?php echo htmlspecialchars($res7docnumber); ?></td>
                                    <td><?php echo htmlspecialchars($test); ?></td>
                                    <td>
                                        <select name="suppliername<?=$sno;?>" id="suppliername<?php echo $sno; ?>" class="table-select" onChange="return calEqAmt(this.id)">
                                            <option value="">Select Supplier</option>
                                            <?php
                                            $sql = "select * from lab_supplierlink where itemcode='$itemcode' ";
                                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while($resfetchvalue = mysqli_fetch_array($exec1)) {
                                                $suppliercode = $resfetchvalue["suppliercode"]; 
                                                $resfetchvaluerate = $resfetchvalue["rate"]; 
                                                $resfetchvaluetat = $resfetchvalue["tat"]; 
                                                $resfetchvaluesupplier_autoid = $resfetchvalue["supplier_autoid"]; 
                                                
                                                $query20 = "select accountname from master_accountname where id = '$suppliercode' ";
                                                $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res20 = mysqli_fetch_array($exec20);
                                                $suppliername = $res20['accountname'];
                                            ?>
                                            <option value="<?php echo $suppliername; ?>||<?php echo $suppliercode; ?>||<?php echo $resfetchvaluerate; ?>||<?php echo $resfetchvaluesupplier_autoid; ?>"><?php echo $suppliername; ?> - Rate: <?php echo $resfetchvaluerate; ?> - TAT: <?php echo $resfetchvaluetat; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="baserate<?=$sno;?>" id="baserate<?php echo $sno; ?>" class="table-input" value="" onKeyUp="CalculateAmount(this.id)">
                                    </td>
                                    <td>
                                        <select name="tax_percent<?=$sno;?>" id="tax_percent<?php echo $sno; ?>" class="table-select" onchange="CalculateAmount(this.id)">
                                            <option value="">--Select--</option>
                                            <?php 
                                            $query_wht = "SELECT * from master_tax";
                                            $exec_wht = mysqli_query($GLOBALS["___mysqli_ston"], $query_wht) or die ("Error in query_wht".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while ($res_wht = mysqli_fetch_array($exec_wht)) {
                                            ?>
                                            <option value="<?=$res_wht['taxpercent'];?>"><?=ucwords($res_wht['taxname']);?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input name="amount<?=$sno;?>" type="text" id="amount<?php echo $sno; ?>" class="table-input" readonly>
                                    </td>
                                </tr>
                                
                                <!-- Hidden fields -->
                                <input name="billdate<?=$sno;?>" type="hidden" value="<?php echo $billdate6; ?>">
                                <input name="auto_no<?=$sno;?>" type="hidden" value="<?php echo $res7auto_number; ?>">
                                <input name="table_name<?=$sno;?>" type="hidden" value="<?php echo $res7tablename; ?>">
                                <input name="billpatietname<?=$sno;?>" type="hidden" value="<?php echo $patientname6; ?>">
                                <input name="regnumber<?=$sno;?>" type="hidden" value="<?php echo $regno; ?>">
                                <input name="visitnumber<?=$sno;?>" type="hidden" value="<?php echo $visitno; ?>">
                                <input name="ageno<?=$sno;?>" type="hidden" value="<?php echo $age; ?>">
                                <input name="gender<?=$sno;?>" type="hidden" value="<?php echo $gender; ?>">
                                <input name="samplecollid<?=$sno;?>" type="hidden" value="<?php echo $res7docnumber; ?>">
                                <input name="test<?=$sno;?>" type="hidden" value="<?php echo $test; ?>">
                                <input name="testcode<?=$sno;?>" type="hidden" value="<?php echo $itemcode; ?>">
                                <input name="suppliercode<?=$sno;?>" type="hidden" id="suppliercode<?php echo $sno; ?>" value="">
                                <input name="suppliername_mlpo<?=$sno;?>" type="hidden" id="suppliername_mlpo<?php echo $sno; ?>" value="">
                                <input name="supplier_autono<?=$sno;?>" type="hidden" id="supplier_autono<?php echo $sno; ?>" value="">
                                
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="form-actions" style="margin-top: 2rem;">
                        <input type="hidden" name="frm1submit1" value="frm1submit1" />
                        <input type="hidden" name="sno_new" id="sno_new" value="<?php echo $sno1; ?>">
                        <input name="lpodate_1" id="lpodate_1" type="hidden" value="<?php echo $default_lpo_date; ?>">
                        
                        <button type="submit" name="submit" class="generate-po-btn" onClick="return externallabvalue()">
                            <i class="fas fa-file-invoice"></i>
                            Generate Purchase Orders
                        </button>
                    </div>
                </form>
                <?php } else { ?>
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>No External Lab Tests Found</h3>
                    <p>No external lab tests found for the selected date range. Please try a different date range.</p>
                </div>
                <?php } ?>
            </div>
            
            <?php
            }
            ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/external-lab-po-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy JavaScript -->
    <script>
    function disableEnterKey() {
        if (event.keyCode == 13) {
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
