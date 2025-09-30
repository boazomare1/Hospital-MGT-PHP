<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

if(isset($_REQUEST['ADate1']))
   $transactiondatefrom = $_REQUEST['ADate1'];
else
  $transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

if(isset($_REQUEST['ADate2']))
   $transactiondateto = $_REQUEST['ADate2'];
else
   $transactiondateto = date('Y-m-d');

$packagename1 = "";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$total_hours = '00';
$total_minutes = '00';

$docno = $_SESSION['docno'];

//get location for sort by location purpose
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if($location != '') {
    $locationcode = $location;
}

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

if ($frmflag2 == 'frmflag2') {
    //get locationcode and locationname for inserting
    $locationcodeget = isset($_REQUEST['locationcodeget']) ? $_REQUEST['locationcodeget'] : '';
    $locationnameget = isset($_REQUEST['locationnameget']) ? $_REQUEST['locationnameget'] : '';
    
    $itemname = $_REQUEST['itemname'];
    $itemcode = $_REQUEST['itemcode'];
    $adjustmentdate = date('Y-m-d');
    
    foreach($_POST['batch'] as $key => $value) {
        $batchnumber = $_POST['batch'][$key];
        $addstock = $_POST['addstock'][$key];
        $minusstock = $_POST['minusstock'][$key];
        $query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
        $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res40 = mysqli_fetch_array($exec40);
        $itemmrp = $res40['rateperunit'];
        
        $itemsubtotal = $itemmrp * $addstock;
        
        if($addstock != '') {
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
            transactionparticular, billautonumber, billnumber, quantity, remarks, 
            username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber)
            values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
            'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
            '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        } else {
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
            transactionparticular, billautonumber, billnumber, quantity, remarks, 
            username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber)
            values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
            'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
            '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    header("location:stockadjustment.php");
    exit;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
}

if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inpatient Discharge TAT - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/ipdischargelist_tat-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
        <span>Inpatient Discharge TAT</span>
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
                        <a href="ipdischargelist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargerequestlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Discharge Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargelist_tat.php" class="nav-link active">
                            <i class="fas fa-clock"></i>
                            <span>Discharge TAT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>% Discount List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Discount Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdocs.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>IP Documents</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div class="alert-container">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <h2><i class="fas fa-clock"></i> Inpatient Discharge TAT</h2>
                    <p>Track Turnaround Time for Patient Discharges</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="ipdischargelist_tat.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" onChange="funcSubTypeChange1(); ajaxlocationfunction(this.value);" class="form-control">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ADate1">Date From</label>
                            <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" class="form-control date-input" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" class="date-picker-icon"/>
                        </div>
                        <div class="form-group">
                            <label for="ADate2">Date To</label>
                            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" class="form-control date-input" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" class="date-picker-icon"/>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-container">
                <?php
                $colorloopcount = 0;
                $sno = 0;
                if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                
                if ($cbfrmflag1 == 'cbfrmflag1') {
                    $locationcode = $_REQUEST['location'];
                    ?>
                    <div class="table-header">
                        <h3>Discharge TAT Report</h3>
                        <div class="table-actions">
                            <a href="ipdischargelist_tatxl.php?cbfrmflag1=cbfrmflag1&location=<?php echo $location; ?>&ADate1=<?php echo $transactiondatefrom;?>&ADate2=<?php echo $transactiondateto; ?>" target="_blank" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Export to Excel
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Patient Name</th>
                                    <th>Reg No</th>
                                    <th>IP Visit</th>
                                    <th>DOD</th>
                                    <th>DOF</th>
                                    <th>TAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                $query110 = "select * from ip_discharge where req_status = 'discharge' and locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' and ward!='29' order by recorddate desc,recordtime desc";
                                $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while($res50 = mysqli_fetch_array($exec50)) {
                                    $showcolor = ($sno & 1); 
                                    if ($showcolor == 0) {
                                        $colorcode = 'class="even-row"';
                                    } else {
                                        $colorcode = 'class="odd-row"';
                                    }

                                    $query221 = "select transactiondate,transactiontime from master_transactionpaylater where visitcode='".$res50['visitcode']."' and patientcode = '".$res50['patientcode']."' and transactiontype='finalize'";
                                    $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res221 = mysqli_fetch_array($exec221);
                                    $billdate = $res221['transactiondate'];
                                    $billtime = $res221['transactiontime'];

                                    if($billdate!='') {
                                        $diff = intval((strtotime($billdate.' '.$billtime) - strtotime($res50['recorddate'].' '.$res50['recordtime']))/60);
                                        $hoursstay = intval($diff/60);
                                        $minutesstay = $diff%60;
                                        $los = $hoursstay.':'.$minutesstay;
                                        
                                        if($hoursstay>='24') {
                                            list($hours, $minutes) = explode(':', $los);
                                            $total_seconds = ($hours * 3600) + ($minutes * 60);
                                            $days = floor($total_seconds / (60 * 60 * 24));
                                            $hours = floor(($total_seconds - ($days * 60 * 60 * 24)) / 3600);
                                            $minutes = floor(($total_seconds - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);
                                            $los = $days." Days ".$hours.":".$minutes;
                                        }
                                        
                                        $total_hours = $total_hours + $hoursstay;
                                        $total_minutes = $total_minutes + $minutesstay;
                                    } else {
                                        $los = '';
                                    }
                                    ?>
                                    <tr <?php echo $colorcode; ?>>
                                        <td><?php echo $sno;?></td>
                                        <td><?php echo $res50['patientname'];?></td>
                                        <td><?php echo $res50['patientcode'];?></td>
                                        <td><?php echo $res50['visitcode'];?></td>
                                        <td><?php echo $res50['recorddate'].' '.$res50['recordtime'];?></td>
                                        <td><?php echo $billdate.' '.$billtime;?></td>
                                        <td><?php echo $los;?></td>
                                    </tr>
                                    <?php
                                    $sno++;
                                }
                                
                                // Calculate total time
                                $total_minutes = ($total_hours * 60) + $total_minutes;
                                $minutes = $total_minutes % 60;
                                if ($minutes < 0) {
                                    $minutes += 60;
                                    $total_hours--;
                                }
                                $hours = floor($total_minutes / 60);
                                $total_time = sprintf("%d:%02d", $hours, $minutes);
                                
                                if($hours>='24') {
                                    list($hours, $minutes) = explode(':', $total_time);
                                    $total_seconds = ($hours * 3600) + ($minutes * 60);
                                    $days = floor($total_seconds / (60 * 60 * 24));
                                    $hours = floor(($total_seconds - ($days * 60 * 60 * 24)) / 3600);
                                    $minutes = floor(($total_seconds - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);
                                    $total_time = $days." Days ".$hours.":".$minutes;
                                }
                                ?>
                                <tr class="total-row">
                                    <td colspan="6"><strong>Total</strong></td>
                                    <td><strong><?php echo $total_time;?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </main>
    </div>

    <script src="js/ipdischargelist_tat-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

<script language="javascript">
function ajaxlocationfunction(val) { 
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
    xmlhttp.send();
}

function cbsuppliername1() {
    document.cbform1.submit();
}

function funcSubTypeChange1() {
    <?php 
    $query12 = "select * from master_location";
    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
    while ($res12 = mysqli_fetch_array($exec12)) {
        $res12subtypeanum = $res12["auto_number"];
        $res12locationname = $res12["locationname"];
        $res12locationcode = $res12["locationcode"];
        ?>
        if(document.getElementById("location").value == "<?php echo $res12locationcode; ?>") {
            document.getElementById("ward").options.length = null; 
            var combo = document.getElementById('ward'); 	
            <?php 
            $loopcount = 0; 
            ?>
            combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 
            <?php
            $query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";
            $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($res10 = mysqli_fetch_array($exec10)) {
                $loopcount = $loopcount + 1;
                $res10accountnameanum = $res10["auto_number"];
                $ward = $res10["ward"];
                ?>
                combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 
                <?php 
            }
            ?>
        }
        <?php
    }
    ?>	
}

function disableEnterKey(varPassed) {
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

function process1backkeypress1() {
    if (event.keyCode == 8) {
        event.keyCode = 0; 
        return event.keyCode 
        return false;
    }
}

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

function funcPrintReceipt1() {
    window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}
</script>