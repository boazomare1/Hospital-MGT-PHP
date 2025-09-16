<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

// Get company information
$query81 = "SELECT * FROM master_company WHERE auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['employername'];

// Handle form submission and search parameters
if (isset($_REQUEST["searchemployee"])) { 
    $searchemployee = $_REQUEST["searchemployee"]; 
} else { 
    $searchemployee = ""; 
}

if (isset($_REQUEST["searchbank"])) { 
    $searchbank = $_REQUEST["searchbank"]; 
} else { 
    $searchbank = ""; 
}

if (isset($_REQUEST["searchmonth"])) { 
    $searchmonth = $_REQUEST["searchmonth"]; 
} else { 
    $searchmonth = date('M'); 
}

if (isset($_REQUEST["searchyear"])) { 
    $searchyear = $_REQUEST["searchyear"]; 
} else { 
    $searchyear = date('Y'); 
}

if (isset($_REQUEST["frmflag1"])) { 
    $frmflag1 = $_REQUEST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

// Handle status messages
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == 'success') {
    $errmsg = "Report generated successfully.";
    $bgcolorcode = 'success';
} else if ($st == 'failed') {
    $errmsg = "Failed to generate report.";
    $bgcolorcode = 'failed';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Bank Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/payrollbankreport1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Alert Container -->
    <div id="alertContainer"></div>

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
        <span>Payroll Bank Report</span>
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
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bankreconupdate.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Bank Reconciliation</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="payrollbankreport1.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Payroll Bank Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
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
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Payroll Bank Report</h2>
                    <p>Generate and view comprehensive payroll bank reports by employee, bank, month, and year.</p>
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

            <!-- Add Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-search add-form-icon"></i>
                    <h3 class="add-form-title">Search Payroll Bank Report</h3>
                </div>
                
                <form id="payrollForm" name="form1" method="post" action="payrollbankreport1.php" class="add-form">
                    <div class="form-group">
                        <label for="searchemployee" class="form-label">Search Employee</label>
                        <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                        <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                        <input type="text" name="searchemployee" id="searchemployee" 
                               autocomplete="off" value="<?php echo htmlspecialchars($searchemployee); ?>" 
                               class="form-input" placeholder="Enter employee name or code" />
                    </div>
                    
                    <div class="form-group">
                        <label for="searchbank" class="form-label">Search Bank</label>
                        <input type="text" name="searchbank" id="searchbank" 
                               autocomplete="off" value="<?php echo htmlspecialchars($searchbank); ?>" 
                               class="form-input" placeholder="Enter bank name" />
                    </div>
                    
                    <div class="form-group">
                        <label for="searchmonth" class="form-label">Search Month</label>
                        <select name="searchmonth" id="searchmonth" class="form-input">
                            <?php if($searchmonth != ''): ?>
                                <option value="<?php echo $searchmonth; ?>"><?php echo $searchmonth; ?></option>
                            <?php endif; ?>
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
                            <?php if($searchyear != ''): ?>
                                <option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
                            <?php endif; ?>
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
                    
                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Generate Report
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Data Table Section -->
            <?php if($frmflag1 == 'frmflag1'): ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-chart-bar data-table-icon"></i>
                    <h3 class="data-table-title">Payroll Bank Report Results</h3>
                </div>
                
                <?php
                $totalamount = '0.00';
                if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
                if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
                if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
                if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
                if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }

                $searchmonthyear = $searchmonth.'-'.$searchyear; 
                
                $url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchbank=$searchbank";
                ?>
                
                <div class="report-header">
                    <div class="report-info">
                        <h4><i class="fas fa-building"></i> EMPLOYER'S NAME: <?php echo $companyname; ?></h4>
                        <h4><i class="fas fa-calendar-alt"></i> MONTH OF CONTRIBUTION: <?php echo $searchmonthyear; ?></h4>
                    </div>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Payroll Number</th>
                            <th>Employee Name</th>
                            <th>Branch Name</th>
                            <th>Account No</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $totalamount = '0.00';
                            $query9 = "select * from master_employeeinfo where bankname like '%$searchbank%' and bankname <> '' group by bankname order by employeecode,bankname";
                            $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res9 = mysqli_fetch_array($exec9))
                            {
                                $res9bankname = $res9['bankname'];
                            ?>
                            <tr class="bank-header">
                                <td colspan="6"><strong><?php echo htmlspecialchars($res9bankname); ?></strong></td>
                            </tr>
                            <?php
                                $query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a JOIN master_employee b ON (a.employeecode = b.employeecode) where a.employeename like '%$searchemployee%' and a.1 > '0' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' and (b.payrollstatus = 'Active' or b.payrollstatus = 'Prorata') group by a.employeecode";
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res2 = mysqli_fetch_array($exec2))
                                {
                                    $res2employeecode = $res2['employeecode'];
                                    $res2employeename = $res2['employeename'];
                                    
                                    $query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode' and bankname = '$res9bankname'";
                                    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res6 = mysqli_fetch_array($exec6);
                                    $bankbranch = $res6['bankbranch'];
                                    $accountnumber = $res6['accountnumber'];
                                    $payrollno = $res6['payrollno'];
                                    
                                    if($accountnumber != '')
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
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td>
                                    <span class="payroll-number-badge"><?php echo htmlspecialchars($payrollno); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($res2employeename); ?></td>
                                <td><?php echo htmlspecialchars($bankbranch); ?></td>
                                <td><?php echo htmlspecialchars($accountnumber); ?></td>
                                <?php
                                    $totaldeduct = 0;
                                    $totalgrossper = 0;
                                    $query12 = "select auto_number as ganum, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
                                    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($res12 = mysqli_fetch_array($exec12))
                                    {
                                        $ganum = $res12['ganum'];
                                        $typecode = $res12['typecode'];
                                        
                                        $querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
                                        $execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $resgg = mysqli_fetch_array($execgg);
                                        $res12value = $resgg['res12value'];
                                        if($typecode == 10){
                                            $totalgrossper = $totalgrossper + $res12value; 
                                        } else { 
                                            $totaldeduct = $totaldeduct + $res12value; 
                                        }
                                    }
                                    $componentamount = $totalgrossper - $totaldeduct;
                                    $totalamount = $totalamount + $componentamount;
                                ?>
                                <td>
                                    <span class="amount-badge"><?php echo number_format($componentamount,0,'.',','); ?></span>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            }
                            ?>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="5" class="total-label"><strong>Total:</strong></td>
                            <td class="total-amount"><strong><?php echo number_format($totalamount,0,'.',','); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="export-actions">
                    <a href="print_bankreportxl.php?<?php echo $url; ?>" class="btn btn-primary">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/payrollbankreport1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

