<?php
// Inpatient Admission TAT Report - Modernized Version
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

// Date range handling
if (isset($_REQUEST['ADate1'])) {
    $transactiondatefrom = $_REQUEST['ADate1'];
} else {
    $transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
}

if (isset($_REQUEST['ADate2'])) {
    $transactiondateto = $_REQUEST['ADate2'];
} else {
    $transactiondateto = date('Y-m-d');
}

// Initialize other variables
$packagename1 = "";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";



// Location handling
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
if ($location != '') {
    $locationcode = $location;
}

// Form processing and error handling
$bgcolorcode = "";

if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1') {
    $fromdate = isset($_POST['ADate1']) ? $_POST['ADate1'] : '';
    $todate = isset($_POST['ADate2']) ? $_POST['ADate2'] : '';
    
    if (empty($fromdate) || empty($todate)) {
        $errmsg = "Please select both From Date and To Date.";
        $bgcolorcode = "failed";
    } elseif (empty($location)) {
        $errmsg = "Please select a location.";
        $bgcolorcode = "failed";
    } else {
        $errmsg = "TAT Report generated successfully.";
        $bgcolorcode = "success";
    }
}







if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag2 == 'frmflag2')

{

	 //get locationcode and locationname for inserting

 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';

 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

//get ends here

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

	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)

	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 

	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 

	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}

		else

		{

		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 

	transactionparticular, billautonumber, billnumber, quantity, remarks, 

	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)

	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 

	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 

	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

		}

		}

	header("location:stockadjustment.php");

	exit;

	

}



// Success/Error message handling
if (isset($_REQUEST["st"])) { 
    $st = $_REQUEST["st"]; 
} else { 
    $st = ""; 
}

if ($st == '1') {
    $errmsg = "Success. TAT Report Update Completed.";
    $bgcolorcode = "success";
}

if ($st == '2') {
    $errmsg = "Failed. TAT Report Not Completed.";
    $bgcolorcode = "failed";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inpatient Admission TAT Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipadmission-tat-modern.css?v=<?php echo time(); ?>">
    
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

<script language="javascript">



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







function cbsuppliername1()

{

	document.cbform1.submit();

}







</script>

<script type="text/javascript">



function funcSubTypeChange1()

{

	<?php 

	$query12 = "select * from master_location";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	 $res12subtypeanum = $res12["auto_number"];

	$res12locationname = $res12["locationname"];

	$res12locationcode = $res12["locationcode"];

	?>



	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")

	{



		document.getElementById("ward").options.length=null; 

		var combo = document.getElementById('ward'); 	

		<?php 

		$loopcount=0; 

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 

		<?php

		$query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10accountnameanum = $res10["auto_number"];

		$ward = $res10["ward"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 

		<?php 

		}

		?>

	}

	<?php

	}

	?>	

}

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
    <!-- Loading Overlay -->
    <div id="imgloader" class="loading-overlay" style="display:none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>Generating TAT Report</strong></p>
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
        <span>Inpatient Admission TAT Report</span>
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
                    <li class="nav-item">
                        <a href="ipaccountwiselist.php" class="nav-link">
                            <i class="fas fa-file-medical-alt"></i>
                            <span>IP Account Wise List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="ipadmissionlist_tat.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>IP Admission TAT</span>
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
                    <h2>Inpatient Admission TAT Report</h2>
                    <p>Monitor turnaround times from admission to bed allocation for quality improvement.</p>
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
                    <i class="fas fa-clock form-icon"></i>
                    <h3 class="form-title">TAT Report Search</h3>
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
                
                <form name="cbform1" method="post" action="ipadmissionlist_tat.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onChange="funcSubTypeChange1(); ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
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
                            <input type="hidden" name="locationcodeget" value="<?php echo isset($locationcodeget) ? $locationcodeget : ''; ?>">
                            <input type="hidden" name="locationnameget" value="<?php echo isset($locationnameget) ? $locationnameget : ''; ?>">
                        </div>
                        
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
                        
                        <div class="form-group form-group-submit">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" name="Submit" class="submit-btn" onClick="return funcvalidcheck();">
                                <i class="fas fa-search"></i>
                                Generate TAT Report
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
                $locationcode = $_REQUEST['location'];
            ?>

                <!-- TAT Results Table -->
                <div class="results-section">
                    <div class="section-header">
                        <i class="fas fa-chart-line"></i>
                        <h3>TAT Report Results</h3>
                        <div class="export-actions">
                            <a target="_blank" href="ipadmissionlist_tatxl.php?cbfrmflag1=cbfrmflag1&location=<?php echo $location; ?>&ADate1=<?php echo $transactiondatefrom;?>&ADate2=<?php echo $transactiondateto; ?>" class="btn btn-outline">
                                <i class="fas fa-file-excel"></i>
                                Export to Excel
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="tat-table">
                            <thead>
                                <tr>
                                    <th class="serial-header">No.</th>
                                    <th class="patient-header">Patient Name</th>
                                    <th class="reg-header">Reg No</th>
                                    <th class="visit-header">IP Visit</th>
                                    <th class="admission-header">Admission Date</th>
                                    <th class="allocation-header">Bed Allocation Date</th>
                                    <th class="tat-header">TAT (H:M)</th>
                                </tr>
                            </thead>
                            <tbody>

            

			<?php

			$sno=1;

			$query110 = "select * from consultation_ipadmission where locationcode='$locationcode' and updatedatetime between '$transactiondatefrom' and '$transactiondateto' group by updatedatetime order by updatedatetime desc";

			$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		    while($res50 = mysqli_fetch_array($exec50))

		    {  

				

				$reqDate=$res50['updatedatetime'];

                $reqDate = date('y-m-d',strtotime($reqDate));

				$showcolor = ($sno & 1); 

				if ($showcolor == 0)

				{

					$colorcode = 'bgcolor="#CBDBFA"';

				}

				else

				{

					$colorcode = 'bgcolor="#ecf0f5"';

				}



			  $query221 = "select visitcode from master_ipvisitentry where patientcode = '".$res50['patientcode']."' and consultationdate>='$reqDate' order by auto_number asc limit 0,1";



			  $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res221 = mysqli_fetch_array($exec221);

			  $visitcode = $res221['visitcode'];



			  $query1 = "select * from ip_bedallocation where visitcode = '$visitcode'";

              $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

              $res1 = mysqli_fetch_array($exec1);

              $billdate = $res1['recorddate']; 

              $billtime = $res1['recordtime']; 



			  if($billdate!='') {

				  $diff = intval((strtotime($billdate.' '.$billtime) - strtotime($res50['updatedatetime']))/60);

                  //$hoursstay = $diff / ( 60 * 60 );

				  $hoursstay = intval($diff/60);

                  $minutesstay = $diff%60;

				  $los=$hoursstay.':'.$minutesstay;

			  }

			  else

				  $los= '';

		         

			?>





                                <tr class="table-row">
                                    <td class="serial-cell"><?php echo $sno; ?></td>
                                    <td class="patient-cell"><?php echo htmlspecialchars($res50['patientname']); ?></td>
                                    <td class="reg-cell"><?php echo htmlspecialchars($res50['patientcode']); ?></td>
                                    <td class="visit-cell"><?php echo htmlspecialchars($visitcode); ?></td>
                                    <td class="admission-cell"><?php echo htmlspecialchars($res50['updatedatetime']); ?></td>
                                    <td class="allocation-cell"><?php echo htmlspecialchars($billdate.' '.$billtime); ?></td>
                                    <td class="tat-cell <?php echo !empty($los) ? 'tat-available' : 'tat-pending'; ?>">
                                        <?php echo !empty($los) ? $los : 'Pending'; ?>
                                    </td>
                                </tr>

             

		<?php	

		   $sno++;

		  }

			?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipadmission-tat-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



