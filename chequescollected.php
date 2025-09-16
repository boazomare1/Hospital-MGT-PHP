<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



$searchsuppliername = "";

//This include updatation takes too long to load for hunge items database.



include ("autocompletebuild_supplier2.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheques Collected - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/chequescollected-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

    <!-- External JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/autocomplete_supplier2.js"></script>
    <script type="text/javascript" src="js/autosuggest3supplier.js"></script>
</head>


<script type="text/javascript">

function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}





function process1backkeypress1()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		return false;

	}

	else

	{

		return true;

	}



}



function paymententry1process2()

{

	if (document.getElementById("cbfrmflag1").value == "")

	{

		alert ("Search Bill Number Cannot Be Empty.");

		document.getElementById("cbfrmflag1").focus();

		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";

		return false;

	}

}

</script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.style1 {font-weight: bold}

.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Cheques Collected Report</p>
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
        <span>Cheques Collected</span>
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
                    <li class="nav-item active">
                        <a href="chequescollected.php" class="nav-link">
                            <i class="fas fa-money-check"></i>
                            <span>Cheques Collected</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
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
                <h2>Cheques Collected Report</h2>
                <p>View and manage collected cheques from suppliers and vendors.</p>
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
                <h3 class="search-form-title">Search Cheques Collected</h3>
            </div>
            
            <form name="cbform1" method="post" action="chequescollected.php" class="search-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <input name="ADate1" id="ADate1" class="form-input" 
                               value="<?php echo htmlspecialchars($transactiondatefrom); ?>" 
                               readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" class="date-picker-icon"/>
                    </div>

                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <input name="ADate2" id="ADate2" class="form-input" 
                               value="<?php echo htmlspecialchars($transactiondateto); ?>" 
                               readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" class="date-picker-icon"/>
                    </div>
                </div>

                <div class="form-actions">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <?php
        $colorloopcount = 0;
        $sno = 0;
        if (isset($_REQUEST["cbfrmflag1"])) { 
            $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
        } else { 
            $cbfrmflag1 = ""; 
        }

        if ($cbfrmflag1 == 'cbfrmflag1') {
            $fromdate = $_POST['ADate1'];
            $todate = $_POST['ADate2'];
        ?>
        
        <div class="results-table-section">
            <div class="results-table-header">
                <i class="fas fa-list results-table-icon"></i>
                <h3 class="results-table-title">Cheques Collected Report</h3>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Doc No</th>
                            <th>Supplier</th>
                            <th>Cheque Number</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                        $totalamount = 0;
                        $query22 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and transactionmode='CHEQUE' and transactiondate between '$fromdate' and '$todate' group by suppliername order by suppliername";
                        $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while ($res22 = mysqli_fetch_array($exec22)) {
                            $res22suppliername = $res22['suppliername'];
                        ?>
                        
                        <tr class="supplier-header">
                            <td colspan="7">
                                <i class="fas fa-building"></i> <?php echo htmlspecialchars($res22suppliername); ?>
                            </td>
                        </tr>

                        <?php
                        $query2 = "select * from master_transactionpharmacy where suppliername = '$res22suppliername' and transactionmodule = 'PAYMENT' and transactionmode='CHEQUE' and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $num2 = mysqli_num_rows($exec2);

                        while ($res2 = mysqli_fetch_array($exec2)) {
                            $totalamount = 0;
                            $transactiondate = $res2['transactiondate'];
                            $date = explode(" ", $transactiondate);
                            $docno = $res2['docno'];
                            $mode = $res2['transactionmode'];
                            $suppliername = $res2['suppliername'];

                            $query51 = "select sum(transactionamount) as transactionamount from paymentmodecredit where billnumber='$docno'";
                            $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res51 = mysqli_fetch_array($exec51);
                            $totalamount = $res51['transactionamount'];  
                            $chequenumber = $res2['chequenumber'];

                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                        ?>

                        <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $colorloopcount; ?></td>
                            <td>
                                <span class="date-badge"><?php echo date('d/m/Y', strtotime($date[0])); ?></span>
                            </td>
                            <td>
                                <span class="doc-no"><?php echo htmlspecialchars($docno); ?></span>
                            </td>
                            <td>
                                <span class="supplier-name"><?php echo htmlspecialchars($suppliername); ?></span>
                            </td>
                            <td>
                                <span class="cheque-number"><?php echo htmlspecialchars($chequenumber); ?></span>
                            </td>
                            <td>
                                <span class="amount"><?php echo number_format($totalamount, 2, '.', ','); ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="print_suppliercheque.php?suppliername=<?php echo urlencode($suppliername); ?>&docno=<?php echo urlencode($docno); ?>" 
                                       target="_blank" class="action-btn print" title="Print Cheque">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <?php
                        }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php
        }
        ?>
        
        </main>
    </div>
    
    <!-- Footer -->
    <footer class="page-footer">
        <?php include ("includes/footer1.php"); ?>
    </footer>

    <!-- Modern JavaScript -->
    <script src="js/chequescollected-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



