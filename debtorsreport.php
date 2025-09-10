<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');





$snocount = "";

$colorloopcount="";

$range = "";

$admissiondate = "";

$ipnumber = "";

$patientname = "";

$gender = "";

$admissiondoc = "";

$consultingdoc = "";

$companyname = "";

$bedno = "";

$dischargedate = "";

$wardcode = "";

$locationcode = "";



//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");





if (isset($_REQUEST["wardcode1"])) { $wardcode = $_REQUEST["wardcode1"]; } else { $wardcode = ""; }



if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

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
    <title>Debtors Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/debtorsreport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>




















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
        <span>Debtors Report</span>
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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
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
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="debtorsreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Debtors Report</span>
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
                <h2>Debtors Report</h2>
                <p>Comprehensive analysis of outstanding debts and payment patterns across all departments.</p>
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

        <!-- Filter Form Section -->
        <div class="filter-form-section">
            <div class="filter-form-header">
                <i class="fas fa-filter filter-form-icon"></i>
                <h3 class="filter-form-title">Report Filters</h3>
            </div>
            
            <form name="cbform1" method="post" action="debtorsreport.php" class="filter-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="locationcode" class="form-label">Location</label>
                        <select name="locationcode" id="locationcode" class="form-input">
                            <option value="All">All Locations</option>
                            <?php
                            $query20 = "select * FROM master_location";
                            $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20". mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res20 = mysqli_fetch_array($exec20)){
                            ?>
                                <option value="<?php echo $res20['locationcode'];?>" <?php if($locationcode1==$res20['locationcode']){ echo  'selected'; } ?>><?php echo $res20['locationname'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>" class="form-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                            <button type="button" class="date-picker-btn" onClick="javascript:NewCssCal('ADate1')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <div class="date-input-group">
                            <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>" class="form-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                            <button type="button" class="date-picker-btn" onClick="javascript:NewCssCal('ADate2')">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Generate Report
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <?php if(isset($_POST['Submit'])): ?>
        <div class="results-section">
            <div class="results-header">
                <div class="results-title">
                    <i class="fas fa-chart-line results-icon"></i>
                    <h3>Debtors Report Results</h3>
                </div>
                <div class="results-actions">
                    <a href="print_debtorsreportxls.php?ADate1=<?php echo $ADate1; ?>&ADate2=<?php echo $ADate2; ?>&locationcode1=<?php echo $locationcode1; ?>" 
                       class="btn btn-success" title="Export to Excel">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Account Name</th>
                            <th>MIS Type</th>
                            <th class="text-right">OP Revenue</th>
                            <th class="text-right">IP Revenue</th>
                            <th class="text-right">Doc. Share</th>
                        </tr>
                    </thead>
                    <tbody>

          

        <?php

            $revenue = $totalrevenue = 0.00;
            $oprevenue = $optotalrevenue = 0.00;
            $doc_share_amount = $total_doc_share_amount = 0.00;

            $acountname = '';
			
				if($locationcode1=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$locationcode1'";
				}

            // 02-4500-1 CASH ACCOUNT ID
            // 07-7701 REPLACE WITH CASH ACCOUNT ID

               $query1 = "SELECT accountname, sum(revenue) as revenue, miscode, sum(oprev) as oprev, sum(doc_share) as doc_share, sum(doc_share_org) as doc_share_org, sum(pvt_bill1) as pvt_bill1   from (

                  SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname, master_accountname.misreport as miscode FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ip.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ip.$pass_location  group by master_subtype.auto_number

                  UNION ALL SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- PRIVATE DOC BILLING CALCULATIONS
                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                    -- 1 start
                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa!='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa!='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- 2 one

                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.original_amt) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP'  and billing_ipprivatedoctor.coa='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.original_amt) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- 3 close

                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype!='IP' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype!='IP' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- PRIVATE DOC BILLING CALCULATIONS CLOSES

                   -- IP REBATE
                  UNION ALL SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ipnhif.amount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipnhif` JOIN master_accountname ON billing_ipnhif.accountcode = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipnhif.recorddate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ipnhif.$pass_location group by master_subtype.auto_number

                  -- IP Discount 
                  UNION ALL 
                    SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*ip_discount.rate) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN ip_discount ON  ip_discount.patientvisitcode=billing_ip.visitcode  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and ip_discount.consultationdate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*ip_discount.rate) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN ip_discount ON  ip_discount.patientvisitcode=billing_ipcreditapproved.visitcode  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and ip_discount.consultationdate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number
                 
                                  -- IP Close ============ OP Starts  
                  UNION ALL
                  SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, sum(billing_paylater.totalamount) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paylater.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_paylater.$pass_location group by master_subtype.auto_number

                   UNION ALL
                    -- paynow credits
                   SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, sum(billing_paynowpharmacy.fxamount) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_paynowpharmacy` JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' and billing_paynowpharmacy.$pass_location group by master_subtype.auto_number

                    UNION ALL
                    -- paynow credits
                    SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, sum(billing_consultation.consultation) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_consultation` JOIN master_accountname ON billing_consultation.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_consultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' and billing_consultation.$pass_location group by master_subtype.auto_number

                                    -- ====== OP Ends and DOC SHARE STARTS ========

                    -- DOC SHARE IN SERVICES
                     UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipservices.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipservices ON  billing_ipservices.patientvisitcode=billing_ip.visitcode  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ip.$pass_location group by master_subtype.auto_number
                     
                     UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipservices.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipservices ON  billing_ipservices.patientvisitcode=billing_ipcreditapproved.visitcode  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number
                     

                      -- DOC SHARE IN CREDIT CONSULTATION
                     UNION ALL SELECT '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_consultation.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number join billing_consultation on billing_consultation.patientvisitcode=master_visitentry.visitcode WHERE billing_consultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_consultation.accountname != 'CASH - HOSPITAL' and master_visitentry.$pass_location group by master_subtype.auto_number

                     -- DOC SHARE IN billing_paylaterconsultation CONSULTATION
                     UNION ALL SELECT '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_paylaterconsultation.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number join billing_paylaterconsultation on billing_paylaterconsultation.visitcode=master_visitentry.visitcode WHERE billing_paylaterconsultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_paylaterconsultation.accountname != 'CASH - HOSPITAL' and master_visitentry.$pass_location group by master_subtype.auto_number
 
                      -- ip pvt doc share
                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipprivatedoctor.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipprivatedoctor.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  ) as rev group by accountname order by accountname";

                  // -- paynow credits
                    // -- SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share,  sum(billing_paynowpharmacy.fxamount) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number JOIN billing_paynowpharmacy on billing_paynowpharmacy.patientvisitcode=master_visitentry.visitcode WHERE billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_paynowpharmacy.accountname != 'CASH - HOSPITAL'  group by master_subtype.auto_number
                  // for the removal of the accountname   -- paynow credits
                  // -- SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share,  sum(billing_consultation.consultation) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number JOIN billing_consultation on billing_consultation.patientvisitcode=master_visitentry.visitcode WHERE billing_consultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_consultation.accountname != 'CASH - HOSPITAL'  group by master_subtype.auto_number
 
       // 'PVTDOC' as naming, billing_ipprivatedoctor.coa as coa, billing_ipprivatedoctor.visittype as visittype,
      // '' as naming, '' as coa, '' as visittype, '0' as doc_share_org,

              $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

              while($res1 = mysqli_fetch_array($exec1)){


                  $accountname = $res1['accountname'];
                  $revenue = $res1['revenue'];
                  $oprevenue = $res1['oprev'];
                  $doc_share_amount = $res1['doc_share'];
                  $doc_share_org_amount = 0;

                  $account_doc_share=$doc_share_amount+$doc_share_org_amount;

                  $miscode = $res1['miscode'];


                  $totalrevenue += $revenue;
                  $optotalrevenue += $oprevenue;
                  $total_doc_share_amount += $account_doc_share;
                  // $total_doc_share_amount += $doc_share_amount;



                  $query2 = "select * from mis_types where auto_number = '$miscode'";

                  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));

                  $res2 = mysqli_fetch_array($exec2);

                  $mistype = $res2['type'];



                  $snocount = $snocount + 1;

                

                  //echo $cashamount;

                  $colorloopcount = $colorloopcount + 1;

                  $showcolor = ($colorloopcount & 1); 

                  if ($showcolor == 0)

                  {

                    //echo "if";

                    $colorcode = 'bgcolor="#CBDBFA"';

                  }

                  else

                  {

                    //echo "else";

                    $colorcode = 'bgcolor="#ecf0f5"';

                  }

              ?>

                        <tr>
                            <td><?php echo $snocount; ?></td>
                            <td><?php echo htmlspecialchars($accountname); ?></td>
                            <td><?php echo htmlspecialchars($mistype); ?></td>
                            <td class="text-right financial-positive"><?php echo number_format($oprevenue,2); ?></td>
                            <td class="text-right financial-positive"><?php echo number_format($revenue,2); ?></td>
                            <td class="text-right financial-positive"><?php echo number_format($account_doc_share,2); ?></td>
                        </tr>

            <?php } ?>

                        <tr class="total-row">
                            <td colspan="3"><strong>TOTAL REVENUE</strong></td>
                            <td class="text-right"><strong><?php echo number_format($optotalrevenue,2); ?></strong></td>
                            <td class="text-right"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>
                            <td class="text-right"><strong><?php echo number_format($total_doc_share_amount,2); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script>
        // Modern JavaScript functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar functionality
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('leftSidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mainContainer = document.querySelector('.main-container-with-sidebar');

            // Toggle sidebar visibility
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    mainContainer.classList.toggle('sidebar-collapsed');
                });
            }

            // Toggle sidebar collapse
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    mainContainer.classList.toggle('sidebar-collapsed');
                });
            }

            // Close sidebar when clicking backdrop
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024) {
                    if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                        mainContainer.classList.remove('sidebar-collapsed');
                    }
                }
            });

            // Form validation
            const form = document.querySelector('.filter-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const dateFrom = document.getElementById('ADate1').value;
                    const dateTo = document.getElementById('ADate2').value;
                    
                    if (!dateFrom || !dateTo) {
                        e.preventDefault();
                        alert('Please select both date from and date to.');
                        return false;
                    }
                    
                    if (new Date(dateFrom) > new Date(dateTo)) {
                        e.preventDefault();
                        alert('Date from cannot be greater than date to.');
                        return false;
                    }
                });
            }
            
            // Add loading state to form submission
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.addEventListener('click', function() {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
                    this.disabled = true;
                });
            }
            
            // Auto-refresh functionality
            function refreshPage() {
                window.location.reload();
            }
            
            // Export functionality
            function exportToExcel() {
                const form = document.querySelector('.filter-form');
                if (form) {
                    // Create a temporary form for export
                    const exportForm = document.createElement('form');
                    exportForm.method = 'GET';
                    exportForm.action = 'print_debtorsreportxls.php';
                    
                    const dateFrom = document.getElementById('ADate1').value;
                    const dateTo = document.getElementById('ADate2').value;
                    const location = document.getElementById('locationcode').value;
                    
                    if (dateFrom && dateTo) {
                        const inputs = [
                            {name: 'ADate1', value: dateFrom},
                            {name: 'ADate2', value: dateTo},
                            {name: 'locationcode1', value: location}
                        ];
                        
                        inputs.forEach(input => {
                            const inputElement = document.createElement('input');
                            inputElement.type = 'hidden';
                            inputElement.name = input.name;
                            inputElement.value = input.value;
                            exportForm.appendChild(inputElement);
                        });
                        
                        document.body.appendChild(exportForm);
                        exportForm.submit();
                        document.body.removeChild(exportForm);
                    } else {
                        alert('Please select date range before exporting.');
                    }
                }
            }
            
            // Make functions globally available
            window.refreshPage = refreshPage;
            window.exportToExcel = exportToExcel;
        });
    </script>
</body>
</html>

