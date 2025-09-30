<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



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

$totaldr = '0.00';

$totalcr = '0.00';



$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

include ("autocompletebuild_users.php");

$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

//$getcanum = $_GET['canum'];



if ($getcanum != '')

{

$query4 = "select * from master_customer where locationcode='$locationcode1' and auto_number = '$getcanum'";

$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$res4 = mysqli_fetch_array($exec4);

$cbcustomername = $res4['customername'];

$customername = $res4['customername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

//$cbbillnumber = $_REQUEST['cbbillnumber'];

if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

//$cbbillstatus = $_REQUEST['cbbillstatus'];


$transactiondatefrom = $_REQUEST['ADate1'];

$transactiondateto = $_REQUEST['ADate2'];


if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }

//$billstatus = $_REQUEST['billstatus'];



}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Entries Report - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/entriesreport-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/datetimepicker_css.css">
    <script src="js/datetimepicker_css.js"></script>
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

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

    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Journal Entries Report</span>
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
                        <a href="entries.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>New Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="editentries.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Edit Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="entriesreport.php" class="nav-link active">
                            <i class="fas fa-chart-line"></i>
                            <span>Entries Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="entries_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Upload Entries</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div id="alertContainer"></div>

            <div class="page-header">
                <h2 class="page-title">📊 Journal Entries Report</h2>
                <p class="page-subtitle">View and analyze journal entries</p>
            </div>

            <div class="form-container">
                <form id="form1" name="form1" method="post" action="entriesreport.php">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">From Date *</label>
                            <input type="text" class="form-control from_date" id="ADate1" name="ADate1" value="<?php echo $transactiondatefrom; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="ADate2" class="form-label">To Date *</label>
                            <input type="text" class="form-control to_date" id="ADate2" name="ADate2" value="<?php echo $transactiondateto; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select class="form-control" id="location" name="location">
                                <option value="">All Locations</option>
                                <?php
                                $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1))
                                {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location == $locationcode) ? 'selected' : '';
                                    echo "<option value='$locationcode' $selected>$locationname</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="button" class="btn btn-outline" onclick="refreshData()">
                            <i class="fas fa-refresh"></i> Refresh
                        </button>
                        <button type="button" class="btn btn-success" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($cbfrmflag1 == 'cbfrmflag1') { ?>
            <div class="data-container">
                <div class="data-header">
                    <h3 class="data-title">Journal Entries Report</h3>
                    <div>
                        <span class="text-muted">Period: <?php echo date('d/m/Y', strtotime($transactiondatefrom)); ?> - <?php echo date('d/m/Y', strtotime($transactiondateto)); ?></span>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Entry Date</th>
                                <th>Document No</th>
                                <th>Location</th>
                                <th>Ledger</th>
                                <th>Entry Type</th>
                                <th>Debit Amount</th>
                                <th>Credit Amount</th>
                                <th>Narration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 1;
                            $totalDebit = 0;
                            $totalCredit = 0;
                            
                            $query2 = "select * from master_journalentries where date(entrydate) between '$transactiondatefrom' and '$transactiondateto' order by entrydate desc, docno desc";
                            if($location != '') {
                                $query2 = "select * from master_journalentries where locationcode='$location' and date(entrydate) between '$transactiondatefrom' and '$transactiondateto' order by entrydate desc, docno desc";
                            }
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            while ($res2 = mysqli_fetch_array($exec2))
                            {
                                $entrydate = $res2["entrydate"];
                                $docno = $res2["docno"];
                                $locationname = $res2["locationname"];
                                $ledgername = $res2["ledgername"];
                                $selecttype = $res2["selecttype"];
                                $debitamount = $res2["debitamount"];
                                $creditamount = $res2["creditamount"];
                                $narration = $res2["narration"];
                                
                                $totalDebit += $debitamount;
                                $totalCredit += $creditamount;
                                
                                echo "<tr>";
                                echo "<td>$sno</td>";
                                echo "<td>" . date('d/m/Y', strtotime($entrydate)) . "</td>";
                                echo "<td>$docno</td>";
                                echo "<td>$locationname</td>";
                                echo "<td>$ledgername</td>";
                                echo "<td>$selecttype</td>";
                                echo "<td style='text-align: right;'>" . number_format($debitamount, 2) . "</td>";
                                echo "<td style='text-align: right;'>" . number_format($creditamount, 2) . "</td>";
                                echo "<td>$narration</td>";
                                echo "</tr>";
                                $sno++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: bold; background-color: #f8f9fa;">
                                <td colspan="6" style="text-align: right;">Total:</td>
                                <td style="text-align: right;"><?php echo number_format($totalDebit, 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($totalCredit, 2); ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-icon">📊</div>
                    <div class="summary-card-value"><?php echo $sno - 1; ?></div>
                    <div class="summary-card-label">Total Entries</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon">💰</div>
                    <div class="summary-card-value"><?php echo number_format($totalDebit, 2); ?></div>
                    <div class="summary-card-label">Total Debit</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon">💳</div>
                    <div class="summary-card-value"><?php echo number_format($totalCredit, 2); ?></div>
                    <div class="summary-card-label">Total Credit</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-icon">⚖️</div>
                    <div class="summary-card-value"><?php echo ($totalDebit == $totalCredit) ? 'Balanced' : 'Unbalanced'; ?></div>
                    <div class="summary-card-label">Status</div>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <button id="printButton" class="print-button" title="Print Report">
        <i class="fas fa-print"></i>
    </button>

    <script src="js/entriesreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
