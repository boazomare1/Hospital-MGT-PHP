<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Date variables
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$billnumbers=array();

$billnumbers1=array();

$billnumbers11=array();

$billnumbers2=array();

$billnumbers3=array();

$billnumbers4=array();

$billnumbers5=array();



$totalvisitcodes='';

$totalbillnumbers='';

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalat = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$arraysuppliername = '';

$arraysuppliercode = '';	

$totalatret = 0.00;



$totalamount30 = 0;

$totalamount60 = 0;

$totalamount90 = 0;

$totalamount120 = 0;

$totalamount180 = 0;

$totalamountgreater = 0;

		  

$docno = $_SESSION['docno'];



$query01="select locationcode from login_locationdetails where username='$username' and docno='$docno'";

$exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

$res01=mysqli_fetch_array($exe01);

 $locationcode=$res01['locationcode'];



include ("autocompletebuild_doctor1.php");





if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) {  $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }





$searchsuppliername1=explode('#',$searchsuppliername);

$searchsuppliername=trim($searchsuppliername1[0]);

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }

$paymentreceiveddatefrom=$ADate1;



//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }

$paymentreceiveddateto=$ADate2;

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Statement - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Additional CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript Files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/autocomplete_doctor.js"></script>
    <script type="text/javascript" src="js/autosuggestdoctor_stmt.js"></script>
    
    <style>
        .ui-menu .ui-menu-item { zoom: 1 !important; }
        .bal { border-style: none; background: none; text-align: right; }
        .bali { text-align: right; }
        th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
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
        <span>Doctor Statement</span>
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
                        <a href="doctorstatement.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Statement</span>
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
                    <h2>Doctor Statement</h2>
                    <p>Generate comprehensive doctor statements with detailed transaction tracking and aging analysis.</p>
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
            <form name="cbform1" method="post" action="doctorstatement.php" class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-search form-section-icon"></i>
                    <h3 class="form-section-title">Search Criteria</h3>
                    <span class="form-section-subtitle">Enter search parameters to generate the doctor statement</span>
                </div>
                
                <div class="form-section-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Search Doctor</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" class="form-input" value="<?php echo $searchsuppliername; ?>" placeholder="Search for doctor" autocomplete="off" />
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" />
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
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate2','yyyyMMdd','','','','','past','07-01-2019','<?php echo date('m-d-Y');?>')" style="cursor:pointer"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
                        <button type="submit" onClick="return funcAccount();" name="Submit" class="btn btn-primary">
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
                    <h3 class="data-table-title">Doctor Statement Results</h3>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">No.</th>
                                <th class="table-header-cell">Date</th>
                                <th class="table-header-cell">Description</th>
                                <th class="table-header-cell">Bill No</th>
                                <th class="table-header-cell">Bill Type</th>
                                <th class="table-header-cell text-right">Bill Amt</th>
                                <th class="table-header-cell text-right">Sharing %</th>
                                <th class="table-header-cell text-right">Debit</th>
                                <th class="table-header-cell text-right">Tax Amt</th>
                                <th class="table-header-cell text-right">Credit</th>
                                <th class="table-header-cell text-center">Days</th>
                                <th class="table-header-cell text-right">Current Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table content will be generated by PHP -->
                            <tr class="table-row-even">
                                <td class="table-cell text-center" colspan="12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        Statement results will be displayed here after search
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

        // Form validation function
        function funcAccount() {
            if((document.getElementById("searchsuppliername").value == "") || (document.getElementById("searchsuppliername").value == " ")) {
                alert('Please Select Doctor.');
                return false;
            }
        }

        // Print bill report function
        function loadprintpagepdf2(billnumber, doctorcode) {
            window.open("print_doctorstmtbill.php?billnumber="+billnumber+'&&doctorcode='+doctorcode,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
        }

        // COA search functions
        function coasearch(varCallFrom) {
            var varCallFrom = varCallFrom;
            window.open("showinvoice.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
        }

        function coasearch1(varCallFrom1) {
            var varCallFrom1 = varCallFrom1;
            window.open("showwthinvoice.php?callfrom1="+varCallFrom1,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
        }

        // Form validation
        function validateForm(){
            var to_date = document.getElementById('ADate2').value;
            var now = new Date().toISOString().slice(0,10);
            
            if(to_date > now){
                alert("Date to cannot be a future date!");
                document.getElementById('ADate2').focus;
                return false;
            }
            return true;
        }

        // Initialize autocomplete for doctor search
        window.onload = function () {
            var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
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

</body>
</html>
<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }


<!--

body {

	margin-left: 0px;
