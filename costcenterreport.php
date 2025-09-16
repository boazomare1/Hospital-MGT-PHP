<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$totalnetprofit = 0;
$searchsuppliername = "";

$res1username = '';
$res2username = '';
$res3username = '';
$res4username = '';
$res5username = '';
$res6username = '';
$res7username = '';

$transactiondatefrom = date('Y-m-01');
$transactiondateto = date('Y-m-d');

ini_set('max_execution_time', 300);

if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('m'); }
if (isset($_REQUEST["searchquarter"])) { $searchquarter = $_REQUEST["searchquarter"]; } else { $searchquarter = ""; }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["searchyear1"])) { $searchyear1 = $_REQUEST["searchyear1"]; } else { $searchyear1 = ""; }
if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
if (isset($_REQUEST["period"])) { $period = $_REQUEST["period"]; } else { $period = ""; }
if (isset($_REQUEST["cc_name"])) { $cc_name = $_REQUEST["cc_name"]; } else { $cc_name = ""; }
if (isset($_REQUEST["searchmonthto"])) { $searchmonthto = $_REQUEST["searchmonthto"]; } else { $searchmonthto = date('m'); }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $transactiondatefrom = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $transactiondateto = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Center Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/costcenterreport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Additional CSS -->
    <link href="css/three.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
</head>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Cost Center Financial Report System</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?> | Date: <?php echo date('Y-m-d'); ?></span>
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
        <a href="costcenter.php">Cost Center Management</a>
        <span>→</span>
        <span>Cost Center Report</span>
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
                        <a href="costcenter.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Cost Center Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="costcenterreport.php" class="nav-link active">
                            <i class="fas fa-chart-bar"></i>
                            <span>Cost Center Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consumablebyunit.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Consumable Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationtype_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Upload Consultation Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addconsultationtemplate.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Template</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundrequestlist.php" class="nav-link">
                            <i class="fas fa-undo"></i>
                            <span>Refund Request List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundlist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Consultation Refund List</span>
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
                    <li class="nav-item">
                        <a href="chequescollected.php" class="nav-link">
                            <i class="fas fa-money-check"></i>
                            <span>Cheques Collected</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="claimtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Claim Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Process</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbyitem3.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Stock Report by Item</span>
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
                    <h2>Cost Center Financial Report</h2>
                    <p>Generate comprehensive financial reports and analysis by cost center for different time periods.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
<?php



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$totalnetprofit=0;

$searchsuppliername = "";

$res1username = '';

$res2username = '';

$res3username = '';

$res4username = '';

$res5username = '';

$res6username = '';

$res7username = '';


$transactiondatefrom = date('Y-m-01');
$transactiondateto = date('Y-m-d');


ini_set('max_execution_time', 300);

if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('m'); }
if (isset($_REQUEST["searchquarter"])) { $searchquarter = $_REQUEST["searchquarter"]; } else { $searchquarter = ""; }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["searchyear1"])) { $searchyear1 = $_REQUEST["searchyear1"]; } else { $searchyear1 = ""; }
if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
if (isset($_REQUEST["period"])) { $period = $_REQUEST["period"]; } else { $period = ""; }
	if (isset($_REQUEST["cc_name"])) { $cc_name = $_REQUEST["cc_name"]; } else { $cc_name = ""; }
	if (isset($_REQUEST["searchmonthto"])) { $searchmonthto = $_REQUEST["searchmonthto"]; } else { $searchmonthto = date('m'); }
	if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $transactiondatefrom = $_REQUEST["ADate1"];  } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $transactiondateto = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }



?>

<style type="text/css">
.bodytext31:hover { font-size:14px; }

.btn {
    background-color: rgba(0, 255, 0, 0.4);
    display: inline-block;
    zoom: 1;
    line-height: normal;
    white-space: nowrap;
    vertical-align: baseline;
    text-align: center;
    cursor: pointer;
    FONT-WEIGHT: normal;
    font-family: Tahoma;
    font-size: 11px;
    padding: .5em .9em .5em 1em;
    text-decoration: none;
    border-radius: 4px;
    text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
}

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->




</style>

<!-- Modern CSS -->
<link href="costcenterreport.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="css/autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

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

function valid()
{
	if(document.getElementById('cc_name').value =='')
	{
		alert("Please Select Cost Center");
		return false;
	}
	if(document.getElementById('period1').value =='monthly')
	{
	
		if(document.getElementById('searchyear').value =='')
	    {
	
		alert("Please Select  Year");
		return false;
		}
	}
	
	if(document.getElementById('period1').value =='quarterly')
	{
	
		if(document.getElementById('searchquarter').value =='')
	    {
	
		alert("Please Select Quarter Range");
		return false;
		}
		if(document.getElementById('searchyear1').value =='')
	    {
	
		alert("Please Select Year");
		return false;
		}
	}
	
	
}

function funchangeperiod(id)
{
document.getElementById('dates range').style.display = 'none';
document.getElementById('monthly').style.display = 'none';
document.getElementById('monthly12').style.display = 'none';
document.getElementById('quarterly').style.display = 'none';
document.getElementById('yearly').style.display = 'none';
if(id != '' )
{
document.getElementById(id).style.display = '';
if(id=='monthly'){
document.getElementById('monthly12').style.display = '';
}
}
}


function exportExcel() {
  //alert('clicked custom button 1!');
  //var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#calendar').html()) 
  //location.href=url
  //return false
  var a = document.createElement('a');
    var a1 = document.getElementById('ADate1').value;
	  var a2 = document.getElementById('ADate2').value;
	  var cc_name1 = document.getElementById('costname').value;
	
  //getting data from our div that contains the HTML table
  var data_type = 'data:application/vnd.ms-excel';
  a.href = data_type + ', ' + encodeURIComponent($('#data').html());
  //setting the file name
 // ..a.download ='costcenter_.'a1'.xls';
 //alert(a1);
 //return false;
  a.download ='Cost Center'+'_'+'Cost Center'+'_'+cc_name1+'_'+a1+'_To_'+a2+'.xls';
  //triggering the function
  a.click();
  //just in case, prevent default behaviour
  e.preventDefault();
  return (a);
  /* end of excel function */
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script src="js/datetimepicker_css.js"></script>
<!-- Modern JavaScript -->
<script type="text/javascript" src="costcenterreport.js"></script>

</head>

<body>

            <!-- Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <i class="fas fa-filter form-header-icon"></i>
                    <h3 class="form-header-title">Report Filters</h3>
                </div>
                
                <form name="frmsales" id="frmsales" method="post" action="costcenterreport.php" class="form-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cc_name" class="form-label">Cost Center</label>
                            <select id="cc_name" name="cc_name" class="form-input">
                                <option value="" selected="selected">Select Cost Center</option>
                                <?php
                                $query1 = "select * from master_costcenter where recordstatus <> 'deleted' order by name";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1))
                                {
                                    $res1categoryname = $res1["name"];
                                    $res1categoryname = strtoupper($res1categoryname);
                                    $res1auto_number = $res1["auto_number"];
                                    ?>
                                    <option value="<?php echo $res1auto_number; ?>"<?php if($res1auto_number==$cc_name) echo 'selected'; ?>><?php echo $res1categoryname; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="period1" class="form-label">Report Period</label>
                            <select name="period" id="period1" onChange="funchangeperiod(this.value);" class="form-input">
                                <?php if($period != '') { ?>
                                    <option value="<?php echo $period; ?>"><?php echo ucwords($period); ?></option>
                                <?php } else { ?>
                                    <option value="">Select Period</option>
                                <?php } ?>
                                <option value="dates range">Date Range</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                    </div>
					
                    
                    <!-- Period Selection Options -->
                    <div class="period-selection">
                        <!-- Date Range Option -->
                        <div id="dates range" class="period-option" style="display:none">
                            <h4>Date Range Selection</h4>
                            <div class="period-row">
                                <div class="form-group">
                                    <label for="ADate1" class="form-label">Date From</label>
                                    <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" class="form-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                </div>
                                <div class="form-group">
                                    <label for="ADate2" class="form-label">Date To</label>
                                    <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" class="form-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Monthly Option -->
                        <div id="monthly" class="period-option" style="display:none">
                            <h4>Monthly Selection</h4>
                            <div class="period-row">
                                <div class="form-group">
                                    <label for="searchmonth" class="form-label">From Month</label>
                                    <select name="searchmonth" id="searchmonth" class="form-input">
                                        <option <?php if($searchmonth == '1') { ?> selected = 'selected' <?php } ?> value="1">January</option>
                                        <option <?php if($searchmonth == '2') { ?> selected = 'selected' <?php } ?> value="2">February</option>
                                        <option <?php if($searchmonth == '3') { ?> selected = 'selected' <?php } ?> value="3">March</option>
                                        <option <?php if($searchmonth == '4') { ?> selected = 'selected' <?php } ?> value="4">April</option>
                                        <option <?php if($searchmonth == '5') { ?> selected = 'selected' <?php } ?> value="5">May</option>
                                        <option <?php if($searchmonth == '6') { ?> selected = 'selected' <?php } ?> value="6">June</option>
                                        <option <?php if($searchmonth == '7') { ?> selected = 'selected' <?php } ?> value="7">July</option>
                                        <option <?php if($searchmonth == '8') { ?> selected = 'selected' <?php } ?> value="8">August</option>
                                        <option <?php if($searchmonth == '9') { ?> selected = 'selected' <?php } ?> value="9">September</option>
                                        <option <?php if($searchmonth == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                                        <option <?php if($searchmonth == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                                        <option <?php if($searchmonth == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="searchmonthto" class="form-label">To Month</label>
                                    <select name="searchmonthto" id="searchmonthto" class="form-input">
                                        <option <?php if($searchmonthto == '1') { ?> selected = 'selected' <?php } ?> value="1">January</option>
                                        <option <?php if($searchmonthto == '2') { ?> selected = 'selected' <?php } ?> value="2">February</option>
                                        <option <?php if($searchmonthto == '3') { ?> selected = 'selected' <?php } ?> value="3">March</option>
                                        <option <?php if($searchmonthto == '4') { ?> selected = 'selected' <?php } ?> value="4">April</option>
                                        <option <?php if($searchmonthto == '5') { ?> selected = 'selected' <?php } ?> value="5">May</option>
                                        <option <?php if($searchmonthto == '6') { ?> selected = 'selected' <?php } ?> value="6">June</option>
                                        <option <?php if($searchmonthto == '7') { ?> selected = 'selected' <?php } ?> value="7">July</option>
                                        <option <?php if($searchmonthto == '8') { ?> selected = 'selected' <?php } ?> value="8">August</option>
                                        <option <?php if($searchmonthto == '9') { ?> selected = 'selected' <?php } ?> value="9">September</option>
                                        <option <?php if($searchmonthto == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                                        <option <?php if($searchmonthto == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                                        <option <?php if($searchmonthto == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Monthly Year Selection -->
                        <div id="monthly12" class="period-option" style="display:none">
                            <h4>Year Selection</h4>
                            <div class="period-row">
                                <div class="form-group">
                                    <label for="searchyear" class="form-label">Select Year</label>
                                    <?php $years = range(2018, strftime("2025", time())); ?>
                                    <select name="searchyear" id="searchyear" class="form-input">
                                        <?php if($searchyear != ''){ ?>
                                            <option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
                                        <?php } ?>
                                        <option value="">Select Year</option>
                                        <?php foreach($years as $year1) : ?>
                                            <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quarterly Option -->
                        <div id="quarterly" class="period-option" style="display:none">
                            <h4>Quarterly Selection</h4>
                            <div class="period-row">
                                <div class="form-group">
                                    <label for="searchquarter" class="form-label">Quarter</label>
                                    <select name="searchquarter" id="searchquarter" class="form-input">
                                        <option value="">Select Quarter</option>
                                        <?php 
                                        $arrayquarter = ["Jan-Mar","Apr-Jun","Jul-Sep","Oct-Dec"];
                                        $quartercount = count($arrayquarter);
                                        for($i=0;$i<$quartercount;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i; ?>" <?php if($searchquarter == $i && $searchquarter !='' ) { echo "selected"; }?>><?php echo $arrayquarter[$i]; ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="searchyear1" class="form-label">Year</label>
                                    <select name="searchyear1" id="searchyear1" class="form-input">
                                        <?php if($searchyear1 != ''){ ?>
                                            <option value="<?php echo $searchyear1; ?>"><?php echo $searchyear1; ?></option>
                                        <?php } ?>
                                        <option value="">Select Year</option>
                                        <?php foreach($years as $year1) : ?>
                                            <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Yearly Option -->
                        <div id="yearly" class="period-option" style="display:none">
                            <h4>Yearly Selection</h4>
                            <div class="period-row">
                                <div class="form-group">
                                    <label for="fromyear" class="form-label">From Year</label>
                                    <select name="fromyear" id="fromyear" class="form-input">
                                        <?php if($fromyear != ''){ ?>
                                            <option value="<?php echo $fromyear; ?>"><?php echo $fromyear; ?></option>
                                        <?php } ?>
                                        <option value="">Select Year</option>
                                        <?php foreach($years as $year1) : ?>
                                            <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="toyear" class="form-label">To Year</label>
                                    <select name="toyear" id="toyear" class="form-input">
                                        <?php if($toyear != ''){ ?>
                                            <option value="<?php echo $toyear; ?>"><?php echo $toyear; ?></option>
                                        <?php } ?>
                                        <option value="">Select Year</option>
                                        <?php foreach($years as $year1) : ?>
                                            <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
					
            <?php
            $colorloopcount = 0;
            $sno = 0;
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

            if ($cbfrmflag1 == 'cbfrmflag1') {
                $cc_name = $_POST['cc_name'];
                
                if($period == 'quarterly') {
                    $stmonth = ($searchquarter*3)+1;
                    $enmonth = ($searchquarter+1)*3;
                    $fromdate = date('Y-m-d',strtotime('01-'.$stmonth.'-'.$searchyear1));
                    $todate = date('Y-m-t',strtotime('01-'.$enmonth.'-'.$searchyear1));
                } elseif($period == 'dates range') {
                    $fromdate = $ADate1;
                    $todate = $ADate2;
                }
                
                $query612 = "select * from master_costcenter where auto_number = '$cc_name' and recordstatus <> 'deleted'";
                $exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res612 = mysqli_fetch_array($exec612);
                $res612cost_center = $res612['name'];
            ?>

            <!-- Report Section -->
            <div class="report-section">
                <div class="report-header">
                    <div class="report-header-content">
                        <h3>Financial Report</h3>
                        <p>Cost Center: <?php echo $res612cost_center; ?> | Period: <?php echo ucwords($period); ?></p>
                    </div>
                    <div class="report-actions">
                        <a href="costcenterreport_excel.php?period=<?=$period?>&&searchmonth=<?=$searchmonth?>&&searchmonthto=<?=$searchmonthto?>&&searchyear=<?=$searchyear?>&&searchyear1=<?=$searchyear1?>&&fromyear=<?=$fromyear?>&&toyear=<?=$toyear?>&&searchquarter=<?=$searchquarter?>&&cc_name=<?=$cc_name?>&&ADate1=<?=$ADate1?>&&ADate2=<?=$ADate2?>" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
                
                <div id="data" class="report-content">
                    <?php if($period == 'dates range') { ?>
                        <table class="financial-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $gorsstotalamount = 0;
                                $gorsstotalamount1 = 0;
                                $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY A.ledger_id";
                                
                                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $num12 = mysqli_num_rows($exec12);
                                while ($res12 = mysqli_fetch_array($exec12)) {
                                    $res12name = $res12['name'];
                                    $res12id = $res12['id'];
                                    $res12accountsmain = $res12['accountsmain'];
                                    $res12auto_number = $res12['auto_number'];
                                    
                                    if($res12accountsmain=='4') {
                                        $query2 = "Select sum(amount) as trn_amount FROM (SELECT transaction_type, CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`))) END AS amount FROM `tb` WHERE `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') GROUP BY transaction_type) as result";
                                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($res2 = mysqli_fetch_array($exec2)) {
                                            $amount = $res2['trn_amount'];
                                            $gorsstotalamount += $amount;
                                        }
                                    }
                                    
                                    if($res12accountsmain=='5') {
                                        $query21 = "Select sum(amount) as trn_amount FROM (SELECT transaction_type, CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`))) END AS amount FROM `tb` WHERE `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') GROUP BY transaction_type) as result";
                                        $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($res21 = mysqli_fetch_array($exec21)) {
                                            $res21amount = $res21['trn_amount'];
                                            $gorsstotalamount1 += $res21amount;
                                        }
                                    }
                                }
                                ?>
                                <tr>
                                    <td><strong>Total Revenue</strong></td>
                                    <td><?php echo number_format($gorsstotalamount,2); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Less: Supplies Cost</strong></td>
                                    <td><?php echo number_format($gorsstotalamount1,2); ?></td>
                                </tr>
                                <?php
                                $grosscc = $gorsstotalamount - $gorsstotalamount1;
                                ?>
                                <tr>
                                    <td><strong>Gross Profit</strong></td>
                                    <td><strong><?php echo number_format($grosscc,2); ?></strong></td>
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr>
                                    <td colspan="2"><strong>Expenses</strong></td>
                                </tr>
                                <?php
                                $totres201amount = 0;
                                $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY ledger_id";
                                $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($res20 = mysqli_fetch_array($exec20)) {
                                    $res20ledger_id = $res20['ledger_id'];
                                    $res20transaction_type = $res20['transaction_type'];
                                    $res20accountname = ucwords(strtolower($res20['accountname']));
                                    
                                    $query201 = "Select sum(amount) as trn_amount FROM (SELECT transaction_type, CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`))) END AS amount FROM `tb` WHERE `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name' GROUP BY transaction_type) as result";
                                    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res201 = mysqli_fetch_array($exec201);
                                    $res201amount = $res201['trn_amount'];
                                    $totres201amount += $res201amount;
                                    if($res201amount > 0) {
                                        ?>
                                        <tr>
                                            <td><?php echo $res20accountname; ?></td>
                                            <td><?php echo number_format($res201amount,2); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                <tr>
                                    <td><strong>Total Expenses</strong></td>
                                    <td><strong><?php echo number_format($totres201amount,2); ?></strong></td>
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <?php
                                $totalnetprofit = $grosscc - $totres201amount;
                                ?>
                                <tr>
                                    <td><strong>Net Profit Before Tax</strong></td>
                                    <td><strong><?php echo number_format($totalnetprofit,2); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/costcenterreport-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Additional Scripts -->
    <script src="js/datetimepicker_css.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    
    <?php 
    if($period != '') {
        echo "<script>funchangeperiod('".$period."');</script>";
    }
    ?>
</body>
</html>
