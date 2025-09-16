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

$companycode = $res81['pinnumber'];

$companyname = $res81['employername'];



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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Component Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/payrollcomponentreport1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 

<!--<script type="text/javascript" src="js/autoemployeecodesearch6.js"></script> -->

    <!-- External JavaScript -->
    <script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
    <script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>

</head>







</head>


<script src="js/datetimepicker1_css.js"></script>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Payroll Component Report</p>
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
        <span>Payroll Component Report</span>
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
                    <li class="nav-item">
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Process</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbyitem3.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Stock Report by Item</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paymentmodecollectionsummary.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment Mode Collection Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paymentmodecollectionbyuser.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Payment Mode Collection by User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="revenuereport_summary.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Revenue Report Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="comparativereport.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Comparative Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="payrollcomponentreport1.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Payroll Component Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Payroll Component Report</h2>
                    <p>Generate detailed payroll component reports for specific employees and time periods.</p>
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

            <!-- Payroll Component Report Section -->
            <div class="payroll-component-section">
                <div class="payroll-component-header">
                    <div class="payroll-component-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="payroll-component-title">Search Report</div>
                </div>

                <form name="form1" id="form1" method="post" action="payrollcomponentreport1.php" onSubmit="return from1submit1()" class="search-form">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchemployee" class="form-label">Search Employee</label>
                            <div class="employee-search-input">
                                <input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo htmlspecialchars($searchemployee); ?>" class="form-input" placeholder="Type to search employees...">
                                <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                                <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchmonth" class="form-label">Search Month</label>
                            <select name="searchmonth" id="searchmonth" class="form-select">
                                <?php if($searchmonth != '') { ?>
                                <option value="<?php echo htmlspecialchars($searchmonth); ?>"><?php echo htmlspecialchars($searchmonth); ?></option>
                                <?php } ?>
                                <?php
                                $arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                                $monthcount = count($arraymonth);
                                for($i=0;$i<$monthcount;$i++) {
                                ?>
                                <option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="searchyear" class="form-label">Search Year</label>
                            <select name="searchyear" id="searchyear" class="form-select">
                                <?php if($searchyear != '') { ?>
                                <option value="<?php echo htmlspecialchars($searchyear); ?>"><?php echo htmlspecialchars($searchyear); ?></option>
                                <?php } ?>
                                <?php
                                for($j=2010;$j<=date('Y');$j++) {
                                ?>
                                <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchcomponent" class="form-label">Search Component</label>
                            <select name="searchcomponent" id="searchcomponent" class="form-select">
                                <option value="">Select Component</option>
                                <?php
                                $query13 = "select * from master_payrollcomponent where recordstatus <> 'deleted'";
                                $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res13 = mysqli_fetch_array($exec13)) {
                                    $componentname = $res13['componentname'];
                                    $componentanum = $res13['auto_number'];
                                ?>
                                <option value="<?php echo htmlspecialchars($componentanum); ?>" <?php if($searchcomponent == $componentanum) { echo "selected"; } ?>><?php echo htmlspecialchars($componentname); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Submit
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <?php
                $totalamount = '0.00';
                if($frmflag1 == 'frmflag1') {
                    if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
                    if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
                    if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
                    if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
                    
                    $searchmonthyear = $searchmonth.'-'.$searchyear; 
                    $url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee";
                ?>
                
                <div class="results-header">
                    <div class="results-title">Payroll Component Report Results</div>
                    <div class="results-actions">
                        <button type="button" class="btn btn-outline" onclick="printReport()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <div class="report-header">
                    <h3>Payroll Report</h3>
                    <div class="report-info">
                        <div class="report-info-item">
                            <div class="report-info-label">Employer's PIN</div>
                            <div class="report-info-value"><?php echo htmlspecialchars($companycode); ?></div>
                        </div>
                        <div class="report-info-item">
                            <div class="report-info-label">Employer's Name</div>
                            <div class="report-info-value"><?php echo htmlspecialchars($companyname); ?></div>
                        </div>
                        <div class="report-info-item">
                            <div class="report-info-label">Month of Contribution</div>
                            <div class="report-info-value"><?php echo htmlspecialchars($searchmonthyear); ?></div>
                        </div>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Employee Name</th>
                            <th>ID No</th>
                            <th>PIN No</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>

	<?php

	$totalamount = '0.00';

	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res2 = mysqli_fetch_array($exec2))

	{

	$res2employeecode = $res2['employeecode'];

	$res2employeename = $res2['employeename'];

	

	$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));

	$row778 = mysqli_num_rows($query778);

	if($row778 > 0)

	{

	

	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res6 = mysqli_fetch_array($exec6);

	$passportnumber = $res6['passportnumber'];

	$pinno = $res6['pinno']; 

	$payrollno = $res6['payrollno'];

	  

	$query3 = "select `$searchcomponent` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res3 = mysqli_fetch_array($exec3);

	$componentamount = $res3['componentamount'];

	

	$totalamount = $totalamount + $componentamount;

	if(true)

	{

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

                        <tr class="employee-row">
                            <td align="center"><?php echo $colorloopcount; ?></td>
                            <td class="employee-name"><?php echo htmlspecialchars($res2employeename); ?></td>
                            <td class="employee-id"><?php echo htmlspecialchars($passportnumber); ?></td>
                            <td class="employee-pin"><?php echo htmlspecialchars($pinno); ?></td>
                            <td class="amount-cell amount-positive"><?php echo number_format($componentamount,0,'.',','); ?></td>
                        </tr>	

	<?php

	}

	}

	}

	?>

                        <tr class="summary-row">
                            <td colspan="4" class="summary-label">Total:</td>
                            <td class="summary-value"><?php echo number_format($totalamount,0,'.',','); ?></td>
                        </tr>
                    </tbody>
                </table> 

                <?php
                }
                ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/payrollcomponentreport1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



