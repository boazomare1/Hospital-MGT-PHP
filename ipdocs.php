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
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

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

include ("autocompletebuild_customeripbilling.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Documents - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/ipdocs-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <?php include ("js/dropdownlistipbilling.php"); ?>
    <script type="text/javascript" src="js/autosuggestipbilling.js"></script>
    <script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <script src="js/datetimepicker_css.js"></script>
</head>
<body onLoad="return funcOnLoadBodyFunctionCall()">
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
        <span>IP Documents</span>
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
                        <a href="ipdischargelist_tat.php" class="nav-link">
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
                        <a href="ipdocs.php" class="nav-link active">
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
                    <h2><i class="fas fa-file-alt"></i> IP Documents</h2>
                    <p>Generate and manage inpatient documents and forms</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="ipdocs.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-control">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="customer">Patient Search</label>
                            <div class="search-input-wrapper">
                                <input name="customer" id="customer" size="60" autocomplete="off" class="form-control" placeholder="Search by patient name, code, or visit code">
                                <input name="customercode" id="customercode" value="" type="hidden">
                                <input type="hidden" name="recordstatus" id="recordstatus">
                                <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly>
                            </div>
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
                    $searchpatient = $_POST['customer'];
                    $searchlocation = $_POST['location'];
                    ?>
                    <div class="table-header">
                        <h3>Patient Documents</h3>
                        <div class="table-actions">
                            <span class="result-count">Showing results for: <?php echo $searchpatient ? $searchpatient : 'All patients'; ?></span>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Type</th>
                                    <th>Patient Name</th>
                                    <th>Reg No</th>
                                    <th>IP Date</th>
                                    <th>IP Visit</th>
                                    <th>Account</th>
                                    <th>Status</th>
                                    <th>Documents</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($searchpatient != '') { 
                                    $query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and patientname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%'";
                                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res34 = mysqli_fetch_array($exec34)) {
                                        $patientname = $res34['patientname'];
                                        $patientcode = $res34['patientcode'];
                                        $visitcode = $res34['visitcode'];
                                        $paymentstatus = $res34['paymentstatus'];
                                        $creditapprovalstatus = $res34['creditapprovalstatus'];
                                        
                                        $query71 = "select * from ip_discharge where locationcode='$searchlocation' and visitcode='$visitcode'";
                                        $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $num71 = mysqli_num_rows($exec71);
                                        if($num71 == 0) {
                                            $status = 'Active';
                                        } else {
                                            $res711 = mysqli_fetch_array($exec71);
                                            if($res711['req_status']=='request')
                                                $status = 'Active';
                                            else
                                                $status = 'Discharged';
                                        }
                                        
                                        $query82 = "select * from master_ipvisitentry where locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
                                        $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res82 = mysqli_fetch_array($exec82);
                                        $date = $res82['consultationdate'];
                                        $accountname = $res82['accountfullname'];
                                        $patientlocationcode = $res82['locationcode'];
                                        $type = $res82['type'];
                                        if($type=='hospital') {
                                            $type='H';   
                                        }
                                        if($type=='private') {
                                            $type='P';   
                                        }
                                        
                                        if($paymentstatus == '') {
                                            if($creditapprovalstatus == '') {
                                                $colorloopcount = $colorloopcount + 1;
                                                $showcolor = ($colorloopcount & 1); 
                                                if ($showcolor == 0) {
                                                    $colorcode = 'class="even-row"';
                                                } else {
                                                    $colorcode = 'class="odd-row"';
                                                }
                                                ?>
                                                <tr <?php echo $colorcode; ?>>
                                                    <td><?php echo $sno = $sno + 1; ?></td>
                                                    <td><span class="type-badge type-<?php echo strtolower($type); ?>"><?php echo $type; ?></span></td>
                                                    <td><?php echo $patientname; ?></td>
                                                    <td><?php echo $patientcode; ?></td>
                                                    <td><?php echo $date; ?></td>
                                                    <td><?php echo $visitcode; ?></td>
                                                    <td><?php echo $accountname; ?></td>
                                                    <td><span class="status-badge status-<?php echo strtolower($status); ?>"><?php echo $status; ?></span></td>
                                                    <td>
                                                        <div class="document-actions">
                                                            <select name="documents" id="documents" onChange="handleDocumentAction(this)" class="document-select">
                                                                <option value="">Select Document</option>
                                                                <option value="admissionform_pdf.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Admission Form</option>
                                                                <option value="consent.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Consent Form</option>
                                                                <option value="payment_form_pdf.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Payment Guarantee</option>
                                                                <option value="print_iplabel.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">IP Label</option>
                                                                <option value="print_dischargesummary.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Discharge Summary</option>
                                                                <option value="ama_form.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">AMA Form</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                } else {
                                    $query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and paymentstatus = '' and creditapprovalstatus = ''";
                                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res34 = mysqli_fetch_array($exec34)) {
                                        $patientname = $res34['patientname'];
                                        $patientcode = $res34['patientcode'];
                                        $visitcode = $res34['visitcode'];
                                        
                                        $query71 = "select * from ip_discharge where  locationcode='$searchlocation' and visitcode='$visitcode'";
                                        $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $num71 = mysqli_num_rows($exec71);
                                        if($num71 == 0) {
                                            $status = 'Active';
                                        } else {
                                            $res711 = mysqli_fetch_array($exec71);
                                            if($res711['req_status']=='request')
                                                $status = 'Active';
                                            else
                                                $status = 'Discharged';
                                        }
                                        
                                        $query82 = "select * from master_ipvisitentry where  locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
                                        $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res82 = mysqli_fetch_array($exec82);
                                        $date = $res82['consultationdate'];
                                        $accountname = $res82['accountfullname'];
                                        $type = $res82['type'];
                                        if($type=='hospital') {
                                            $type='H';   
                                        }
                                        if($type=='private') {
                                            $type='P';   
                                        }

                                        $colorloopcount = $colorloopcount + 1;
                                        $showcolor = ($colorloopcount & 1); 
                                        if ($showcolor == 0) {
                                            $colorcode = 'class="even-row"';
                                        } else {
                                            $colorcode = 'class="odd-row"';
                                        }
                                        ?>
                                        <tr <?php echo $colorcode; ?>>
                                            <td><?php echo $sno = $sno + 1; ?></td>
                                            <td><span class="type-badge type-<?php echo strtolower($type); ?>"><?php echo $type; ?></span></td>
                                            <td><?php echo $patientname; ?></td>
                                            <td><?php echo $patientcode; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $visitcode; ?></td>
                                            <td><?php echo $accountname; ?></td>
                                            <td><span class="status-badge status-<?php echo strtolower($status); ?>"><?php echo $status; ?></span></td>
                                            <td>
                                                <div class="document-actions">
                                                    <select name="documents" id="documents" onChange="handleDocumentAction(this)" class="document-select">
                                                        <option value="">Select Document</option>
                                                        <option value="admissionform_pdf.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Admission Form</option>
                                                        <option value="consent.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Consent Form</option>
                                                        <option value="payment_form_pdf.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Payment Guarantee</option>
                                                        <option value="print_iplabel.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">IP Label</option>
                                                        <option value="print_dischargesummary.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Discharge Summary</option>
                                                        <option value="ama_form.php?locationcode=<?=$locationcode;?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">AMA Form</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </main>
    </div>

    <script src="js/ipdocs-modern.js?v=<?php echo time(); ?>"></script>
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

function funcOnLoadBodyFunctionCall() { 
    funcCustomerDropDownSearch1();
    funcPopupOnLoad1();
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

function funcPopupOnLoad1() {
    <?php  
    if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
    if (isset($_REQUEST["savedvisitcode"])) { $savedvisitcode = $_REQUEST["savedvisitcode"]; } else { $savedvisitcode = ""; }
    if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbera = ""; }
    ?>
    var patientcodes = "<?php echo $_REQUEST['savedpatientcode']; ?>";
    var visitcodes = "<?php echo $_REQUEST['savedvisitcode']; ?>";
    var billnumbers = "<?php echo $_REQUEST['billnumber']; ?>";
    
    if(patientcodes != "") {
        window.open("print_ipfinalinvoice1.php?patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers,"OriginalWindowA4",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
    }
}

function handleDocumentAction(selectElement) {
    if (selectElement.value) {
        // Add loading state
        selectElement.disabled = true;
        selectElement.style.opacity = '0.6';
        
        // Open document in new window
        window.open(selectElement.value, '_blank');
        
        // Reset after a short delay
        setTimeout(() => {
            selectElement.disabled = false;
            selectElement.style.opacity = '1';
            selectElement.selectedIndex = 0; // Reset to default option
        }, 1000);
    }
}
</script>

<script>	
<?php 
if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }
if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }
?>
var ipbillnumberr;
var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";
var ippatientcoder;
var ippatientcoder = "<?php echo $ippatientcodes; ?>";
if(ipbillnumberr != "") {
    window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}				
</script>