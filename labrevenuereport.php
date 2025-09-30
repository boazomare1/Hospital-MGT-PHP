<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

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
$amount = 0;

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
if (isset($_REQUEST["lab"])) { $lab = $_REQUEST["lab"]; } else { $lab = ""; }
if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '')
{
    $query4 = "select suppliername from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{
    $paymentreceiveddatefrom = $_REQUEST['ADate1'];
    $paymentreceiveddateto = $_REQUEST['ADate2'];
    $visitcode1 = 10;
}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
if ($task == 'deleted')
{
    $errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if ($ADate1 != '' && $ADate2 != '')
{
    $transactiondatefrom = $_REQUEST['ADate1'];
    $transactiondateto = $_REQUEST['ADate2'];
}
else
{
    $transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
    $transactiondateto = date('Y-m-d');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Revenue Report - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/labrevenuereport-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/datetimepicker_css.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($_SESSION["companyname"]); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>
    
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Lab Revenue Report</span>
    </nav>
    
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="main-container-with-sidebar">
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
                        <a href="labrequestreport.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Lab Request Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labtestreport.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Test Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labrevenuereport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Lab Revenue Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labcategory1.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Lab Categories</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="alert-container">
                <?php if (isset($errmsg) && $errmsg != "") { ?>
                    <div class="alert success">
                        <?php echo htmlspecialchars($errmsg); ?>
                    </div>
                <?php } ?>
            </div>
            
            <div class="page-header">
                <h1 class="page-title">Lab Revenue Report</h1>
                <p class="page-subtitle">Track laboratory revenue and financial performance</p>
            </div>
            
            <div class="form-section">
                <h2 class="form-title">Search Criteria</h2>
                <form name="cbform1" method="post" action="labrevenuereport.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="lab" class="form-label">Search Lab</label>
                            <input type="text" name="lab" id="lab" class="form-input" size="60" value="<?php echo htmlspecialchars($lab); ?>" placeholder="Search for lab items...">
                            <input type="hidden" name="labcode" id="labcode">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input date-input" value="<?php echo $paymentreceiveddatefrom; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" class="calendar-icon" title="Select Date">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" class="form-input date-input" value="<?php echo $paymentreceiveddateto; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" class="calendar-icon" title="Select Date">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="slocation" class="form-label">Location</label>
                            <select name="slocation" id="slocation" class="form-select">
                                <option value="All">All</option>
                                <?php
                                $query01="select locationcode,locationname from master_location where status ='' order by locationname";
                                $exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
                                while($res01=mysqli_fetch_array($exc01))
                                {?>
                                    <option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="type" class="form-label">Patient Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="" selected>ALL</option>
                                <option value="OP" <?php if($type=='OP'){ echo "selected";} ?>> OP + EXTERNAL </option>
                                <option value="IP" <?php if($type=='IP'){ echo "selected";} ?>> IP </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="reset" class="btn btn-outline">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                    </div>
                </form>
            </div>
            
            <?php
            $num1=0;
            $num2=0;
            $num3=0;
            $num6=0;
            $grandtotal = 0;
            $res2itemname = '';
            
            $ADate1 = $transactiondatefrom;
            $ADate2 = $transactiondateto;
            
            if($cbfrmflag1 == 'cbfrmflag1')
            {
                $j = 0;
                $crresult = array();
                
                if($slocation=='All')
                {
                    $pass_location = "locationcode !=''";
                }
                else
                {
                    $pass_location = "locationcode ='$slocation'";
                }
                
                if($type == 'OP')
                {
                    $querycr1in = "SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paynowlab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                   UNION ALL SELECT labitemrate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `billing_externallab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                   UNION ALL SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paylaterlab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
                }
                else if($type == 'IP')
                {
                    $querycr1in = "SELECT rateuhx as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_iplab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
                }
                else 
                {
                    $querycr1in = "SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paynowlab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                   UNION ALL SELECT labitemrate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `billing_externallab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                   UNION ALL SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paylaterlab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                   UNION ALL SELECT rateuhx as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_iplab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
                }			   
                
                $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
                $totalIncome = 0;
                $totalRefund = 0;
                
                // Calculate total income first
                $tempResult = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($tempRow = mysqli_fetch_array($tempResult))
                {
                    $totalIncome += $tempRow['income'];
                }
            ?>
            
            <div class="data-section">
                <div class="data-header">
                    <h2 class="data-title">Revenue Report</h2>
                    <div class="search-container">
                        <span class="location-display">
                            <strong>Period: </strong><?php echo $ADate1; ?> to <?php echo $ADate2; ?>
                        </span>
                    </div>
                </div>
                
                <div class="financial-summary">
                    <div class="summary-grid">
                        <div class="summary-card income">
                            <div class="summary-label">Total Income</div>
                            <div class="summary-value income"><?php echo number_format($totalIncome, 2); ?></div>
                        </div>
                        <div class="summary-card refund">
                            <div class="summary-label">Total Refunds</div>
                            <div class="summary-value refund"><?php echo number_format($totalRefund, 2); ?></div>
                        </div>
                        <div class="summary-card net">
                            <div class="summary-label">Net Revenue</div>
                            <div class="summary-value net"><?php echo number_format($totalIncome - $totalRefund, 2); ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Bill Date</th>
                                <th>Reg Code</th>
                                <th>Visit Code</th>
                                <th>Patient Name</th>
                                <th>Category</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Rate</th>
                                <th>Bill Type</th>
                                <th>Account Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $rowCount = 0;
                            
                            while($rescr1 = mysqli_fetch_array($execcr1))
                            {
                                $rowCount++;
                                $patientcode = $rescr1['pcode'];
                                $patientname = $rescr1['pname'];
                                $patientvisitcode = $rescr1['vcode'];
                                $itemcode = $rescr1['lcode'];
                                $itemname = $rescr1['lname'];
                                $billdate = $rescr1['date'];
                                $labrate = $rescr1['income'];
                                
                                $query4 = "select categoryname from master_lab where itemcode = '$itemcode'";
                                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res4 = mysqli_fetch_array($exec4);
                                $categoryname = $res4['categoryname'];
                                
                                $res4accountname = $rescr1['accountname'];
                                if( $res4accountname != 'CASH - HOSPITAL')
                                {
                                    $res4billtype = 'PAY LATER';
                                }
                                else
                                {
                                    $res4billtype = 'PAY NOW';
                                }
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = 'bgcolor="#ecf0f5"';
                                }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td><?php echo $rowCount; ?></td>
                                <td><?php echo $billdate; ?></td>
                                <td><?php echo htmlspecialchars($patientcode); ?></td>
                                <td><?php echo htmlspecialchars($patientvisitcode); ?></td>
                                <td><?php echo htmlspecialchars($patientname); ?></td>
                                <td><?php echo htmlspecialchars($categoryname); ?></td>
                                <td><?php echo htmlspecialchars($itemcode); ?></td>
                                <td><?php echo htmlspecialchars($itemname); ?></td>
                                <td class="text-right"><?php echo number_format($labrate,2,'.',','); ?></td>
                                <td><?php echo $res4billtype; ?></td>
                                <td><?php echo htmlspecialchars($res4accountname); ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            
                            <tr class="total-row">
                                <td colspan="8" class="text-right"><strong>Total</strong></td>
                                <td class="text-right"><strong><?php echo number_format($totalIncome,2); ?></strong></td>
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="section-header">
                    <i class="fas fa-undo"></i>
                    Refund Details
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Bill Date</th>
                                <th>Reg Code</th>
                                <th>Visit Code</th>
                                <th>Patient Name</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Rate</th>
                                <th>Bill Type</th>
                                <th>Account Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $amount=0;
                            $j=0;
                            $total = 0;
                            
                            if($type == "OP")
                            {
                                $querydr1in = "SELECT (labitemrate) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `refund_paynowlab` WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                               UNION ALL SELECT (fxamount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `refund_paylaterlab` WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                               UNION ALL SELECT labfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billtype as billtype FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
                            }
                            else if($type == "IP")
                            {
                                $querydr1in = "SELECT rate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,'' as lcode, '' as lname, consultationdate as date, accountname as accountname, '' as billtype FROM `ip_discount` WHERE description = 'Lab' AND consultationdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
                            }
                            else
                            {
                                $querydr1in = "SELECT (labitemrate) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `refund_paynowlab` WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                               UNION ALL SELECT (fxamount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `refund_paylaterlab` WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                               UNION ALL SELECT labfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billtype as billtype FROM `billing_patientweivers` WHERE labfxamount > '0' and entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
                                               UNION ALL SELECT rate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,'' as lcode, '' as lname, consultationdate as date, accountname as accountname, '' as billtype FROM `ip_discount` WHERE description = 'Lab' AND consultationdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
                            }
                            
                            $execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $refundCount = 0;
                            
                            while($resdr1 = mysqli_fetch_array($execdr1))
                            {
                                $refundCount++;
                                $patientcode = $resdr1['pcode'];
                                $patientname = $resdr1['pname'];
                                $patientvisitcode = $resdr1['vcode'];
                                $itemcode = $resdr1['lcode'];
                                $itemname = $resdr1['lname'];
                                $billdate = $resdr1['date'];
                                $labrate = $resdr1['income'];
                                $total = $total + $labrate;
                                $totalRefund += $labrate;
                                
                                $res4accountname = $resdr1['accountname'];
                                if($res4accountname != 'CASH - HOSPITALCASH COLLECTIONS')
                                {
                                    $res4billtype = 'PAY LATER';
                                }
                                else
                                {
                                    $res4billtype = 'PAY NOW';
                                }
                                
                                $colorloopcount = $colorloopcount + 1;
                                $showcolor = ($colorloopcount & 1); 
                                if ($showcolor == 0) {
                                    $colorcode = 'bgcolor="#CBDBFA"';
                                } else {
                                    $colorcode = 'bgcolor="#ecf0f5"';
                                }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td><?php echo $refundCount; ?></td>
                                <td><?php echo $billdate; ?></td>
                                <td><?php echo htmlspecialchars($patientcode); ?></td>
                                <td><?php echo htmlspecialchars($patientvisitcode); ?></td>
                                <td><?php echo htmlspecialchars($patientname); ?></td>
                                <td><?php echo htmlspecialchars($itemcode); ?></td>
                                <td><?php echo htmlspecialchars($itemname); ?></td>
                                <td class="text-right"><?php echo number_format($labrate,2,'.',','); ?></td>
                                <td><?php echo $res4billtype; ?></td>
                                <td><?php echo htmlspecialchars($res4accountname); ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            
                            <tr class="total-row">
                                <td colspan="7" class="text-right"><strong>Total Refunds</strong></td>
                                <td class="text-right"><strong><?php echo number_format($total,2); ?></strong></td>
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="financial-summary">
                    <div class="summary-grid">
                        <div class="summary-card net">
                            <div class="summary-label">Grand Total</div>
                            <div class="summary-value net"><?php echo number_format($totalIncome - $totalRefund,2);?></div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-label">Export Report</div>
                            <div class="summary-value">
                                <a href="xl_labrevenuereport.php?slocation=<?= $slocation; ?>&&type=<?= $type ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?= $transactiondatefrom ?>&&ADate2=<?= $transactiondateto ?>&&lab=<?php echo $lab; ?>" 
                                   class="btn btn-success export-btn" target="_blank">
                                    <i class="fas fa-file-excel"></i>
                                    Export Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
            }
            ?>
        </main>
    </div>
    
    <script src="js/labrevenuereport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>