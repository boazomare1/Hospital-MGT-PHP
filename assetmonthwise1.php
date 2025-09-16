<?php

session_start();

$pagename = '';

//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.

if (!isset($_SESSION['username'])) header ("location:index.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$recorddate = date('Y-m-d');

$sessionusername = $_SESSION['username'];

$username = $_SESSION['username'];

$errmsg = '';

$bgcolorcode = '';

$colorloopcount = '';

$month = date('M-Y');

$sno = '';

$docno = $_SESSION['docno'];



	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	$locationname = $res1["locationname"];

	$locationcode = $res1["locationcode"];  



if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }

if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }



if (isset($_REQUEST["assignmonth1"])) { $assignmonth1 = $_REQUEST["assignmonth1"]; } else { $assignmonth1 = date('M-Y'); }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if (isset($_REQUEST["frmflag34"])) { $frmflag34 = $_REQUEST["frmflag34"]; } else { $frmflag34 = ""; }



//$frmflag1 = $_REQUEST['frmflag1'];

if ($frmflag1 == 'frmflag1')

{

	$assignmonth = $_REQUEST['assignmonth'];

	$recorddate = date('Y-m-t',strtotime($recorddate));

	

	for($i=1;$i<200;$i++)

	{

		if(isset($_REQUEST['serialnumbermonth'.$i]))

		{

			$serialnumber = $_REQUEST['serialnumbermonth'.$i];

			

			if($serialnumber != '')

			{

				$depreciation = $_REQUEST['depreciation'.$i];

				$aid = $_REQUEST['aid'.$i];

				$anum = $_REQUEST['anum'.$i];

				

				$query23 = "SELECT `id` FROM `depreciation_information` WHERE processmonth = '$assignmonth' AND `id` = '$aid'";

				$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

				$rows23 = mysqli_num_rows($exec23);

				if($rows23 == 0)

				{

					$query11 = "INSERT INTO `depreciation_information`(`category`, `itemname`, `fixedassetscode`, `fixedassets`, `id`, `assetvalue`, `assetlife`, 

					`salvagevalue`, `depreciationacc`, `depreciationcode`, `startyear`, `location`, `recordstatus`, `locationcode`, `locationname`, `accumulateddepreciation`, `accumulateddepreciationcode`)

					SELECT `category`, `itemname`, `fixedassetscode`, `fixedassets`, `id`, `assetvalue`, `assetlife`, 

					`salvagevalue`, `depreciationacc`, `depreciationcode`, `startyear`, `location`, `recordstatus`, `locationcode`, `locationname`, `accumulateddepreciation`, `accumulateddepreciationcode` from asset_information WHERE `auto_number` = '$anum'";

					$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

					

					$insertid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

					

					$query12 = "UPDATE `depreciation_information` SET `depreciation` = '$depreciation', `username` = '$username', `recorddate` = '$recorddate', `updatedatetime` = '$updatedatetime', `processmonth` = '$assignmonth' WHERE `auto_number` = '$insertid'";

					$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

				}

			}		

		}

	}

	

	header("location:assetmonthwise1.php?st=success");

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == 'success')

{

		$errmsg = "";

}

else if ($st == 'failed')

{

		$errmsg = "";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Monthwise - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/assetmonthwise1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
    
    <!-- Autocomplete Scripts -->
    <script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
    <script type="text/javascript" src="js/autosuggestemployeesearch13.js"></script>
    <script type="text/javascript" src="js/autoemployeeloandetails1.js"></script>
    <script type="text/javascript" src="js/autoemployeepayroll2.js"></script>



<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script language="javascript">



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

</script>



<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script src="js/datetimepicker1_css.js"></script>

<body> <!--onkeydown="escapekeypressed(event)"-->
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
        <span>Asset Monthwise</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <div class="left-sidebar">
            <div class="sidebar-header">
                <h3 class="sidebar-title">Asset Reports</h3>
                <p class="sidebar-subtitle">Asset Management & Analysis</p>
            </div>
            <ul class="sidebar-nav">
                <li><a href="assetmonthwise1.php" class="active"><i class="fas fa-calendar-alt"></i> Monthwise Report</a></li>
                <li><a href="fixedasset_depreciation_detailed_report.php"><i class="fas fa-chart-line"></i> Depreciation Detailed</a></li>
                <li><a href="fixedasset_depreciation_summary_report.php"><i class="fas fa-chart-bar"></i> Depreciation Summary</a></li>
                <li><a href="fixedasset_register.php"><i class="fas fa-list"></i> Asset Register</a></li>
                <li><a href="fixedasset_category.php"><i class="fas fa-tags"></i> Asset Categories</a></li>
                <li><a href="fixedasset_purchase.php"><i class="fas fa-plus"></i> Add Asset</a></li>
                <li><a href="fixedasset_disposal.php"><i class="fas fa-trash"></i> Asset Disposal</a></li>
                <li><a href="fixedasset_transfer.php"><i class="fas fa-exchange-alt"></i> Asset Transfer</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?>
            </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Asset Monthwise Depreciation</h2>
                <p>Manage and calculate monthly depreciation for all fixed assets with comprehensive tracking and reporting.</p>
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

        <!-- Form Section -->
        <div class="form-container">
            <h3 class="form-title"><i class="fas fa-calculator"></i> Depreciation Monthwise</h3>
            
            <form name="form1" id="reportForm" method="post" action="assetmonthwise1.php">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="assignmonth1" class="form-label">Select Month</label>
                        <div class="date-input-group">
                            <input type="text" name="assignmonth1" id="assignmonth1" readonly="readonly" value="<?php echo $assignmonth1; ?>" class="form-control date-picker">
                            <i class="fas fa-calendar-alt date-icon" onClick="javascript:NewCssCal('assignmonth1','MMMYYYY')" style="cursor:pointer"></i>
                        </div>
                    </div>
                    
                </div>
                
                <div class="form-actions">
                    <input type="hidden" name="searchdescription" id="searchdescription">
                    <input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox">
                    <input name="searchsuppliername" id="searchsuppliername" autocomplete="off" type="hidden" size="50" />
                    <input type="hidden" name="searchemployeecode" id="searchemployeecode" readonly="readonly">
                    <input type="hidden" name="frmflag34" id="frmflag34" value="frmflag34">
                    <button type="submit" name="frmsubmit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Generate Report
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearForm()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <div class="data-table-container">
            <div class="data-table-header">
                <h3 class="data-table-title"><i class="fas fa-table"></i> Asset Depreciation Data</h3>
                <div class="data-table-search">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Search assets..." id="assetSearch">
                </div>
                <div class="data-table-actions">
                    <button class="btn btn-success" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                    <button class="btn btn-warning" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
            
            <form name="form1" id="form1" method="post" action="assetmonthwise1.php">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date of Purchase</th>
                            <th>Asset Name</th>
                            <th>Salvage %</th>
                            <th>Asset Life</th>
                            <th>Asset Cost</th>
                            <th>Last Posted Month</th>
                            <th>Remaining Months</th>
                            <th>Month to Post</th>
                            <th>Depreciation</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="assignmonth" id="assignmonth" value="<?php echo $assignmonth1; ?>">

	<?php

	$query245 = "select ap.entrydate as entrydate, ai.auto_number as auto_number, ai.id as id, ai.itemname as itemname, ai.assetvalue as assetvalue, ai.assetlife as assetlife, ai.salvagevalue as salvagevalue, ai.depreciation as depreciation from asset_information AS ai JOIN assetpurchase_details AS ap ON ai.id = ap.auto_number group by ai.itemname order by ai.itemname";

	$exec245 = mysqli_query($GLOBALS["___mysqli_ston"], $query245) or die ("Error in Query245".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res245 = mysqli_fetch_array($exec245))

	{

		$assetdate = $res245['entrydate'];

		$assetid = $res245['id'];

		$anum = $res245['auto_number'];

		$assetname = $res245['itemname'];

		$assetvalue = $res245['assetvalue'];

		$assetlife = $res245['assetlife'];

		$totmonth = $assetlife * 12;

		$salvagevalue = $res245['salvagevalue'];

		$depreciation = $res245['depreciation'];

		$depreciationpm = $depreciation / 12;

		$depreciationpm = number_format($depreciationpm,2,'.','');

		

	$ordate1 = date('Y-m-d',strtotime($assignmonth1));

	$ordate2 = date('Y-m-t',strtotime($assignmonth1));

	

	$query18 = "select processmonth from depreciation_information where itemname = '$assetname' and id = '$assetid' and recordstatus <> 'deleted' order by auto_number desc";

	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res18 = mysqli_fetch_array($exec18);

	$row18 = mysqli_num_rows($exec18);

	$processmonth = $res18['processmonth'];

	$remmonth = $totmonth - $row18;

	

	$sno = $sno + 1;

	?>

	<tr>
		<td><?php echo $sno; ?></td>
		<td><?php echo $assetdate; ?></td>
		<td><strong><?php echo htmlspecialchars($assetname); ?></strong></td>
		<td><?php echo $salvagevalue; ?>%</td>
		<td><?php echo $assetlife.' Yrs'; ?></td>

		<td class="number-cell currency"><?php echo number_format($assetvalue,2); ?></td>
		<td><?php echo $processmonth; ?></td>
		<td><?php echo $remmonth; ?></td>
		<td><?php echo $assignmonth1; ?></td>
		<td>
			<input type="hidden" name="aid<?php echo $sno; ?>" id="aid<?php echo $sno; ?>" value="<?php echo $assetid; ?>">
			<input type="hidden" name="anum<?php echo $sno; ?>" id="anum<?php echo $sno; ?>" value="<?php echo $anum; ?>">
			<input type="text" name="depreciation<?php echo $sno; ?>" id="depreciation<?php echo $sno; ?>" 
			       class="table-input" readonly="readonly" value="<?php echo $depreciationpm; ?>">
		</td>
		<td class="action-buttons">
			<input type="checkbox" name="serialnumbermonth<?php echo $sno; ?>" id="serialnumbermonth<?php echo $sno; ?>" value="<?php echo $sno; ?>">
		</td>
	</tr>

	<?php

	}

	?>

	<input type="hidden" name="maxno" id="maxno" value="<?php echo $sno; ?>">

	</thead>

                    </tbody>
                </table>
                
                <div class="form-actions">
                    <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                    <input type="hidden" name="maxno" id="maxno" value="<?php echo $sno; ?>">
                    <button type="submit" name="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Submit Depreciation
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/assetmonthwise1-modern.js?v=<?php echo time(); ?>"></script>

</body>

</html>



