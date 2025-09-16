<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");



$grandtotal = '0.00';

$searchcustomername = '';

$patientfirstname = '';

$visitcode = '';

$customername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$customername = '';

$paymenttype = '';

$billstatus = '';

$res2loopcount = '';

$custid = '';

$visitcode1='';

$res2username ='';

$custname = '';

$colorloopcount = '';

$sno = '';

$customercode = '';

$totalsalesamount = '0.00';

$totalsalesreturnamount = '0.00';

$netcollectionamount = '0.00';

$netpaymentamount = '0.00';

$res2total = '0.00';

$cashamount = '0.00';

$cardamount = '0.00';

$chequeamount = '0.00';

$onlineamount = '0.00';

$total = '0.00';

$cashtotal = '0.00';

$cardtotal = '0.00';

$chequetotal = '0.00';

$onlinetotal = '0.00';

$res2cashamount1 ='';

$res2cardamount1 = '';

$res2chequeamount1 = '';

$res2onlineamount1 ='';

$cashamount2 = '0.00';

$cardamount2 = '0.00';

$chequeamount2 = '0.00';

$onlineamount2 = '0.00';

$total1 = '0.00';

$billnumber = '';

$netcashamount = '0.00';

$netcardamount = '0.00';

$netchequeamount = '0.00';

$netonlineamount = '0.00';

$netcreditamount = 0.00;

$nettotal = '0.00';



$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');  



include ("autocompletebuild_users.php");

// Handle form parameters with modern isset() checks
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$getcanum = isset($_REQUEST["canum"]) ? $_REQUEST["canum"] : "";
$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$searchbillnumber = isset($_REQUEST["searchbillnumber"]) ? $_REQUEST["searchbillnumber"] : "";


if ($getcanum != '')

{

	$query4 = "select * from master_customer where locationcode='$locationcode1' and auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbcustomername = $res4['customername'];

	$customername = $res4['customername'];

}



$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";

if ($cbfrmflag1 == 'cbfrmflag1') {
	$cbcustomername = $_REQUEST['cbcustomername'];
	$cbbillnumber = isset($_REQUEST["cbbillnumber"]) ? $_REQUEST["cbbillnumber"] : "";
	$searchbillnumber = isset($_REQUEST["searchbillnumber"]) ? $_REQUEST["searchbillnumber"] : "";
	$cbbillstatus = isset($_REQUEST["cbbillstatus"]) ? $_REQUEST["cbbillstatus"] : "";
	$paymenttype = isset($_REQUEST["paymenttype"]) ? $_REQUEST["paymenttype"] : "";
	$billstatus = isset($_REQUEST["billstatus"]) ? $_REQUEST["billstatus"] : "";
}

$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";

if ($cbfrmflag2 == 'cbfrmflag2') {
	if(isset($_POST['billnumber']) && $_POST['billnumber']!='' && isset($_POST['visitcode'])){
		$drsql="SELECT doctorcode,doctorname FROM `master_doctor` where doctorcode='".$_POST['searchsuppliercode']."'";
		$exec_dr= mysqli_query($GLOBALS["___mysqli_ston"], $drsql) or die ("Error in drsql".mysqli_error($GLOBALS["___mysqli_ston"])); 
		$res_dr = mysqli_fetch_array($exec_dr);
		$docname=$res_dr["doctorname"];
		
		$query87="update billing_paylaterconsultation set doctorname='$docname',doctorcode='".$_POST['searchsuppliercode']."' where billno='".$_POST['billnumber']."'";
		$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);

		$query87="update master_visitentry set consultingdoctor='$docname',consultingdoctorcode='".$_POST['searchsuppliercode']."' where visitcode='".$_POST['visitcode']."'";
		$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);

		$query87="update billing_ipprivatedoctor set description='$docname',doccoa='".$_POST['searchsuppliercode']."' where docno='".$_POST['billnumber']."' and visitcode='".$_POST['visitcode']."'";
		$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);

		$query87="update tb set ledger_id='".$_POST['searchsuppliercode']."' where doc_number='".$_POST['billnumber']."' and from_table='billing_ipprivatedoctor' and transaction_type='C'";
		$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
		header("location:cbdoctoredit.php?status=1");
	}
}
// Handle status messages
$errmsg = '';
$bgcolorcode = '';
if (isset($_REQUEST['status']) && $_REQUEST['status'] == '1') {
	$errmsg = "Success. Bill Updated.";
	$bgcolorcode = 'success';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Name Edit - MedStar Hospital Management</title>
    
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
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- JavaScript Files -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="js/autocomplete_users.js"></script>
    <script type="text/javascript" src="js/autosuggestusers.js"></script>
    <script type="text/javascript" src="js/autocomplete_doctor.js"></script>
    <script type="text/javascript" src="js/autosuggestdoctor_stmt.js"></script>
    
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
        <span>Administration</span>
        <span>→</span>
        <span>Doctor Name Edit</span>
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
                        <a href="administration.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Administration</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="cbdoctoredit.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Name Edit</span>
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
                    <h2>Doctor Name Edit</h2>
                    <p>Search and update doctor information for existing bills and consultations.</p>
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
            <form name="cbform1" method="post" action="cbdoctoredit.php" onSubmit="return valid();" class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-search form-section-icon"></i>
                    <h3 class="form-section-title">Search Criteria</h3>
                    <span class="form-section-subtitle">Enter search parameters to find bills for doctor name editing</span>
                </div>
                
                <div class="form-section-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchbillnumber" class="form-label">Search Bill No</label>
                            <input name="searchbillnumber" type="text" id="searchbillnumber" class="form-input" value="<?php echo $searchbillnumber; ?>" placeholder="Enter bill number" autocomplete="off" />
                            <input type="hidden" name="cbcustomername" id="cbcustomername" value="" />
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
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
                    <h3 class="data-table-title">Search Results</h3>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">No.</th>
                                <th class="table-header-cell">Bill Date</th>
                                <th class="table-header-cell">Bill No</th>
                                <th class="table-header-cell">Visit</th>
                                <th class="table-header-cell">Name</th>
                                <th class="table-header-cell">Consult Doctor</th>
                                <th class="table-header-cell">Change Dr. To</th>
                                <th class="table-header-cell">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table content will be generated by PHP -->
                            <tr class="table-row-even">
                                <td class="table-cell text-center" colspan="8">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        Search results will be displayed here after search
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
        function valid() {
            if(document.getElementById('searchbillnumber').value == '') {
                alert("Please Enter Bill No.");
                return false;
            }
        }

        // Doctor validation function
        function validdoc() {
            if(document.getElementById('updatedr').value == '') {
                alert("Please select the doctor.");
                return false;
            }
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

        // Customer name function
        function cbcustomername1() {
            document.cbform1.submit();
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

<!--

body {

