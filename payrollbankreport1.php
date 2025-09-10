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
$companyname = $res81['employername'];

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

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
    <title>Payroll Bank Report - <?php echo $companyname; ?></title>
    <link rel="stylesheet" href="css/payrollbankreport1-modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title"><?php echo $companyname; ?></h1>
        <p class="hospital-subtitle">Payroll Bank Report System</p>
    </header>

    <!-- User Info Bar -->
    <div class="user-info-bar">
        <div class="user-info">
            <i class="fas fa-user"></i>
            <span>Welcome, <?php echo $username; ?></span>
        </div>
        <div class="datetime">
            <i class="fas fa-calendar"></i>
            <span><?php echo date('d M Y, h:i A'); ?></span>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span class="separator">/</span>
            <span>Payroll</span>
            <span class="separator">/</span>
            <span>Bank Report</span>
        </div>
    </nav>

    <!-- Floating Menu Toggle -->
    <button id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <?php include ("includes/menu1.php"); ?>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <h2><i class="fas fa-file-invoice-dollar"></i> Payroll Bank Report</h2>
                    <p>Generate and view payroll bank reports by employee, bank, month, and year</p>
                </div>
                <div class="page-header-actions">
                    <button onclick="refreshPage()" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button onclick="exportToExcel()" class="btn btn-secondary">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>

            <!-- Alert Messages -->
            <?php include ("includes/alertmessages1.php"); ?>

            <!-- Search Form -->
            <section class="search-section">
                <div class="section-header">
                    <h3><i class="fas fa-search"></i> Search Report</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="payrollbankreport1.php" class="search-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="searchemployee" class="form-label">Search Employee</label>
                            <input type="hidden" name="autobuildemployee" id="autobuildemployee">
                            <input type="hidden" name="searchemployeecode" id="searchemployeecode">
                            <input type="text" name="searchemployee" id="searchemployee" 
                                   autocomplete="off" value="<?php echo $searchemployee; ?>" 
                                   class="form-input" placeholder="Enter employee name or code" />
                        </div>
                        
                        <div class="form-group">
                            <label for="searchbank" class="form-label">Search Bank</label>
                            <input type="text" name="searchbank" id="searchbank" 
                                   autocomplete="off" value="<?php echo $searchbank; ?>" 
                                   class="form-input" placeholder="Enter bank name" />
                        </div>
                        
                        <div class="form-group">
                            <label for="searchmonth" class="form-label">Search Month</label>
                            <select name="searchmonth" id="searchmonth" class="form-select">
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
                            <select name="searchyear" id="searchyear" class="form-select">
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
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="button" onclick="clearForm()" class="btn btn-secondary">
                            <i class="fas fa-eraser"></i> Clear Form
                        </button>
                    </div>
                </form>
            </section>

            <!-- Report Results -->
            <?php if($frmflag1 == 'frmflag1'): ?>
            <section class="report-section">
                <div class="section-header">
                    <h3><i class="fas fa-chart-bar"></i> Bank Report Results</h3>
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
                
                <div class="table-container">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>PAYROLL NUMBER</th>
                                <th>EMPLOYEE NAME</th>
                                <th>BRANCH NAME</th>
                                <th>ACCOUNT NO</th>
                                <th>AMOUNT</th>
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
                                <td colspan="6"><strong><?php echo $res9bankname; ?></strong></td>
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
                            <tr <?php echo $colorcode; ?>>
                                <td class="serial-number"><?php echo $colorloopcount; ?></td>
                                <td class="payroll-number"><?php echo $payrollno; ?></td>
                                <td class="employee-name"><?php echo $res2employeename; ?></td>
                                <td class="branch-name"><?php echo $bankbranch; ?></td>
                                <td class="account-number"><?php echo $accountnumber; ?></td>
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
                                <td class="amount"><?php echo number_format($componentamount,0,'.',','); ?></td>
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
                </div>
                
                <div class="export-actions">
                    <a href="print_bankreportxl.php?<?php echo $url; ?>" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            </section>
            <?php endif; ?>
        </main>
    </div>

    <!-- Footer -->
    <?php include ("includes/footer1.php"); ?>

    <!-- Scripts -->
    <script src="js/payrollbankreport1-modern.js"></script>
</body>
</html>

