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

if ($frmflag1 == 'frmflag1')
{
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
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
    <title>Payroll Per Component Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/payrollpercomponent-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- External JavaScript -->
    <script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
    <script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>
    <script src="js/datetimepicker1_css.js"></script>
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
        <span>Payroll Reports</span>
        <span>→</span>
        <span>Payroll Per Component</span>
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
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Payroll Process</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollcomponentreport1.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Component Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="payrollpercomponent.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Per Component Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addemployee.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Add Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="master_payrollcomponent.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Payroll Components</span>
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
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Payroll Per Component Report</h2>
                    <p>Generate detailed payroll reports by component for specific employees and time periods.</p>
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

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Criteria</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="payrollpercomponent.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchemployee" class="form-label">Search Employee</label>
                            <input type="text" name="searchemployee" id="searchemployee" 
                                   class="form-input" value="<?php echo htmlspecialchars($searchemployee); ?>" 
                                   placeholder="Enter employee name or code" autocomplete="off">
                            <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                            <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchmonth" class="form-label">Search Month</label>
                            <select name="searchmonth" id="searchmonth" class="form-input">
                                <?php if($searchmonth != '') { ?>
                                <option value="<?php echo htmlspecialchars($searchmonth); ?>"><?php echo htmlspecialchars($searchmonth); ?></option>
                                <?php } ?>
                                <?php
                                $arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                                $monthcount = count($arraymonth);
                                for($i=0;$i<$monthcount;$i++)
                                {
                                ?>
                                <option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="searchyear" class="form-label">Search Year</label>
                            <select name="searchyear" id="searchyear" class="form-input">
                                <?php if($searchyear != '') { ?>
                                <option value="<?php echo htmlspecialchars($searchyear); ?>"><?php echo htmlspecialchars($searchyear); ?></option>
                                <?php } ?>
                                <?php
                                for($j=2010;$j<=date('Y');$j++)
                                {
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
                            <select name="searchcomponent" id="searchcomponent" class="form-input">
                                <option value="">All Components</option>
                                <?php
                                $query13 = "select * from master_payrollcomponent where recordstatus <> 'deleted'";
                                $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res13 = mysqli_fetch_array($exec13))
                                {
                                $componentname = $res13['componentname'];
                                $componentanum = $res13['auto_number'];
                                ?>
                                <option value="<?php echo $componentanum; ?>" <?php if($searchcomponent == $componentanum) { echo "selected"; } ?>><?php echo htmlspecialchars($componentname); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
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

            <!-- Report Results Section -->
            <?php
            $totalamount = '0.00';
            if($frmflag1 == 'frmflag1')
            {	
                if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
                if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
                if (isset($_REQUEST["searchcomponent"])) { $searchcomponent1 = $_REQUEST["searchcomponent"]; } else { $searchcomponent1 = ""; }
                if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
                if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

                $searchmonthyear = $searchmonth.'-'.$searchyear;
                $previous = $searchyear.'-'.$searchmonth.'-01';
                $previous1 = date("d M Y",strtotime($previous));
                
                $prevmonth = date("M-Y",mktime(0,0,0,date("m", strtotime($previous1))-1,1,date("Y", strtotime($previous1))));
                $url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchcomponent=$searchcomponent1";
            ?>	
            
            <div class="report-results-section">
                <div class="report-header">
                    <div class="report-title">
                        <i class="fas fa-file-invoice-dollar report-icon"></i>
                        <h3>ED Changes Per Component</h3>
                    </div>
                    <div class="report-actions">
                        <a target="_blank" href="print_payrollpercomponentpdf.php?<?php echo $url; ?>" class="btn btn-outline">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a target="_blank" href="print_payrollpercomponentexl.php?<?php echo $url; ?>" class="btn btn-outline">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>
                </div>

                <div class="report-info">
                    <div class="info-item">
                        <span class="info-label">Employer's PIN:</span>
                        <span class="info-value"><?php echo htmlspecialchars($companycode); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Employer's Name:</span>
                        <span class="info-value"><?php echo htmlspecialchars($companyname); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Month of Contribution:</span>
                        <span class="info-value"><?php echo htmlspecialchars($searchmonthyear); ?></span>
                    </div>
                </div>

                <div class="report-table-container">
                    <?php
                    if($searchcomponent1 !=''){
                        $query134 = "select auto_number,componentname from master_payrollcomponent where auto_number= '$searchcomponent1' AND recordstatus <> 'deleted'";
                    }else{
                        $query134 = "select auto_number, componentname from master_payrollcomponent where recordstatus <> 'deleted' order by auto_number ASC";
                    }
                    $exec134 = mysqli_query($GLOBALS["___mysqli_ston"], $query134) or die ("Error in Query134".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($res134 = mysqli_fetch_array($exec134)){
                    
                        $componentname4 = $res134['componentname'];
                        $searchcomponent = $res134['auto_number'];
                        $srno = 0;
                    ?>
                    
                    <div class="component-section">
                        <div class="component-header">
                            <h4>ED: <?php echo htmlspecialchars($searchcomponent." ".$componentname4); ?></h4>
                        </div>
                        
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>DPT</th>
                                    <th>EMP NO</th>
                                    <th>EMPLOYEE NAME</th>
                                    <th class="text-right">PREVIOUS PERIOD</th>
                                    <th class="text-right">CURRENT PERIOD</th>
                                    <th class="text-right">CUM BALANCE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalamount = '0.00';
                                $query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $numrows = mysqli_num_rows($exec2);
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
                                
                                $departmentunit = $res6['departmentunit'];
                                $departmentname = $res6['departmentname'];
                                
                                $query5 = "select auto_number from master_payrolldepartment where department = '$departmentname' AND recordstatus <> 'deleted' ";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res5 = mysqli_fetch_array($exec5);
                                 $dep = $res5['auto_number'];
                                 
                                $query312 = "select `$searchcomponent` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$prevmonth' and status <> 'deleted'";
                                $exec312 = mysqli_query($GLOBALS["___mysqli_ston"], $query312) or die ("Error in Query312".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res312 = mysqli_fetch_array($exec312);
                                $previousamount = $res312['componentamount'];
                                
                                $query3 = "select `$searchcomponent` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res3 = mysqli_fetch_array($exec3);
                                $componentamount = $res3['componentamount'];
                                
                                if($componentamount != $previousamount){
                                    
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
                                $srno = $srno+1;
                                ?>
                                <tr <?php echo $colorcode; ?>>
                                <td class="text-center"><?php echo htmlspecialchars($dep); ?></td>
                                <td><?php echo htmlspecialchars($payrollno); ?></td>
                                <td><?php echo htmlspecialchars($res2employeename); ?></td>
                                <td class="text-right"><?php echo number_format($previousamount,0,'.',','); ?></td>
                                <td class="text-right"><?php echo number_format($componentamount,0,'.',','); ?></td>
                                <td class="text-right">&nbsp;</td>
                                </tr>	
                                <?php
                                }
                                }
                                }
                                }
                                if($srno == '0')
                                {
                                ?>
                                <tr>
                                <td colspan="6" class="text-center no-records">
                                    <i class="fas fa-exclamation-circle"></i>
                                    No Records Found
                                </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                    <td class="text-right"><strong><?php echo number_format($totalamount,0,'.',','); ?></strong></td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/payrollpercomponent-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>