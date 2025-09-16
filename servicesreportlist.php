<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Date variables
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];

$locationcode = $res["locationcode"];



if (isset($_REQUEST["ADate1"])) { $paymentreceiveddatefrom = $_REQUEST["ADate1"]; } else { $paymentreceiveddatefrom = date('Y-m-d'); }

 

if (isset($_REQUEST["ADate2"])) { $paymentreceiveddateto = $_REQUEST["ADate2"]; } else { $paymentreceiveddateto = date('Y-m-d'); }





$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '0.00';

$looptotalpaidamount = '0.00';

$looptotalpendingamount = '0.00';

$looptotalwriteoffamount = '0.00';

$looptotalcashamount = '0.00';

$looptotalcreditamount = '0.00';

$looptotalcardamount = '0.00';

$looptotalonlineamount = '0.00';

$looptotalchequeamount = '0.00';

$looptotaltdsamount = '0.00';

$looptotalwriteoffamount = '0.00';

$pendingamount = '0.00';

$accountname = '';

$amount = '';

$processcount = 0;

$ipprocessstatus='';

$processstatus='';



 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';



if (isset($_REQUEST["patientname"])) { $searchpatientname = $_REQUEST["patientname"]; } else { $searchpatientname = ""; }

if (isset($_REQUEST["serdoct"])) {  $doctorname = $_REQUEST["serdoct"]; } else { $doctorname = ""; }

if (isset($_REQUEST["serdoctcode"])) { $doctorcode = $_REQUEST["serdoctcode"]; } else { $doctorcode = ""; }



if (isset($_REQUEST["visitcode"])) { $searchvisitcode = $_REQUEST["visitcode"]; } else { $searchvisitcode = ""; }

if (isset($_REQUEST["patienttype"])) { $patienttype = $_REQUEST["patienttype"]; } else { $patienttype = ""; }

if (isset($_REQUEST["servicescode"])) { $servicescode = $_REQUEST["servicescode"]; } else { $servicescode = ""; }

if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }

//echo $department;

if (isset($_REQUEST["servicesitem"])) { $servicesitem = $_REQUEST["servicesitem"]; } else { $servicesitem = ""; }



if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }





if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype']; 

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];





if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Report List - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Additional CSS -->
    <link href="js/jquery-ui.css" rel="stylesheet">
    
    <!-- JavaScript Files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    
    <style>
        .ui-menu .ui-menu-item { zoom: 1 !important; }
        .bal { border-style: none; background: none; text-align: right; }
        .bali { text-align: right; }
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
        <span>Services Report List</span>
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
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="servicesreportlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Services Report List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="masterdata.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Master Data</span>
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
                    <h2>Services Report List</h2>
                    <p>Generate comprehensive reports on services provided with detailed tracking and analysis.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <form name="cbform1" method="post" action="servicesreportlist.php" class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-search form-section-icon"></i>
                    <h3 class="form-section-title">Search Criteria</h3>
                    <span class="form-section-subtitle">Enter search parameters to generate the services report</span>
                </div>
                
                <div class="form-section-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="serdoct" class="form-label">Doctor</label>
                            <input name="serdoct" type="text" id="serdoct" class="form-input" value="<?php echo $doctorname; ?>" placeholder="Search for doctor" />
                            <input name="serdoctcode" type="hidden" id="serdoctcode" value="<?php echo $doctorcode; ?>" />
                        </div>
                        
                        <div class="form-group">
                            <label for="servicesitem" class="form-label">Service Item</label>
                            <input name="servicesitem" id="servicesitem" class="form-input" value="<?php echo $servicesitem; ?>" placeholder="Search for service item" autocomplete="off" />
                            <input type="hidden" name="servicescode" id="servicescode" value="<?php echo $servicescode; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Select Employee</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" class="form-input" value="<?php echo $searchsuppliername; ?>" placeholder="Search for employee" autocomplete="off" />
                            <input name="searchdescription" id="searchdescription" type="hidden" value="" />
                            <input name="searchemployeecode" id="searchemployeecode" type="hidden" value="<?php echo $searchemployeecode; ?>" />
                            <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="" />
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <option value="All">All</option>
                                <?php
                                $query1 = "select locationname,locationcode from master_location where status <> 'deleted' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="form-input-group">
                                <input name="ADate1" id="ADate1" class="form-input" value="<?php echo $paymentreceiveddatefrom; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="form-input-group">
                                <input name="ADate2" id="ADate2" class="form-input" value="<?php echo $paymentreceiveddateto; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            </form>

            <!-- Results Section -->
            <?php if(isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1'){ ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <h3 class="data-table-title">Services Report Results</h3>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">S.No</th>
                                <th class="table-header-cell">Service Code</th>
                                <th class="table-header-cell">Service Name</th>
                                <th class="table-header-cell">Service Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table content will be generated by PHP -->
                            <tr class="table-row-even">
                                <td class="table-cell text-center" colspan="4">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        Report results will be displayed here after search
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

        // AJAX location function
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

        // Initialize autocomplete functionality
        $(function() {
            $('#serdoct').autocomplete({
                source:"ajaxdoc.php",
                select:function(event,ui){
                    $('#serdoct').val(ui.item.value);
                    $('#serdoctcode').val(ui.item.id);
                    document.getElementById("searchsuppliername").disabled = true;
                }
            });

            $('#servicesitem').autocomplete({
                source:"ajaxautocomplete_services_pkg.php?subtype=<?php echo '1';?>&&loc=<?php echo $locationcode; ?>",
                minLength:3,
                delay: 0,
                html: true, 
                select:function(event,ui){
                    $('#servicesitem').val(ui.item.value);
                    $('#servicescode').val(ui.item.code);
                }
            });

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
                    document.getElementById("serdoct").disabled = true;
                },
            });
        });

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

</body>
</html>

<style type="text/css">

<!--

body {

	margin-left: 0px;
