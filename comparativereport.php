<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");

$fromdate_actual=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate_actual=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);
 
$thismonth=$year."-".$month."___";

$todaydate = date("Y-m-d");

//echo $fromdate.'<br/>'.$todate;
//echo $_REQUEST['ADate1'];
// set ledger_id request
$ledger_id =isset($_REQUEST['ledgerid'])?$_REQUEST['ledgerid']:"";
$ledger_name =isset($_REQUEST['ledgername'])?$_REQUEST['ledgername']:"";
$searchpaymentcode =isset($_REQUEST['searchpaymentcode'])?$_REQUEST['searchpaymentcode']:"";
$viewtype =isset($_REQUEST['viewtype'])?$_REQUEST['viewtype']:"";
$accountsmaintype =isset($_REQUEST['accountsmaintype'])?$_REQUEST['accountsmaintype']:"";
$location =isset($_REQUEST['location'])?$_REQUEST['location']:"";
$accountssub =isset($_REQUEST['accountssub'])?$_REQUEST['accountssub']:"";
$skipzeroballeg = isset($_POST["skipzeroballeg"])? 0 : 1;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = "cbfrmflag1"; }
if (isset($_REQUEST["period"])) { $period = $_REQUEST["period"]; } else { $period = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('m'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
if (isset($_REQUEST["searchmonthto"])) { $searchmonthto = $_REQUEST["searchmonthto"]; } else { $searchmonthto = date('m'); }
//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	  $locationcode=$location;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparative Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/comparativereport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    <!-- External JavaScript -->
    <script src="js/datetimepicker_css.js"></script>
    <script src="datetimepicker1_css.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="jquery/jquery-1.11.3.min.js"></script>
</head>

<script language="javascript">

function funchangeperiod(id)
{
document.getElementById('dates range').style.display = 'none';
document.getElementById('monthly').style.display = 'none';
document.getElementById('monthly12').style.display = 'none';
document.getElementById('yearly').style.display = 'none';
if(id != '' )
{
document.getElementById(id).style.display = '';
if(id=='monthly'){
document.getElementById('monthly12').style.display = '';
}
}
}

 $(document).ready(function() {
	$("input:radio[name=searchpaymenttype]").click(function () {	
	
		var val=this.value;	
		$("#searchpaymentcode").val(val);
		 if(val =="2")
		{
		$("#ledgersearch").hide();
		$("#groupsearch").show();
		}else{
		$("#ledgersearch").show();
		$("#groupsearch").hide();
		}
	});
}); 

function funcAccountsMainTypeChange1()
{
	<?php 
	$query12 = "select * from master_accountsmain where recordstatus = ''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12accountsmainanum = $res12["auto_number"];
	$res12accountsmain = $res12["accountsmain"];
	?>
	if(document.getElementById("accountsmaintype").value=="<?php echo $res12accountsmainanum; ?>")
	{
		document.getElementById("accountssub").options.length=null; 
		var combo = document.getElementById('accountssub'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_accountssub where accountsmain = '$res12accountsmainanum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountssubanum = $res10['auto_number'];
		$res10accountssub = $res10["accountssub"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountssub;?>", "<?php echo $res10accountssubanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
	if(document.getElementById("accountsmaintype").value == 6)
	{
		$('#non_multicc').hide();
		$('#multicc').show();
	}
	else
	{
		$('#non_multicc').show();
		$('#multicc').hide();
	}
}

function validcheck()
{
	if(document.getElementById("searchpaymentcode").value=='2' && document.getElementById("accountsmaintype").value=='')
	{
	alert("Please select the Main Type");
	document.getElementById("accountsmaintype").focus();
	return false;
	}

	if(document.getElementById("searchpaymentcode").value=='1' && document.getElementById("ledgerid").value=='')
	{
		alert("Please Select Ledger");
		return false;
	}
	
	if(document.getElementById('period1').value =='')
	{
		alert("Please Select Period");
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
	
	
	
	if(document.getElementById('period1').value =='yearly')
	{
	
		if(document.getElementById('fromyear').value =='')
	    {
	
		alert("Please Select From Year");
		return false;
		}
		if(document.getElementById('toyear').value =='')
	    {
	
		alert("Please Select To Year");
		return false;
		}
	}


}
</script>
</head>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Comparative Report</p>
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
        <span>Reports</span>
        <span>→</span>
        <span>Comparative Report</span>
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
                    <li class="nav-item">
                        <a href="paymentmodecollectionsummary.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment Mode Collection Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paymentmodecollectionbyuser.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Payment Mode Collection by User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="revenuereport_summary.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Revenue Report Summary</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="comparativereport.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Comparative Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Comparative Report</h2>
                    <p>Generate comprehensive comparative analysis reports for ledgers and account groups.</p>
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
            <!-- Comparative Report Section -->
            <div class="comparative-report-section">
                <div class="comparative-report-header">
                    <div class="comparative-report-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <div class="comparative-report-title">Search Ledger Report</div>
                    <div class="location-display" id="ajaxlocation">
                        <i class="fas fa-map-marker-alt"></i>
                        <strong>Location:</strong>
                        <?php
                        if ($location!='') {
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
                    </div>
                </div>

                <form name="cbform1" method="post" action="comparativereport.php" onSubmit="return validcheck()" class="search-form">
     
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" name="searchpaymenttype" id="searchpaymenttype11" value="1">
                            <label for="searchpaymenttype11"><strong>Ledger</strong></label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" name="searchpaymenttype" id="searchpaymenttype12" value="2">
                            <label for="searchpaymenttype12"><strong>Group</strong></label>
                        </div>
                    </div>
                    
                    <input type="hidden" name="searchpaymentcode" id="searchpaymentcode" value="<?php echo htmlspecialchars($searchpaymentcode); ?>">
			  
			  
              <?php
              	$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where id ='$ledger_id' and recordstatus <> 'deleted'";
        		$exec_ln = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln) or die ("Error in Query_ln".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ln = mysqli_fetch_array($exec_ln);
                $ledger_name = $res_ln['accountname'];
                $account_main = $res_ln['accountsmain'];
                $account_sub = $res_ln['accountssub'];

                // account main
                $query_ln1 = "select * from master_accountsmain where auto_number ='$account_main' and recordstatus <> 'deleted'";
        		$exec_ln1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln1) or die ("Error in Query_ln1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ln1 = mysqli_fetch_array($exec_ln1);
                $acc_main_name = $res_ln1['accountsmain'];

                $tb_group = $res_ln1['tb_group'];

                 // account sub
                $query_ln2 = "select * from master_accountssub where auto_number ='$account_sub' and recordstatus <> 'deleted'";
        		$exec_ln2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln2) or die ("Error in Query_ln2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ln2 = mysqli_fetch_array($exec_ln2);
                $acc_sub_name = $res_ln2['accountssub'];
              ?>
			 
                    <div id="ledgersearch" class="form-row">
                        <div class="form-group">
                            <label for="ledgername" class="form-label">Ledger Name</label>
                            <div class="ledger-search-input">
                                <input type="text" name="ledgername" id="ledgername" value="<?php echo htmlspecialchars($ledger_name); ?>" class="form-input" placeholder="Type to search ledgers...">
                                <input type="hidden" name="ledgerid" id="ledgerid" value="<?php echo htmlspecialchars($ledger_id); ?>">
                            </div>
                        </div>
                    </div>
				
                    <div id="groupsearch" class="form-row">
                        <div class="form-group">
                            <label for="accountsmaintype" class="form-label">Main Type</label>
                            <select name="accountsmaintype" id="accountsmaintype" onChange="return funcAccountsMainTypeChange1()" class="form-select">
                                <option value="" selected="selected">Select Type</option>
                                <?php
                                $query5 = "select * from master_accountsmain where recordstatus = '' order by id";
                                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res5 = mysqli_fetch_array($exec5)) {
                                    $res5accountsmainanum = $res5["auto_number"];
                                    $res5accountsmain = $res5["accountsmain"];
                                ?>
                                <option value="<?php echo htmlspecialchars($res5accountsmainanum); ?>" <?php if($accountsmaintype==$res5accountsmainanum) { echo 'selected'; } ?>><?php echo htmlspecialchars($res5accountsmain); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="accountssub" class="form-label">Sub Type</label>
                            <select name="accountssub" id="accountssub" class="form-select">
                                <option value="">Select Sub Type</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="viewtype" class="form-label">Type</label>
                            <select name="viewtype" id="viewtype" class="form-select">
                                <option value="summary" <?php if($viewtype=='summary'){ echo 'selected'; } ?>>Summary</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" name="skipzeroballeg" id="skipzeroballeg" value='1' <?php if($skipzeroballeg=='0') { echo 'checked'; } ?>>
                                <label for="skipzeroballeg"><strong>Skip Zero Balance Ledgers</strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select">
                                <option value="All">All</option>
                                <?php
                                $query1 = "select * from master_location where status='' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $loccode=array();
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                ?>
                                <option value="<?php echo htmlspecialchars($locationcode); ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo htmlspecialchars($locationname); ?></option>
                                <?php
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="period1" class="form-label">Period</label>
                            <select name="period" id="period1" onChange="funchangeperiod(this.value);" class="form-select">
                                <?php if($period != '') { ?>
                                <option value="<?php echo htmlspecialchars($period); ?>"><?php echo ucwords($period); ?></option>
                                <?php } else { ?>
                                <option value="">Select Period</option>
                                <?php } ?>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                    </div>
					
                    <div id="monthly" class="period-option" style="display:none">
                        <div class="month-year-selectors">
                            <div class="form-group">
                                <label for="searchmonth" class="form-label">From Month</label>
                                <select name="searchmonth" id="searchmonth" class="form-select">
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
                                <select name="searchmonthto" id="searchmonthto" class="form-select">
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
					
                    <div id="monthly12" class="period-option" style="display:none">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="searchyear" class="form-label">Select Year</label>
                                <select name="searchyear" id="searchyear" class="form-select">
                                    <?php if($searchyear != ''){ ?>
                                        <option value="<?php echo htmlspecialchars($searchyear); ?>"><?php echo htmlspecialchars($searchyear); ?></option>
                                    <?php } ?>
                                    <option value="">Select Year</option>
                                    <?php $years = range(2023, strftime("2025", time())); ?>
                                    <?php foreach($years as $year1) : ?>
                                        <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
					
                    <div id="yearly" class="period-option" style="display:none">
                        <div class="month-year-selectors">
                            <div class="form-group">
                                <label for="fromyear" class="form-label">From Year</label>
                                <select name="fromyear" id="fromyear" class="form-select">
                                    <?php if($fromyear != ''){ ?>
                                        <option value="<?php echo htmlspecialchars($fromyear); ?>"><?php echo htmlspecialchars($fromyear); ?></option>
                                    <?php } ?>
                                    <option value="">Select Year</option>
                                    <?php foreach($years as $year1) : ?>
                                        <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="toyear" class="form-label">To Year</label>
                                <select name="toyear" id="toyear" class="form-select">
                                    <?php if($toyear != ''){ ?>
                                        <option value="<?php echo htmlspecialchars($toyear); ?>"><?php echo htmlspecialchars($toyear); ?></option>
                                    <?php } ?>
                                    <option value="">Select Year</option>
                                    <?php foreach($years as $year1) : ?>
                                        <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
			
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="submit" name="download" class="btn btn-success">
                            <i class="fas fa-download"></i> Excel Download
                        </button>
                    </div>
                </form>
            </div>
			  <?php if(isset($_POST['download'])){ } else{ $download="aaa";} ?>
	          <tr>
	          	<!--<td colspan="" align="left" valign="right"  bgcolor="#ffffff">&nbsp;<td>-->
	          </tr>
          </tbody>
        </table>
</form>	
	<?php
		if(isset($_POST['download'])){ ?>
		<script>
		window.location = 'comparativereport_xl.php?ledgerid=<?php echo $ledger_id;?>&&ADate1=<?php echo $fromdate_actual; ?>&&ADate2=<?php echo $todate_actual; ?>&&ledgername=<?php echo $ledger_name; ?>&&searchpaymentcode=<?php echo $searchpaymentcode; ?>&&viewtype=<?php echo $viewtype; ?>&&accountsmaintype=<?php echo $accountsmaintype; ?>&&accountssub=<?php echo $accountssub; ?>&&skipzeroballeg=<?php echo $skipzeroballeg; ?>&&location=<?php echo $location; ?>&&period=<?php echo $period; ?>&&searchmonth=<?php echo $searchmonth; ?>&&searchyear=<?php echo $searchyear; ?>&&fromyear=<?php echo $fromyear; ?>&&toyear=<?php echo $toyear; ?>&&searchmonthto=<?php echo $searchmonthto; ?>';
		
		var gg=$('#searchpaymentcode').val();	
		if(gg==''){
		$("#searchpaymenttype11").trigger('click');
		$("#ledgername").focus();
		}

		if(gg=='1'){
		$("#ledgersearch").show();	
		$("#groupsearch").hide();	
		$("#searchpaymenttype11").prop("checked", true);
		$("#searchpaymenttype12").prop("checked", false);
		}else if(gg=='2') {
		$("#ledgersearch").hide();		
		$("#groupsearch").show();
		$("#searchpaymenttype11").prop("checked", false);
		$("#searchpaymenttype12").prop("checked", true);
		}
		
		</script>
		<?php exit(); } 
		
		
			if($cbfrmflag1=='cbfrmflag1'){
		
			if($location=='All'){
			$locationcodenew= "locationcode like '%%'";
			}else{
			$locationcodenew= "locationcode = '$location'";
			}	
			
	?>
		
	<table width="980" border="0" cellspacing="0" cellpadding="0" style="margin:30px;">
		<tr>
		<td colspan="2">&nbsp;</td>
		</tr>
	</table>
	<table width="110%" border="0" cellspacing="0" cellpadding="0">

		<tr id="data">
		<td>
		
		<?php if($searchpaymentcode=='1') {?>
		
		<?php if($period == 'monthly'){ // monthlyy
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        ?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" align="left" border="0">
          <tbody>
          	<tr>
                <td colspan="12" bgcolor="" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name.' '.'>'.' '.$ledger_name.' '.' >'.'Ledger ID'.' '.'( '.$ledger_id.' )';
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
			<tr>
				<td width="15%" bgcolor="#ffffff" class="bodytext31"  align="center"><strong>Ledger Name</strong></td>
			<?php 
			for($i = $searchmonth; $i <= $searchmonthto; $i++){
			$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
			$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
			$month = $months[$i];
			?>
			
				
				<td width="" bgcolor="#ffffff" class="bodytext31"  align="right"><strong><?php echo $month; ?></strong></td>
				<td width="" bgcolor="#ffffff" class="bodytext31" align="right"><strong>Delta</strong></td>
			
			<?php } ?>
			</tr>
			
			<tr>
		
			<td width="15%" align="left" valign="left" bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo $ledger_name; ?></strong></td>
			<?php 
			$deltamonbal=0;
			for($i = $searchmonth; $i <= $searchmonthto; $i++){
			$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
			$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
			$month = $months[$i];
			$running_bal=0;
			$opening_bal=0;
			$deltabal=0;
					$sno = 0;
					//run previous
					$deltavalue=0;
					$closing_bal = 0;
					$total_c = 0;
					$total_d = 0;
					$debit_amount = 0;
					$credit_amount = 0;
					$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$monthlystartdate' and '$monthlyenddate' and $locationcodenew order by transaction_date asc";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num2=mysqli_num_rows($exec2);
					while($res2 = mysqli_fetch_array($exec2))
					{
					//var_dump($res2);
					$tb_auto_number = $res2["auto_number"];
					$transaction_date = $res2["transaction_date"];
					$transaction_type = $res2['transaction_type'];
					$transaction_number = $res2['doc_number'];
					$locationcode = $res2['locationcode'];
					$reference_no = $res2['refno'];
					$sno = $sno + 1;
						if($transaction_type == 'C'){
							$credit_amount+= $res2['transaction_amount'];
						}else{
							$credit_amount+= '0.00';
						}

						if($transaction_type == 'D'){
							$debit_amount+= $res2['transaction_amount'];
						}else{
							$debit_amount+= '0.00';
						}
				
					}
					if($tb_group == 'A' || $tb_group == 'E' )
					{		
					$running_bal=$credit_amount-$debit_amount;
					} elseif($tb_group == 'I' || $tb_group == 'L' ) {
					$running_bal=$debit_amount+$credit_amount;	
					}
					
					if($running_bal>0){
					$deltavalue=(($running_bal-$deltamonbal)/$running_bal)*100;
					}else{
					$deltavalue=0;	
					}
					
				?>
			
				<td width="8%" align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo number_format((float)$running_bal, 2, '.', ','); ?></strong></td>
				<td width="8%" align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo number_format($deltavalue,2,'.',','); ?> %</strong></td>
		
			<?php  $deltamonbal=$running_bal;	} ?>
			</tr>
			</tbody>
		</table>
		<?php } ?>
		<?php  if($period == 'yearly'){ ?>
		
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="550"    align="left" border="0">
          <tbody>
          	<tr>
                <td colspan="7" bgcolor="" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name.' '.'>'.' '.$ledger_name.' '.' >'.'Ledger ID'.' '.'( '.$ledger_id.' )';
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
			<tr>
			<td colspan="2" bgcolor="#4fc7fd" class="bodytext31"  align="center"><strong>Yearly</strong></td>
			<?php
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
			{
			$date = $year; 
			?>
			<td colspan="2" bgcolor="#4fc7fd" class="bodytext31"  align="center"><strong><?php echo $date; ?></strong></td>
			<td colspan="1" bgcolor="#4fc7fd" class="bodytext31"  align="center"><strong>Delta</strong></td>
			<?php
			}
			?>
			</tr>
			
			<tr>
			<td colspan="2" align="left" valign="left" bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo $ledger_name; ?></strong></td>
			<?php 
			$deltamonbal=0;
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
			{
			//echo $year.'<br>';
			$date = $year;
			$fromdate = date('Y-m-d',strtotime('01-01-'.$date));
			$todate = date('Y-m-t',strtotime('01-12-'.$date));
			?>
			<?php
					$sno = 0;
					//run previous
					$deltavalue=0;
					$closing_bal = 0;
					$total_c = 0;
					$total_d = 0;
					$debit_amount = 0;
					$credit_amount = 0;
				 	$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$fromdate' and '$todate' and $locationcodenew order by transaction_date asc";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num2=mysqli_num_rows($exec2);
					while($res2 = mysqli_fetch_array($exec2))
					{
					//var_dump($res2);
					$tb_auto_number = $res2["auto_number"];
					$transaction_date = $res2["transaction_date"];
					$transaction_type = $res2['transaction_type'];
					$transaction_number = $res2['doc_number'];
					$locationcode = $res2['locationcode'];
					$reference_no = $res2['refno'];
					$sno = $sno + 1;
						if($transaction_type == 'C'){
							$credit_amount+= $res2['transaction_amount'];
						}else{
							$credit_amount+= '0.00';
						}

						if($transaction_type == 'D'){
							$debit_amount+= $res2['transaction_amount'];
						}else{
							$debit_amount+= '0.00';
						}
				
					}
					if($tb_group == 'A' || $tb_group == 'E' )
					{		
					$running_bal=$credit_amount-$debit_amount;
					} elseif($tb_group == 'I' || $tb_group == 'L' ) {
					$running_bal=$debit_amount+$credit_amount;	
					}
					if($running_bal>0){
					$deltavalue=(($running_bal-$deltamonbal)/$running_bal);
					}else{
					$deltavalue=0;	
					}
					
				?>
			
				
				<td colspan="2" align="center" valign="center" bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo number_format((float)$running_bal, 2, '.', ','); ?></strong></td>
				<td width="" align="center" valign="center" bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo number_format($deltavalue,2,'.',','); ?> %</strong></td>
			
			
			
			
			<?php  $deltamonbal=$running_bal;	 } ?>
			</tr>
			
			
			</tbody>
		</table>
		
		<?php } ?>
		
		<?php } else { ?>
		<?php if($period == 'monthly'){ // monthlyy
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        ?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" align="left" border="0">
          <tbody>
		<?php
		$ledgertotamt=0;
		$count=0;
		$oldaccsub='';
		$colorloopcount=0;
		if($accountsmaintype!='' && $accountssub==''){
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountsmain ='$accountsmaintype'  and recordstatus <> 'deleted'";
		}elseif($accountsmaintype!='' && $accountssub!=''){
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountsmain ='$accountsmaintype' and accountssub='$accountssub' and recordstatus <> 'deleted'";	
		}
	
		$exec_ln = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln) or die ("Error in Query_ln".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res_ln = mysqli_fetch_array($exec_ln)){
		$ledger_id = $res_ln['id'];
		$ledger_name = $res_ln['accountname'];
		$account_main = $res_ln['accountsmain'];
		$account_sub = $res_ln['accountssub'];
		$count++;
		
		// account main
		$query_ln1 = "select * from master_accountsmain where auto_number ='$account_main' and recordstatus <> 'deleted'";
		$exec_ln1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln1) or die ("Error in Query_ln1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln1 = mysqli_fetch_array($exec_ln1);
		$acc_main_name = $res_ln1['accountsmain'];
		$tb_group = $res_ln1['tb_group'];

		// account sub
		$query_ln2 = "select * from master_accountssub where auto_number ='$account_sub' and recordstatus <> 'deleted'";
		$exec_ln2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln2) or die ("Error in Query_ln2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln2 = mysqli_fetch_array($exec_ln2);
		$acc_sub_name = $res_ln2['accountssub'];
		
		
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
		
		
		if($oldaccsub!=$acc_sub_name){
		?>
          	<tr>
                <td colspan="12" bgcolor="" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name;
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
			<tr>
				<td width="17%" bgcolor="#4fc7fd" class="bodytext31" align="center"><strong>Leger Name</strong></td>
				<?php 
				for($i = $searchmonth; $i <= $searchmonthto; $i++){
				$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
				$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
				$month = $months[$i];
				?>
				<td bgcolor="#4fc7fd" class="bodytext31" align="right"><strong><?php echo $month; ?></strong></td>
				<td bgcolor="#4fc7fd" class="bodytext31" align="right"><strong>Delta</strong></td>
				<?php } ?>
			</tr>
			<?php } 
			$searchmntfrom=date($searchyear.'-'.'0'.$searchmonth.'-01');
			$searchmntto=date($searchyear.'-'.$searchmonthto.'-31');
			$comp_ledgtotamt=0;
			$query25 = "select sum(transaction_amount) as ledgtotamt from tb where ledger_id='$ledger_id' and transaction_date between '$searchmntfrom' and '$searchmntto' and $locationcodenew order by transaction_date asc";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25);
			$comp_ledgtotamt = $res25["ledgtotamt"];
			if($comp_ledgtotamt!=0 || $skipzeroballeg=='1'){
			?>
			<tr <?php echo $colorcode; ?>>
			<td width="" align="left" valign="left" class="bodytext31"><strong><?php echo $ledger_name; ?></strong></td>
			<?php 
			$deltamonbal=0;
			for($i = $searchmonth; $i <= $searchmonthto; $i++){
			$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
			$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
			$month = $months[$i];
			$running_bal=0;
			$opening_bal=0;
			$deltabal=0;
				$sno = 0;
				
				//run previous
				$deltavalue=0;
				$closing_bal = 0;
				$total_c = 0;
				$total_d = 0;
				$debit_amount = 0;
				$credit_amount = 0;
				$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$monthlystartdate' and '$monthlyenddate' and $locationcodenew order by transaction_date asc";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2=mysqli_num_rows($exec2);
				while($res2 = mysqli_fetch_array($exec2))
				{
				//var_dump($res2);
				$tb_auto_number = $res2["auto_number"];
				$transaction_date = $res2["transaction_date"];
				$transaction_type = $res2['transaction_type'];
				$transaction_number = $res2['doc_number'];
				$locationcode = $res2['locationcode'];
				$reference_no = $res2['refno'];
				$sno = $sno + 1;
					if($transaction_type == 'C'){
						$credit_amount+= $res2['transaction_amount'];
					}else{
						$credit_amount+= '0.00';
					}

					if($transaction_type == 'D'){
						$debit_amount+= $res2['transaction_amount'];
					}else{
						$debit_amount+= '0.00';
					}
			
				}
				if($tb_group == 'A' || $tb_group == 'E' )
				{		
				$running_bal=$credit_amount-$debit_amount;
				} elseif($tb_group == 'I' || $tb_group == 'L' ) {
				$running_bal=$debit_amount+$credit_amount;	
				}
				
				if($running_bal>0){
				$deltavalue=(($running_bal-$deltamonbal)/$running_bal)*100;
				}else{
				$deltavalue=0;	
				}
				
				
				
			?>
		
			<td width="" align="right" valign="center"  class="bodytext31"><strong><?php echo number_format((float)$running_bal, 2, '.', ','); ?></strong></td>
			<td width="" align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($deltavalue,2,'.',','); ?> %</strong></td>
		
			<?php  $deltamonbal=$running_bal;	} ?>
			</tr>
			
			
			<?php } $oldaccsub=$acc_sub_name; } ?>
			</tbody>
		</table>
		<?php } ?>
		<?php  if($period == 'yearly'){ ?>
		
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="50%" align="left" border="0">
          <tbody>
		<?php
		$count=0;
		$oldaccsub='';
		$colorloopcount=0;
		if($accountsmaintype!='' && $accountssub==''){
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountsmain ='$accountsmaintype'  and recordstatus <> 'deleted'";
		}elseif($accountsmaintype!='' && $accountssub!=''){
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountsmain ='$accountsmaintype' and accountssub='$accountssub' and recordstatus <> 'deleted'";	
		}
	
		$exec_ln = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln) or die ("Error in Query_ln".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res_ln = mysqli_fetch_array($exec_ln)){
		$ledger_id = $res_ln['id'];
		$ledger_name = $res_ln['accountname'];
		$account_main = $res_ln['accountsmain'];
		$account_sub = $res_ln['accountssub'];
		$count++;
		
		// account main
		$query_ln1 = "select * from master_accountsmain where auto_number ='$account_main' and recordstatus <> 'deleted'";
		$exec_ln1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln1) or die ("Error in Query_ln1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln1 = mysqli_fetch_array($exec_ln1);
		$acc_main_name = $res_ln1['accountsmain'];
		$tb_group = $res_ln1['tb_group'];

		// account sub
		$query_ln2 = "select * from master_accountssub where auto_number ='$account_sub' and recordstatus <> 'deleted'";
		$exec_ln2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln2) or die ("Error in Query_ln2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln2 = mysqli_fetch_array($exec_ln2);
		$acc_sub_name = $res_ln2['accountssub'];
		
		
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
		
		
		if($oldaccsub!=$acc_sub_name){
		?>
          	<tr>
                <td colspan="12" bgcolor="" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name;
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
			<tr>
				<td width="12%" bgcolor="#4fc7fd" class="bodytext31" align="center"><strong>Leger Name</strong></td>
				<?php 
				for($year = $fromyear;$year <= $toyear;$year++) // Show Years
				{
				$date = $year; 
				?>
				<td bgcolor="#4fc7fd" class="bodytext31" align="right"><strong><?php echo $date; ?></strong></td>
				<td bgcolor="#4fc7fd" class="bodytext31" align="right"><strong>Delta</strong></td>
				<?php } ?>
			</tr>
			<?php } 
			$searchmntfrom=date($searchyear.'-'.'0'.$searchmonth.'-01');
			$searchmntto=date($searchyear.'-'.$searchmonthto.'-31');
			$comp_ledgtotamt=0;
			$query25 = "select sum(transaction_amount) as ledgtotamt from tb where ledger_id='$ledger_id' and transaction_date between '$searchmntfrom' and '$searchmntto' and $locationcodenew order by transaction_date asc";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25);
			$comp_ledgtotamt = $res25["ledgtotamt"];
			if($comp_ledgtotamt!=0 || $skipzeroballeg=='1'){
			
			?>
			<tr <?php echo $colorcode; ?>>
			<td width="" align="left" valign="left" class="bodytext31"><strong><?php echo $ledger_name; ?></strong></td>
			<?php 
			$deltamonbal=0;
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
			{
			$date = $year;
			$fromdate = date('Y-m-d',strtotime('01-01-'.$date));
			$todate = date('Y-m-t',strtotime('01-12-'.$date));		
			$running_bal=0;
			$opening_bal=0;
			$deltabal=0;
				$sno = 0;
				
				//run previous
				$deltavalue=0;
				$closing_bal = 0;
				$total_c = 0;
				$total_d = 0;
				$debit_amount = 0;
				$credit_amount = 0;
				$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$fromdate' and '$todate' and $locationcodenew order by transaction_date asc";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2=mysqli_num_rows($exec2);
				while($res2 = mysqli_fetch_array($exec2))
				{
				//var_dump($res2);
				$tb_auto_number = $res2["auto_number"];
				$transaction_date = $res2["transaction_date"];
				$transaction_type = $res2['transaction_type'];
				$transaction_number = $res2['doc_number'];
				$locationcode = $res2['locationcode'];
				$reference_no = $res2['refno'];
				$sno = $sno + 1;
					if($transaction_type == 'C'){
						$credit_amount+= $res2['transaction_amount'];
					}else{
						$credit_amount+= '0.00';
					}

					if($transaction_type == 'D'){
						$debit_amount+= $res2['transaction_amount'];
					}else{
						$debit_amount+= '0.00';
					}
			
				}
				if($tb_group == 'A' || $tb_group == 'E' )
				{		
				$running_bal=$credit_amount-$debit_amount;
				} elseif($tb_group == 'I' || $tb_group == 'L' ) {
				$running_bal=$debit_amount+$credit_amount;	
				}
				
				if($running_bal>0){
				$deltavalue=(($running_bal-$deltamonbal)/$running_bal)*100;
				}else{
				$deltavalue=0;	
				}
				
				
				
			?>
		
			<td width="8%" align="right" valign="center"  class="bodytext31"><strong><?php echo number_format((float)$running_bal, 2, '.', ','); ?></strong></td>
			<td width="8%" align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($deltavalue,2,'.',','); ?> %</strong></td>
		
			<?php  $deltamonbal=$running_bal;	} ?>
			</tr>
			
			
			<?php } $oldaccsub=$acc_sub_name; } ?>
			</tbody>
		</table>
		
		
		<?php } ?>
		<?php } ?>
		</td>
		</tr>
	</table>
		<?php } ?>
</td>
</tr>
</table>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<?php 
if($period != '')
{
echo "<script>funchangeperiod('".$period."');</script>";
}
?>
<script type="text/javascript">
$(function() {

    $('#ledgername').autocomplete({
		
	source:'trial_accountnamefinanceajax.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				//var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				//$('#saccountauto').val(saccountauto);	
				$('#ledgerid').val(saccountid);	
			}
    });
});

function showsub(subtypeano)
{
if(document.getElementById(subtypeano) != null)
{
if(document.getElementById(subtypeano).style.display == 'none')
{
document.getElementById(subtypeano).style.display = '';
}
else
{
document.getElementById(subtypeano).style.display = 'none';
}
}
}
$(document).ready(function(e) {
	var gg=$('#searchpaymentcode').val();	
	if(gg==''){
    $("#searchpaymenttype11").trigger('click');
	$("#ledgername").focus();
	}
	
	if(gg=='1'){
	$("#ledgersearch").show();	
	$("#groupsearch").hide();	
	$("#searchpaymenttype11").prop("checked", true);
	$("#searchpaymenttype12").prop("checked", false);
	}else if(gg=='2') {
	$("#ledgersearch").hide();		
	$("#groupsearch").show();
	$("#searchpaymenttype11").prop("checked", false);
	$("#searchpaymenttype12").prop("checked", true);
	}
	var gwg=$('#skipzeroballeg').val();	
	if(gwg=='1'){
	$("#skipzeroballeg").prop("checked", true);
	}
}); 
</script>
<?php 
function getfromdate($fromdate){
	$timestamp = strtotime($fromdate);
	$year = date("Y", $timestamp);
	$fromdate = "$year-01-01";
	return $fromdate;
}
function gettodate($fromdate){
	$enddate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
	return $enddate;
}
?>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/comparativereport-modern.js?v=<?php echo time(); ?>"></script>
</body>
