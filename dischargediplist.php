<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Initialize form variables
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

// Handle form parameters with modern isset() checks
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$getcanum = isset($_REQUEST["canum"]) ? $_REQUEST["canum"] : "";
$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";

// Handle supplier selection
if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

// Handle form submission for stock adjustment
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
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, transactionparticular, billautonumber, billnumber, quantity, remarks, username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber) values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        } else {
            $query65 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, transactionparticular, billautonumber, billnumber, quantity, remarks, username, ipaddress, rateperunit, totalrate, companyanum, companyname, batchnumber) values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname', '$batchnumber')";
            $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    header("location:stockadjustment.php");
    exit;
}

// Handle status messages
$st = isset($_REQUEST["st"]) ? $_REQUEST["st"] : "";
if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
}

include ("autocompletebuild_ipcustomerdischarge.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discharge List - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Additional CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
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
        <span>Patient Management</span>
        <span>→</span>
        <span>Discharge List</span>
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
                        <a href="dischargediplist.php" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dischargeregister.php" class="nav-link">
                            <i class="fas fa-list-alt"></i>
                            <span>Discharge Register</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing</span>
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
                    <h2>Discharge List</h2>
                    <p>Search and manage discharged patients with comprehensive discharge information and actions.</p>
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
            <form name="cbform1" method="post" action="dischargediplist.php" class="search-form" onSubmit="return validchecking()">
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fas fa-search form-section-icon"></i>
                        <h3 class="form-section-title">Search Discharged Patients</h3>
                    </div>
                    
                    <div class="form-section-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                    <?php       
                                    $query79 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname ";
                                    $exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res79 = mysqli_fetch_array($exec79)) {
                                        $locationname = $res79["locationname"];
                                        $locationcode = $res79["locationcode"];
                                    ?>						  
                                        <option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="customer" class="form-label">Patient Search</label>
                                <input name="customer" id="customer" class="form-input" size="73" autocomplete="off" placeholder="Search by patient name, code, or visit code">
                                <input name="customercode" id="customercode" value="" type="hidden">
                                <input type="hidden" name="recordstatus" id="recordstatus">
                                <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                                <button type="submit" class="btn btn-primary" name="Submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Results Table -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1') { ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">Discharged Patients</h3>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr class="table-header">
                            <th class="table-header-cell">No.</th>
                            <th class="table-header-cell">Patient Name</th>
                            <th class="table-header-cell">Reg No</th>
                            <th class="table-header-cell">DOD</th>
                            <th class="table-header-cell">IP Visit</th>
                            <th class="table-header-cell">Last Ward</th>
                            <th class="table-header-cell">Last Bed No</th>
                            <th class="table-header-cell">Disch By</th>
                            <th class="table-header-cell">Account</th>
                            <th class="table-header-cell">Order</th>
                            <th class="table-header-cell">Action</th>
                            <th class="table-header-cell">Discharge</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $colorloopcount = 0;
                        $sno = 0;
                        $searchpatient = $_POST['customer'];
                        $locationcode = $_POST['location'];
                        
                        if($searchpatient != '') {
                            $query34 = "select * from ip_discharge where locationcode='$locationcode' and (patientname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%') and req_status<>'request'";
                            $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while($res34 = mysqli_fetch_array($exec34)) {
                                $patientname = $res34['patientname'];
                                $patientcode = $res34['patientcode'];
                                $visitcode = $res34['visitcode'];
                                $accountname = $res34['accountname'];
                                $date = $res34['recorddate'];
                                $ward = $res34['ward'];
                                $bed = $res34['bed'];
                                $paymentstatus = $res34['paymentstatus'];
                                $creditapprovalstatus = $res34['creditapprovalstatus'];
                                $dischargedby = $res34['username'];
                                
                                $query51 = "select * from master_bed where auto_number='$bed'";
                                $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res51 = mysqli_fetch_array($exec51);
                                $bedname = $res51['bed'];
                                
                                $query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
                                $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res7811 = mysqli_fetch_array($exec7811);
                                $wardname = $res7811['ward'];
                                
                                if($paymentstatus == '' && $creditapprovalstatus == '') {
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    
                                    if ($showcolor == 0) {
                                        $colorcode = 'class="table-row-even"';
                                    } else {
                                        $colorcode = 'class="table-row-odd"';
                                    }
                        ?>
                                    <tr <?php echo $colorcode; ?>>
                                        <td class="table-cell text-center"><?php echo $sno = $sno + 1; ?></td>
                                        <td class="table-cell"><?php echo $patientname; ?></td>
                                        <td class="table-cell"><?php echo $patientcode; ?></td>
                                        <td class="table-cell"><?php echo $date; ?></td>
                                        <td class="table-cell"><?php echo $visitcode; ?></td>
                                        <td class="table-cell"><?php echo $wardname; ?></td>
                                        <td class="table-cell"><?php echo $bedname; ?></td>
                                        <td class="table-cell"><?php echo $dischargedby; ?></td>
                                        <td class="table-cell"><?php echo $accountname; ?></td>
                                        <td class="table-cell">
                                            <select name="order" id="order" class="form-input" onChange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                                <option>Select Order</option>
                                                <option value="ipmedicineissue.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Medicine Request</option>
                                                <option value="medicinereturnrequest.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode;?>">Medicine Return</option>
                                                <option value="iptests.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Tests and Procedures</option>
                                                <option value="ipprivatedoctor.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Private Doctor</option>
                                            </select>
                                        </td>
                                        <td class="table-cell">
                                            <a href="dischargesummary.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" class="btn btn-outline btn-sm">
                                                <i class="fas fa-file-alt"></i> Summary
                                            </a>
                                        </td>
                                        <td class="table-cell">
                                            <a href="revokedischarge.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&locationcode=<?php echo $locationcode;?>" class="btn btn-outline btn-sm">
                                                <i class="fas fa-undo"></i> Revoke
                                            </a>
                                        </td>
                                    </tr>
                        <?php 
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
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
            // Add export functionality here
            alert('Export functionality will be implemented');
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
    <?php include ("js/dropdownlistipbilling.php"); ?>
    <script type="text/javascript" src="js/autosuggestipdischargelist.js"></script>
    <script type="text/javascript" src="js/autocomplete_customeripdischarge.js"></script>

    <!-- JavaScript for functionality -->
    <script type="text/javascript">
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
            xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
            xmlhttp.send();
        }

        function cbsuppliername1() {
            document.cbform1.submit();
        }

        function funcOnLoadBodyFunctionCall() { 
            funcCustomerDropDownSearch1();
            funcCreatePopup();
        }

        function disableEnterKey(varPassed) {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode;
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
                return event.keyCode;
                return false;
            }
        }

        function disableEnterKey() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode;
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

        function funcCreatePopup() {
            <?php
            $savedpatientcode = isset($_REQUEST["patientcode"]) ? $_REQUEST["patientcode"] : "";
            $savedvisitcode = isset($_REQUEST["visitcode"]) ? $_REQUEST["visitcode"] : "";
            ?>
            var savedpatientcodes = "<?php echo $savedpatientcode; ?>";
            var savedvisitcodes = "<?php echo $savedvisitcode; ?>";
            
            if(savedpatientcodes != "" && savedvisitcodes != "") {
                window.open("print_dischargesummary.php?patientcode=" + savedpatientcodes + "&&visitcode=" + savedvisitcodes, "OriginalWindowA25", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25'); 
            }	
        }

        function validchecking() {
            var customer = document.getElementById("customer").value;
            if(customer == '') {
                alert("Please Select a Patient");
                document.getElementById("customer").focus();
                return false;
            }
        }

        // Initialize on page load
        window.onload = function() {
            funcOnLoadBodyFunctionCall();
        };
    </script>

</body>
</html>