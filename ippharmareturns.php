<?php
session_start();  
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Initialize form variables
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$docno = $_SESSION['docno'];

// Handle form parameters with modern isset() checks
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$getcanum = isset($_REQUEST["canum"]) ? $_REQUEST["canum"] : "";
$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";

// Get location for sort by location purpose
if($location != '') {
    $locationcode = $location;
}


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
$adjustmentdate=date('Y-m-d');
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$addstock=$_POST['addstock'][$key];
		$minusstock=$_POST['minusstock'][$key];
		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res40 = mysqli_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,locationcode)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber','".$locationcode."')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,locationcode)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber','".$locationcode."')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		}
	header("location:stockadjustment.php");
	exit;
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Pharma Returns - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Additional CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <style>
        .bodytext31:hover { font-size:14px; }
        .bal {
            border-style:none;
            background:none;
            text-align:right;
        }
        .bali {
            text-align:right;
        }
    </style>
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
        <span>Pharmacy</span>
        <span>→</span>
        <span>IP Pharma Returns</span>
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
                        <a href="pharmacy.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipmedicineissue.php" class="nav-link">
                            <i class="fas fa-prescription-bottle"></i>
                            <span>IP Medicine Issue</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ippharmareturns.php" class="nav-link">
                            <i class="fas fa-undo"></i>
                            <span>IP Pharma Returns</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="medicinereturnrequest.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Medicine Return Request</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing</span>
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
                    <h2>IP Pharma Returns</h2>
                    <p>Search and process pharmacy returns for inpatients with comprehensive tracking and refund management.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}



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
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
		
		
            <!-- Search Form -->
            <form name="cbform1" method="post" action="ippharmareturns.php" class="search-form">
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fas fa-search form-section-icon"></i>
                        <h3 class="form-section-title">Search IP Pharmacy Returns</h3>
                    </div>
                    
                    <div class="form-section-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <select name="location" id="location" class="form-input" onChange="return funclocationChange1();">
                                    <?php
                                    $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $res1location = $res1["locationname"];
                                        $res1locationanum = $res1["locationcode"];
                                    ?>
                                        <option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="patient" class="form-label">Patient Name</label>
                                <input name="patient" type="text" id="patient" class="form-input" value="" size="50" autocomplete="off" placeholder="Enter patient name">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="patientcode" class="form-label">Patient Code</label>
                                <input name="patientcode" type="text" id="patientcode" class="form-input" value="" size="50" autocomplete="off" placeholder="Enter patient code">
                            </div>
                            
                            <div class="form-group">
                                <label for="visitcode" class="form-label">Visit Code</label>
                                <input name="visitcode" type="text" id="visitcode" class="form-input" value="" size="50" autocomplete="off" placeholder="Enter visit code">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ADate1" class="form-label">Date From</label>
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" class="form-input" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer; margin-left: 5px;"></i>
                            </div>
                            
                            <div class="form-group">
                                <label for="ADate2" class="form-label">Date To</label>
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" class="form-input" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer; margin-left: 5px;"></i>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                                <button type="submit" class="btn btn-primary" name="Submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Results Table -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1') { ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">IP Pharmacy Returns</h3>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr class="table-header">
                            <th class="table-header-cell">No.</th>
                            <th class="table-header-cell">IP Date</th>
                            <th class="table-header-cell">Doc No</th>
                            <th class="table-header-cell">Patient Code</th>
                            <th class="table-header-cell">Visit Code</th>
                            <th class="table-header-cell">Patient Name</th>
                            <th class="table-header-cell">Bill No</th>
                            <th class="table-header-cell">Account</th>
                            <th class="table-header-cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $colorloopcount = 0;
                        $sno = 0;
                        $searchpatient = $_POST['patient'];
                        $searchpatientcode = $_POST['patientcode'];
                        $searchvisitcode = $_POST['visitcode'];
                        $fromdate = $_POST['ADate1'];
                        $todate = $_POST['ADate2'];
                        
                        $query1 = "select max(psd.auto_number) auto_number,psd.patientcode,psd.visitcode,psd.patientname,psd.entrydate,psd.accountname,max(psd.ipdocno) ipdocno,mipv.finalbillno from pharmacysales_details psd inner join master_ipvisitentry mipv on psd.visitcode=mipv.visitcode where psd.locationcode = '".$locationcode."' AND psd.patientcode like '%$searchpatientcode%' and psd.visitcode like '%$searchvisitcode%' and psd.patientname like '%$searchpatient%' and psd.issuedfrom = 'ip' and psd.entrydate between '$fromdate' and '$todate' and psd.accountname='CASH - HOSPITAL' group by psd.patientcode,psd.visitcode order by auto_number desc";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $num1 = mysqli_num_rows($exec1);
                        
                        while($res1 = mysqli_fetch_array($exec1)) {
                            $patientname = $res1['patientname'];
                            $patientcode = $res1['patientcode'];
                            $visitcode = $res1['visitcode'];
                            $consultationdate = $res1['entrydate'];
                            $accountname = $res1['accountname'];	
                            $docnumber = $res1['ipdocno'];
                            
                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                            if ($showcolor == 0) {
                                $colorcode = 'class="table-row-even"';
                            } else {
                                $colorcode = 'class="table-row-odd"';
                            }
                            $billno = trim($res1['finalbillno']);
                            
                            if($billno != "") {
                        ?>
                                <tr <?php echo $colorcode; ?>>
                                    <td class="table-cell text-center"><?php echo $sno = $sno + 1; ?></td>
                                    <td class="table-cell"><?php echo $consultationdate; ?></td>
                                    <td class="table-cell"><?php echo $docnumber; ?></td>
                                    <td class="table-cell"><?php echo $patientcode; ?></td>
                                    <td class="table-cell"><?php echo $visitcode; ?></td>
                                    <td class="table-cell"><?php echo $patientname; ?></td>
                                    <td class="table-cell"><?php echo $billno; ?></td>
                                    <td class="table-cell"><?php echo $accountname; ?></td>
                                    <td class="table-cell">
                                        <a href="ippharmacyreturns.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>&&menuid=<?php echo $menu_id; ?>" class="btn btn-outline btn-sm">
                                            <i class="fas fa-undo"></i> Refund
                                        </a>
                                    </td>
                                </tr>
                        <?php 
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript Functions -->
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('leftSidebar');
            const toggle = document.querySelector('.sidebar-toggle i');
            
            sidebar.classList.toggle('collapsed');
            toggle.classList.toggle('fa-chevron-left');
            toggle.classList.toggle('fa-chevron-right');
        }

        // Page refresh function
        function refreshPage() {
            window.location.reload();
        }

        // Export to Excel function
        function exportToExcel() {
            // Add export functionality here
            alert('Export functionality will be implemented');
        }

        // Print report function
        function printReport() {
            window.print();
        }

        // Initialize sidebar toggle on menu button click
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('leftSidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>

    <!-- Include Required JavaScript Files -->
    <script src="js/datetimepicker_css.js"></script>

    <!-- JavaScript for functionality -->
    <script type="text/javascript">
        function cbsuppliername1() {
            document.cbform1.submit();
        }

        function disableEnterKey(varPassed) {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode;
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;
            } else {
                key = e.which;
            }
            
            if(key == 13) {
                return false;
            } else {
                return true;
            }
        }

        function process1backkeypress1() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode;
                return false;
            }
        }

        function disableEnterKey() {
            if (event.keyCode == 8) {
                event.keyCode = 0; 
                return event.keyCode;
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;
            } else {
                key = e.which;
            }
            
            if(key == 13) {
                return false;
            } else {
                return true;
            }
        }

        function paymententry1process2() {
            if (document.getElementById("cbfrmflag1").value == "") {
                alert("Search Bill Number Cannot Be Empty.");
                document.getElementById("cbfrmflag1").focus();
                document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
                return false;
            }
        }

        function funcPrintReceipt1() {
            window.open("print_payment_receipt1.php", "OriginalWindow<?php echo $banum; ?>", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        }

        function funclocationChange1() {
            // Add location change functionality here
            return true;
        }
    </script>

</body>
</html>

