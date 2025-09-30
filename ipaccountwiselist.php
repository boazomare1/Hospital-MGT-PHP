<?php
// IP Account Wise List - Modernized Version
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include required files
include("includes/loginverify.php");
include("db/db_connect.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Default date range (last month to today)
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Location handling
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

// Form processing
$errmsg = "";
$bgcolorcode = "";

if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
    $fromdate = isset($_POST['ADate1']) ? $_POST['ADate1'] : '';
    $todate = isset($_POST['ADate2']) ? $_POST['ADate2'] : '';
    
    if (empty($fromdate) || empty($todate)) {
        $errmsg = "Please select both From Date and To Date.";
        $bgcolorcode = "failed";
    } elseif (empty($locationcode1)) {
        $errmsg = "Please select a location.";
        $bgcolorcode = "failed";
    } else {
        $errmsg = "Search completed successfully.";
        $bgcolorcode = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Account Wise List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipaccount-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Legacy CSS for compatibility -->
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />

    <!-- Legacy JavaScript -->
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
</head>



<script>



function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here



</script>



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





function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

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

.bal

{

border-style:none;

background:none;

text-align:right;

}

.number

{

padding-left:900px;

text-align:right;

font-weight:bold;

}

.bali

{

text-align:right;

}

.style1 {font-weight: bold}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>
    <!-- Loading Overlay -->
    <div id="imgloader" class="loading-overlay" style="display:none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>Processing Request</strong></p>
            <p>Please be patient...</p>
        </div>
    </div>

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
        <span>IP Account Wise List</span>
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
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ipaccountwiselist.php" class="nav-link">
                            <i class="fas fa-file-medical-alt"></i>
                            <span>IP Account Wise List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="internalreferallist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Internal Referral List</span>
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
                    <h2>IP Account Wise List</h2>
                    <p>View and search inpatient account entries by location and date range.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="form-header">
                    <i class="fas fa-search form-icon"></i>
                    <h3 class="form-title">Search IP Account Entries</h3>
                </div>
                
                <div class="form-info">
                    <div class="info-item">
                        <strong>Current Location:</strong> 
                        <span class="location-name" id="ajaxlocation">
                  <?php
                            if ($location != '') {
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						echo $res1location = $res12["locationname"];
                            } else {
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						echo $res1location = $res1["locationname"];
                            }
                            ?>
                        </span>
                    </div>
                </div>
                
                <form name="cbform1" method="post" action="ipaccountwiselist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input" 
                                       value="<?php echo $transactiondatefrom; ?>" 
                                       readonly="readonly" onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="calendar-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" class="form-input" 
                                       value="<?php echo $transactiondateto; ?>" 
                                       readonly="readonly" onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="calendar-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onChange="ajaxlocationfunction(this.value);">
                    <?php
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
                                ?>
                                    <option value="<?php echo $locationcode; ?>" <?php if($location != '' && $location == $locationcode) echo "selected"; ?>>
                                        <?php echo $locationname; ?>
                                    </option>
                                <?php } ?>
                      </select>
                        </div>
                        
                        <div class="form-group form-group-submit">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" name="Submit" class="submit-btn">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                            <button type="reset" name="resetbutton" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
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

                $querynw1 = "select * from master_ipvisitentry where locationcode='$locationcode1' and registrationdate between '$fromdate' and '$todate' order by auto_number desc";
			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
                $resnw1 = mysqli_num_rows($execnw1);
            ?>

                <!-- Results Table -->
                <div class="results-section">
                    <div class="section-header">
                        <i class="fas fa-list-alt"></i>
                        <h3>IP Account Wise List Results</h3>
                        <span class="result-count"><?php echo $resnw1; ?> entries found</span>
                    </div>
                    
                    <div class="table-container">
                        <table class="ipaccount-table">
                            <thead>
                                <tr>
                                    <th class="serial-header">No.</th>
                                    <th class="patient-header">Patient Name</th>
                                    <th class="reg-header">Reg. No.</th>
                                    <th class="visit-header">Visit Code</th>
                                    <th class="date-header">IP Date</th>
                                    <th class="account-header">Account</th>
			 </tr>
                            </thead>
                            <tbody>

                                <?php
                                $query1 = "select * from master_ipvisitentry where locationcode='$locationcode1' and registrationdate between '$fromdate' and '$todate' order by auto_number desc";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

                                while($res1 = mysqli_fetch_array($exec1)) {
                                    $patientfullname = $res1['patientfullname'];
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['visitcode'];
                                    $registrationdate = $res1['registrationdate'];
                                    $accountfullname = $res1['accountfullname'];
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $sno = $sno + 1;
                                ?>
                                <tr class="table-row">
                                    <td class="serial-cell"><?php echo $sno; ?></td>
                                    <td class="patient-cell"><?php echo htmlspecialchars($patientfullname); ?></td>
                                    <td class="reg-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                                    <td class="visit-cell"><?php echo htmlspecialchars($visitcode); ?></td>
                                    <td class="date-cell"><?php echo htmlspecialchars($registrationdate); ?></td>
                                    <td class="account-cell"><?php echo htmlspecialchars($accountfullname); ?></td>
                                </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>
            </main>
        </div>

        <!-- Modern JavaScript -->
        <script src="js/ipaccount-modern.js?v=<?php echo time(); ?>"></script>
    </body>
</html>



