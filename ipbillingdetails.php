<?php
// Inpatient Billing Details - Modernized Version
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include required files
include("includes/loginverify.php");
include("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Form processing and validation
$errmsg = "";
$bgcolorcode = "";

// Initialize variables
$location = isset($_POST['location']) ? $_POST['location'] : '';
$locationcode1 = isset($_POST['location']) ? $_POST['location'] : '';
$billnumbercode = isset($_POST['billnumbercode']) ? $_POST['billnumbercode'] : '';

// Form validation
if (isset($_POST["cbfrmflag1"])) {
    $cbfrmflag1 = $_POST["cbfrmflag1"];
    if ($cbfrmflag1 == 'cbfrmflag1') {
        if (empty($_POST['visitcode'])) {
            $errmsg = "Please select a patient";
            $bgcolorcode = "failed";
        } else {
            $searchpatient = $_POST['visitcode'];
            $locationcode1 = $_POST['location'];
        }
    }
}

// Legacy variables for compatibility
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.

$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inpatient Billing Details - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipbillingdetails-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <?php include ("js/dropdownlistipbilling.php"); ?>
    <script type="text/javascript" src="js/autosuggestipbilling1.js"></script>
    <script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>

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
</script>

<script language="javascript">
function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}

function funcvalidcheck()
{
if(document.cbform1.customer.value == '')
{
alert("Please Enter the Patient Name");
return false;
}
}
</script>

<script type="text/javascript">
function disableEnterKey(varPassed)
{
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

function process1backkeypress1()
{
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
{
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
</script>

<style type="text/css">
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none}
.bal {border-style:none; background:none; text-align:right;}
.bali {text-align:right;}
</style>
</head>

<script type="text/javascript">
$(function() {
$('#customer').autocomplete({
	source:'ajaxunfinalizedvisits.php', 
	select: function(event,ui){
			var customercode = ui.item.customercode;
			var visitcode = ui.item.visitcode;
			$('#customercode').val(customercode);
			$('#visitcode').val(visitcode);
			},
	html: true
    });
});
</script>

<body>
    <!-- Loading Overlay -->
    <div id="imgloader" class="loading-overlay" style="display:none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>Loading Billing Details</strong></p>
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
            <a href="ipbilling.php" class="btn btn-outline">📋 IP Billing</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <a href="ipbilling.php">IP Billing</a>
        <span>→</span>
        <span>Billing Details</span>
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
                        <a href="ipbilling.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>IP Billing</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ipbillingdetails.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Billing Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipaccountwiselist.php" class="nav-link">
                            <i class="fas fa-file-medical-alt"></i>
                            <span>IP Account Wise List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipadmissionlist_tat.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>IP Admission TAT</span>
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
                    <h2>Inpatient Billing Details</h2>
                    <p>View detailed billing information for inpatient services including packages, pharmacy, lab, radiology, and services.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <a href="ipbilling.php" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back to Billing
                    </a>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="form-header">
                    <i class="fas fa-search form-icon"></i>
                    <h3 class="form-title">Patient Billing Details Search</h3>
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
                
                <form name="cbform1" method="post" action="ipbillingdetails.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="customer" class="form-label">Patient Search</label>
                            <input name="customer" id="customer" class="form-input" 
                                   placeholder="Search by patient name or visit code..." 
                                   autocomplete="off">
                            <input name="customercode" id="customercode" value="" type="hidden">
                            <input name="visitcode" id="visitcode" value="" type="hidden">
                            <input type="hidden" name="recordstatus" id="recordstatus">
                            <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo isset($billnumbercode) ? $billnumbercode : ''; ?>">
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
                            <button type="submit" name="Submit" class="submit-btn" onClick="return funcvalidcheck();">
                                <i class="fas fa-search"></i>
                                Search Details
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
            $colorloopcount=0;
            $sno=0;
            
            if (isset($_REQUEST["cbfrmflag1"])) { 
                $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
            } else { 
                $cbfrmflag1 = ""; 
            }
            
            if ($cbfrmflag1 == 'cbfrmflag1') {
                $searchpatient = $_POST['visitcode'];
            ?>
            
            <div class="results-section">
                <div class="section-header">
                    <h3><i class="fas fa-list-alt"></i> Billing Details Results</h3>
                    <div class="section-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="exportResults()">
                            <i class="fas fa-file-excel"></i> Export
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="printResults()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="billing-details-table">
                        <thead>
                            <tr>
                                <th class="serial-cell">No.</th>
                                <th class="patient-name-cell">Patient Name</th>
                                <th class="reg-no-cell">Reg No</th>
                                <th class="visit-cell">IP Visit</th>
                                <th class="bed-cell">Current Bed</th>
                                <th class="admission-date-cell">Admission Date</th>
                                <th class="package-cell">Package</th>
                                <th class="actions-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

           <?php
		  if($searchpatient != '')
		  { 
           $query34 = "select * from master_ipvisitentry where locationcode='$locationcode1' and visitcode like '%$searchpatient%'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientfullname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $package = $res34['package'];
		   $date = $res34['registrationdate'];
		   $packageamount = $res34['packagecharge'];
		   
		   $query36 = "select * from ip_bedallocation where locationcode='$locationcode1' and visitcode='$visitcode'";
		   $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res36 = mysqli_fetch_array($exec36);
		   $bedac = $res36['bed'];
		   
		   $query35 = "select bed from master_bed where locationcode='$locationcode1' and auto_number = '$bedac'";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res35 = mysqli_fetch_array($exec35);
		   $bedac = $res35['bed'];
		   
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

                            <tr class="table-row">
                                <td class="serial-cell"><?php echo $sno = $sno + 1; ?></td>
                                <td class="patient-name-cell"><?php echo htmlspecialchars($patientname); ?></td>
                                <td class="reg-no-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                                <td class="visit-cell"><?php echo htmlspecialchars($visitcode); ?></td>
                                <td class="bed-cell"><?php echo htmlspecialchars($bedac); ?></td>
                                <td class="admission-date-cell"><?php echo htmlspecialchars($date); ?></td>
                                <td class="package-cell"><?php echo htmlspecialchars($package); ?></td>
                                <td class="actions-cell">
                                    <button type="button" class="btn-action btn-view" onclick="viewDetails('<?php echo $visitcode; ?>')" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-action btn-print" onclick="printBill('<?php echo $visitcode; ?>')" title="Print Bill">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </td>
                            </tr>

                            <?php if($package != 0): ?>
                            <tr class="package-details-row">
                                <td colspan="8" class="package-details-cell">
                                    <div class="package-section">
                                        <h4><i class="fas fa-box"></i> Package Details</h4>
                                        <div class="package-info">
                                            <div class="info-row">
                                                <span class="info-label">Package:</span>
                                                <span class="info-value">
                                                    <?php 
                                                    $query40 = "select packagename from master_ippackage where locationcode='$locationcode1' and auto_number = '$package'";
                                                    $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    $res40 = mysqli_fetch_array($exec40);
                                                    $packagename = $res40['packagename']; 
                                                    echo htmlspecialchars($packagename);
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">Amount:</span>
                                                <span class="info-value"><?php echo number_format($packageamount,2,'.',','); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">Date:</span>
                                                <span class="info-value"><?php echo htmlspecialchars($date); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                            
                            <!-- Additional sections can be added here for Lab, Radiology, Services, etc. -->
                            
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Section -->
                <div class="pagination-section">
                    <div class="pagination-info">
                        <span>Showing results for patient: <strong><?php echo htmlspecialchars($searchpatient); ?></strong></span>
                    </div>
                </div>
            </div>
        
        <?php
        // End of search results
        }
        }
        }
        ?>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipbillingdetails-modern.js?v=<?php echo time(); ?>"></script>

</body>
</html>