<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["searchcomponent"])) { $searchcomponent = $_REQUEST["searchcomponent"]; } else { $searchcomponent = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "";
}
else if ($st == 'failed')
{
		$errmsg = "";
}

?>
<?php
$docno = $_SESSION['docno'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Process - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/payrollprocess1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/autoemployeecodesearch6.js"></script>
<script type="text/javascript" src="js/autosuggestemployeepayrollprocess1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/autoemployeepayroll1.js"></script>
<script type="text/javascript" src="js/autoemployeeloan1.js"></script>
<script type="text/javascript" src="js/autoemployeecheckpayrollprocess1.js"></script>
<script type="text/javascript" src="js/autoemployeepayrollprocess1.js"></script>
<script type="text/javascript" src="js/autoemployeeloandetails2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autoemployeepayrollprocessall1.js"></script>

</head>
<script src="js/datetimepicker1_css.js"></script>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Payroll Processing System</p>
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
        <span>Payroll Process</span>
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
                        <a href="chequescollected.php" class="nav-link">
                            <i class="fas fa-money-check"></i>
                            <span>Cheques Collected</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="claimtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Claim Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Process</span>
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
                    <h2>Payroll Process</h2>
                    <p>Process employee payroll for the selected month and year.</p>
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

            <!-- Loading Overlay -->
            <div class="loading-overlay" id="imgloader" style="display:none;">
                <div class="loading-content">
                    <div class="loading-spinner"></div>
                    <div class="loading-text">Processing... Please Wait...</div>
                </div>
            </div>
            <!-- Payroll Process Section -->
            <div class="payroll-process-section">
                <div class="payroll-process-header">
                    <div class="payroll-process-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="payroll-process-title">Payroll Process</div>
                    <div class="location-display">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo 'Location: ' . htmlspecialchars($locationname); ?>
                    </div>
                </div>

                <form name="form1" id="form1" method="post" action="payrollprocess1.php" onSubmit="return from1submit1()">
                    <input type="hidden" name="locationname" id="locationname" value="<?php echo htmlspecialchars($locationname); ?>">
                    <input type="hidden" name="locationcode" id="locationcode" value="<?php echo htmlspecialchars($locationcode); ?>">
                    <!-- Payroll Container -->
                    <div class="payroll-container">
                        <!-- Employee Section -->
                        <div class="employee-section">
                            <div class="employee-section-header">
                                <div class="employee-section-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="employee-section-title">Employee</div>
                            </div>
                            
                            <input type="hidden" name="employeecode" id="employeecode">
                            <input type="hidden" name="employeename" id="employeename">
                            <input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox">
                            
                            <div class="employee-search-container">
                                <input name="searchsuppliername" id="searchsuppliername" accesskey="s" autocomplete="off" type="text" class="employee-search-input" placeholder="Search employee by name or code..." />
                                
                                <div class="month-selector">
                                    <label for="assignmonth">Month:</label>
                                    <input type="text" name="assignmonth" id="assignmonth" readonly value="<?php echo htmlspecialchars($month); ?>" class="month-input">
                                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('assignmonth','MMMYYYY')" class="date-picker-icon" style="cursor:pointer"/>
                                </div>
                            </div>
                            
                            <div class="employee-list">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrowinsert">
                                        <!-- Employee rows will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Payroll Components Section -->
                        <div class="payroll-components-section">
                            <div class="payroll-components-header">
                                <div class="payroll-components-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div class="payroll-components-title">Payroll Components</div>
                            </div>
                            
                            <input type="hidden" name="searchemployeecode" id="searchemployeecode" readonly>
                            <input type="hidden" name="searchemployeename" id="searchemployeename" readonly>
                            <input type="hidden" name="serialno" id="serialno" value="1">
                            
                            <div class="payroll-components-list">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Component</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblrowinsert1">
                                        <!-- Payroll components will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="button" class="btn btn-primary" onClick="return CheckPayrollProcess('selected')">
                            <i class="fas fa-check-circle"></i> Process Selected
                        </button>
                        <button type="button" class="btn btn-success" onClick="return CheckPayrollProcess('all')">
                            <i class="fas fa-play"></i> Process All
                        </button>
                        <button type="button" class="btn btn-outline" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <!-- Payroll Summary -->
                    <div class="payroll-summary">
                        <div class="summary-item">
                            <div class="summary-label">Gross Pay</div>
                            <div class="summary-value gross-pay">
                                <input type="text" name="grosspay" id="grosspay" readonly placeholder="0.00">
                            </div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Total Deductions</div>
                            <div class="summary-value deductions">
                                <input type="text" name="totaldeductions" id="totaldeductions" readonly placeholder="0.00">
                            </div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Net Pay</div>
                            <div class="summary-value net-pay">
                                <input type="text" name="nettpay" id="nettpay" readonly placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/payrollprocess1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

