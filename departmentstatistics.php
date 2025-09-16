<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Statistics - MedStar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/departmentstatistics-modern.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script src="datetimepicker1_css.js"></script>
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>

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
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");


if (isset($_REQUEST["ADate1"])) { $paymentreceiveddatefrom = $_REQUEST["ADate1"]; } else { $paymentreceiveddatefrom = date('Y-m-d'); }
if (isset($_REQUEST["ADate2"])) { $paymentreceiveddateto = $_REQUEST["ADate2"]; } else { $paymentreceiveddateto = date('Y-m-d'); }

$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);
 
  $thismonth=$year."-".$month."___";

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	  $locationcode=$location;
	}
?>

<!-- Modern Hospital Header -->
<header class="hospital-header">
    <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
    <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
</header>

<!-- User Info Bar -->
<div class="user-info-bar">
    <div class="user-welcome">
        <span class="welcome-text">Welcome, <?php echo htmlspecialchars($username); ?></span>
        <span class="location-info">Company: <?php echo htmlspecialchars($companyname); ?></span>
    </div>
    <div class="user-actions">
        <a href="logout.php" class="btn btn-outline btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

<!-- Navigation Breadcrumb -->
<nav class="nav-breadcrumb">
    <a href="index.php">🏠 Home</a>
    <span>→</span>
    <span>Department Statistics</span>
</nav>

<!-- Floating Menu Toggle -->
<div class="floating-menu-toggle" id="menuToggle">
    <i class="fas fa-bars"></i>
</div>

<script language="javascript">

function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your Login.");
		document.form1.username.focus();
		return false;
	}
	else if (document.form1.password.value == "")
	{	
		alert ("Pleae Enter Your Password.");
		document.form1.password.focus();
		return false;
	}
}

function fundatesearch()
{
	alert();
	var fromdate = $("#ADate1").val();
	var todate = $("#ADate2").val();
	var sortfiled='';
	var sortfunc='';
	
	var dataString = 'fromdate='+fromdate+'&&todate='+todate;
	
	$.ajax({
		type: "POST",
		url: "opipcashbillsajax.php",
		data: dataString,
		cache: true,
		//delay:100,
		success: function(html){
		alert(html);
			//$("#insertplan").empty();
			//$("#insertplan").append(html);
			//$("#hiddenplansearch").val('Searched');
			
		}
	});
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

-->
</style>
</head>

<!-- Main Container with Sidebar -->
<div class="main-container-with-sidebar">
    <!-- Left Sidebar -->
    <div class="left-sidebar" id="leftSidebar">
        <div class="sidebar-header">
            <h3>Navigation</h3>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item active">
                    <a href="departmentstatistics.php" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        Department Statistics
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="reports.php" class="nav-link">
                        <i class="fas fa-file-alt"></i>
                        Reports
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Alert Container -->
        <div id="alertContainer">
            <?php include ("includes/alertmessages1.php"); ?>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Department Statistics</h2>
                <p>View comprehensive statistics and analytics by department</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn btn-outline" onclick="printReport()">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                    <i class="fas fa-file-excel"></i> Export
                </button>
                <button type="button" class="btn btn-outline" onclick="refreshPage()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Search Form Container -->
        <div class="search-form-container">
  <?php
  $query341 = "select * from master_employee where username = '$username' and statistics='on'";
			 $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res341 = mysqli_fetch_array($exec341);
			 $rowcount341 = mysqli_num_rows($exec341);
			/* if($rowcount341 > 0)
			 {*/
  ?>

            <form name="cbform1" method="post" action="departmentstatistics.php" class="search-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" class="form-control" onChange="ajaxlocationfunction(this.value);">
                            <option value="All">All</option>
                            <?php
                            $query1 = "select locationname,locationcode from master_location where status <> 'deleted' order by locationname";
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
                        <label for="ADate1" class="form-label">Date From</label>
                        <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>" class="form-control" readonly="readonly" onKeyDown="return disableEnterKey()" />
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>" class="form-control" readonly="readonly" onKeyDown="return disableEnterKey()" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" title="Select Date From"/>
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" title="Select Date To"/>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" name="Submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="reset" name="resetbutton" class="btn btn-outline" onclick="clearForm()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table Container -->
        <div class="data-table-container">
            <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            if ($cbfrmflag1 == 'cbfrmflag1') {
            ?>
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
      <?php
	  
        

          $snocount = 0;
          $colorloopcount = 0;
          $totalvisit =0;

          
          $locationcode = $location;
		  
			if($location=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$location'";
			}	
		
		  $qrydpt = "select auto_number,department from master_department where recordstatus <> 'deleted'";
		  $execdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qrydpt) or die("Error in qrydpt ".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($resdpt=mysqli_fetch_array($execdpt)){
		  	$dpt = $resdpt['auto_number'];
		    $dptname =  $resdpt['department'];
		    // patient in dept
		     $newwalkin="select patientcode from master_visitentry where department ='$dpt' and consultationdate between '$fromdate' and '$todate' and $pass_location";
		    $walkex=mysqli_query($GLOBALS["___mysqli_ston"], $newwalkin);
		    $walkpatient=0;
		    $walkpatient1=0;
		    while($totwalk=mysqli_fetch_array($walkex))
		    {
		    	$newwalkcode=$totwalk['patientcode'];
			$querywalk="select count(patientcode) as totalwalk from master_visitentry where patientcode='$newwalkcode' and $pass_location";  
				$querywalkex=mysqli_query($GLOBALS["___mysqli_ston"], $querywalk);
				$reswalkt=mysqli_fetch_array($querywalkex);
				$walkcount=$reswalkt['totalwalk'];
				if($walkcount>1)
				{
					$walkpatient+=1;
				}
				/*else if($walkcount==1)
				{
					$walkpatient1+=1;
				}*/
		    } ?>
            <?php
		          // color row
				  $snocount = $snocount + 1;
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
                            <td><?=$resdpt['department'];?></td>
                            <?php if($walkpatient>0) { ?>
                                <td><a href="view_deptstats.php?department_search=<?php echo $dpt; ?>&&location=<?php echo $location; ?>&&cbfrmflag1=<?php echo $cbfrmflag1; ?>&&ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>" target="_blank" class="btn btn-outline btn-sm"><?= number_format($walkpatient);?></a></td>
                            <?php } else { ?>
                                <td><?= number_format($walkpatient);?></td>
                            <?php } ?>
                        </tr>
		     <?php
			    $totalvisit +=$walkpatient; 
			    //$totalvisit1 +=$walkpatient1; 
			  ?>
		 <?php } ?>
                        <tr style="background: var(--medstar-primary); color: white; font-weight: bold;">
                            <td><strong>Total:</strong></td>
                            <td><strong><?= number_format($totalvisit);?></strong></td>
                        </tr>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Modern JavaScript -->
<script src="js/departmentstatistics-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

